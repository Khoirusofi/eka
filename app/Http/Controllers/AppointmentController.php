<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Appointment;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\AppointmentExport;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\AppointmentNotification;
use Maatwebsite\Excel\Excel as ExcelType;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;

class AppointmentController extends Controller
{
    protected array $statuses = ['pending', 'confirmed', 'cancelled', 'finished'];
    protected array $hours;

    public function __construct()
    {
        $open = (int) env('APPOINTMENT_OPEN');
        $close = (int) env('APPOINTMENT_CLOSE');

        $this->hours = array_map(function ($hour) {
            return Carbon::createFromFormat('H:i', $hour . ':00')->format('H:i');
        }, range($open, $close));
    }

    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'appointment-' . now()->format('d-m-Y');

        $start = request('start');
        $end = request('end');
        $appointments = Appointment::when($start, function ($query) use ($start) {
            $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
            return $query->where('created_at', '>=', $formattedStart);
            })
            ->when($end, function ($query) use ($end) {
                $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
                return $query->where('created_at', '<=', $formattedEnd);
            })
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        if ($type == 'csv') {
            return Excel::download(new AppointmentExport($appointments), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.appointment', [
                'appointments' => $appointments
            ]);
            return $pdf->setPaper('a4', 'landscape')->stream($filename . '.pdf');
        }
    }

    /**
     * Display the report of the resource
     */
    public function report()
    {
        $start = request('start');
        $end = request('end');

        $appointments = Appointment::when($start, function ($query) use ($start) {
            $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
            return $query->where('created_at', '>=', $formattedStart);
            })
            ->when($end, function ($query) use ($end) {
                $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
                return $query->where('created_at', '<=', $formattedEnd);
            })
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('admins.reports.appointment', [
            'appointments' => $appointments,
            'start' => $start,
            'end' => $end,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $start = request('start');
    $end = request('end');
    $status = request('status');
    $registrationNumber = request('registration_number'); // Ambil nilai input pencarian No Registrasi
    $statuses = $this->statuses;

    $user = request()->user();
    $appointments = Appointment::with('patient.user', 'service')
        ->join('patients', 'appointments.patient_id', '=', 'patients.id') // Join tabel patients
        ->when($user, function ($query) use ($user) {
            return $query->whereHas('patient', function ($query) use ($user) {
                return in_array($user->role, ['admin', 'bidan']) ? $query : $query->where('user_id', $user->id);
            });
        })
        ->when($start, function ($query) use ($start) {
            $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
            return $query->where('appointments.date', '>=', $formattedStart);
        })
        ->when($end, function ($query) use ($end) {
            $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
            return $query->where('appointments.date', '<=', $formattedEnd);
        })
        ->when($status, function ($query) use ($status) {
            return $query->where('appointments.status', $status);
        })
        ->when($registrationNumber, function ($query) use ($registrationNumber) {
            return $query->where('patients.no_registrasi', 'like', "%{$registrationNumber}%"); // Pencarian berdasarkan no_registrasi
        })
        ->orderBy('appointments.status', 'desc')
        ->orderBy('appointments.date', 'desc')
        ->orderBy('appointments.time', 'desc')
        ->select('appointments.*') // Pilih hanya kolom dari tabel appointments
        ->paginate(10)
        ->withQueryString();

    return view('patients.appointments.index', [
        'appointments' => $appointments,
        'statuses' => $statuses,
        'status' => $status,
        'start' => $start,
        'end' => $end,
        'registrationNumber' => $registrationNumber,
    ]);
}
 


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Ambil pengaturan janji temu
        $setting = Setting::first();
        
        // Periksa apakah janji temu sedang tutup
        if ($setting && !$setting->is_open) {
            return view('patients.appointments.create', [
                'appointmentStatus' => false,
                'message' => __('Janji temu sedang ditutup. Silahkan buat janji temu dilain waktu.')
            ]);
        }

        // Pastikan pengguna memiliki profil pasien
        $patient = auth()->user()->patient;
        if (!$patient) {
            return redirect()->route('patients.profile.edit')
                ->with('error', __('Lengkapi data diri untuk mulai membuat Janji Temu'));
        }
        
        // Set tanggal minimum dan maksimum
        $min = Carbon::now()->addDay()->format('Y-m-d');
        $max = Carbon::now()->addMonth()->format('Y-m-d');
        
        // Validasi input dari request
        $validated = $request->validate([
            'date' => ['nullable', 'date', "after_or_equal:$min", "before_or_equal:$max"],
        ]);
        
        // Ubah tanggal yang divalidasi menjadi instance Carbon
        $date = $validated['date'] ?? Carbon::now()->addDays()->format('Y-m-d');
        
        // Periksa apakah tanggal yang dipilih sudah lewat
        if (Carbon::parse($date)->isPast()) {
            return back()->withErrors(['date' => 'Tanggal yang dipilih sudah lewat.']);
        }
        
        // Ambil janji untuk tanggal yang diberikan
        $appointments = Appointment::where('date', $date)->get();
        
        // Ambil data layanan dan pembayaran
        $services = Service::all();
        $payments = Payment::all();
        
        // Ambil frekuensi dari tabel notifications
        $frequencies = Notification::distinct()->pluck('frequency')->toArray();
        $defaultFrequency = 'Kirim Notifikasi Melalui Email'; // Nilai default yang Anda tentukan
        
        // Memastikan default nilai ada di daftar jika tidak ada frekuensi yang ditemukan
        if (!in_array($defaultFrequency, $frequencies)) {
            $frequencies[] = $defaultFrequency;
        }
        
        // Set jadwal waktu yang tersedia
        $timetable = array_combine(
            $this->hours,
            array_map(function ($hour) use ($appointments) {
                $filled = $appointments->first(function ($appointment) use ($hour) {
                    return $appointment->time == $hour && in_array($appointment->status, ['pending', 'confirmed']);
                });
                return $filled ? false : true;
            }, $this->hours)
        );

        // Tampilkan tampilan formulir pembuatan janji temu dengan kondisi
        return view('patients.appointments.create', [
            'appointmentStatus' => $setting ? $setting->is_open : true,
            'message' => null, // Pesan ini hanya akan ditampilkan jika janji temu tutup
            'frequencies' => $frequencies,
            'defaultFrequency' => $defaultFrequency,
            'timetable' => $timetable,
            'services' => $services,
            'payments' => $payments,
            'date' => $date,
            'min' => $min,
            'max' => $max,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
    // Periksa apakah ada janji yang sudah ada pada tanggal dan waktu yang dipilih
    $filled = Appointment::where('date', $request->date)
        ->where('time', $request->time)
        ->whereIn('status', ['pending', 'confirmed'])
        ->first();

    if ($filled) {
        return redirect()
            ->back()
            ->with('error', __('Tanggal dan waktu yang dipilih sudah terisi'));
    }

    // Buat janji baru
    $appointment = Appointment::create([
        'patient_id' => request()->user()->patient->id,
        'date' => $request->date,
        'time' => $request->time,
        'status' => 'pending',
        'code' => rand(1, 10),
        'service_id' => $request->service_id,
        'payment_id' => $request->payment_id,
    ]);

    Notification::create([
        'frequency' => 'Kirim Notifikasi Melalui Email',
        'appointment_id' => $appointment->id,
    ]);

    if ($appointment->status === 'pending') {
        Mail::to($appointment->patient->user->email)
            ->send(new AppointmentNotification($appointment));
    }

    return redirect()
        ->route('patients.appointments.edit', $appointment)
        ->with('success', __('Berhasil menambahkan Janji, silakan lanjutkan ke tahap pembayaran.'));
    }


    /**
     * Add payment receipt to appointment.
     */

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $user = request()->user();
        $patient = $appointment->patient;
        if (!in_array($user->role, ['admin', 'bidan']) && $user->id != $patient->user_id) {
            return redirect()
                ->back()
                ->with('error', __('Anda tidak dapat melihat Janji ini'));
        }        
        $appointment->load('service', 'patient.user', 'notification', 'payment');

        return view('patients.appointments.show', [
            'appointment' => $appointment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
{
    // Ambil status dari request, atau gunakan status dari appointment jika tidak ada
    $status = request('status', $appointment->status);
    $statuses = ['confirmed'];
    $user = request()->user();
    $patient = $appointment->patient;

    // Pengecekan hak akses user
    if (!in_array($user->role, ['admin', 'bidan']) && $user->id != $patient->user_id) {
        return redirect()
            ->back()
            ->with('error', __('Anda tidak dapat melihat Janji ini'));
    }

    // Jika role bukan admin/bidan, lakukan pengecekan status dan timeout
    if (!in_array($user->role, ['admin', 'bidan'])) {
        if ($appointment->status != 'pending') {
            return redirect()
                ->back()
                ->with('error', __('Tidak dapat melakukan pembayaran, melewati batas waktu'));
        }
    }
    
    $timeout = (int) env('APPOINTMENT_TIMEOUT', 0);

    return view('patients.appointments.edit', [
        'statuses' => $statuses,
        'status' => $status, // Pastikan status di-pass ke view
        'appointment' => $appointment->load('service', 'patient.user'),
        'timeout' => $timeout,
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
{
    $user = request()->user();
    $patient = $appointment->patient;

    // Periksa hak akses pengguna untuk pasien
    if ($user->role == 'patient' && $user->id != $patient->user_id) {
        return redirect()
            ->back()
            ->with('error', __('Anda tidak dapat mengubah Janji ini'));
    }

    // Jika pasien, hanya bisa mengubah janji jika statusnya masih pending
    if ($user->role == 'patient' && $appointment->status != 'pending') {
        return redirect()
            ->back()
            ->with('error', __('Anda tidak dapat mengubah Janji yang sudah diproses.'));
    }

    // Admin atau bidan dapat mengubah status janji
    if (in_array($user->role, ['admin', 'bidan'])) {
        if ($request->has('status')) {
            $appointment->status = $request->input('status');
        }
    }

    // Simpan perubahan appointment
    $appointment->save();

    // Kirim notifikasi email jika status diubah menjadi 'confirmed' (hanya oleh admin/bidan)
    if ($appointment->status == 'confirmed' && in_array($user->role, ['admin', 'bidan'])) {
        Mail::to($appointment->patient->user->email)
            ->send(new AppointmentNotification($appointment));
    }

    return redirect()
        ->route('patients.appointments.index')
        ->with('success', __('Berhasil menambah janji temu'));
}


    /**
     * Cancel appointment.
     */
    public function cancel(Appointment $appointment)
{
    $user = request()->user();
    $patient = $appointment->patient;

    // Periksa hak akses pengguna
    if (!in_array($user->role, ['admin', 'bidan']) && $user->id != $patient->user_id) {
        return redirect()
            ->back()
            ->with('error', __('Anda tidak dapat membatalkan Janji ini'));
    }

    // Periksa status janji untuk memastikan janji belum dibatalkan
    if ($appointment->status == 'cancelled') {
        return redirect()
            ->back()
            ->with('error', __('Janji ini sudah dibatalkan'));
    }

    // Ubah status janji menjadi 'cancelled'
    $appointment->status = 'cancelled';
    $appointment->save();

    // Simpan frekuensi pembatalan ke tabel notifications
    Notification::create([
        'frequency' => 'Kirim Notifikasi Melalui Email', // Default value
        'appointment_id' => $appointment->id,
    ]);

    // Kirim email pemberitahuan pembatalan
    Mail::to($patient->user->email)
        ->send(new AppointmentNotification($appointment));

    return redirect()
        ->route('patients.appointments.index')
        ->with('success', __('Berhasil membatalkan Janji'));
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        // disabled
    }
}