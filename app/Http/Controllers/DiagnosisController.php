<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Diagnosis;
use App\Models\Appointment;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\DiagnosisExport;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\AppointmentNotification;
use Maatwebsite\Excel\Excel as ExcelType;
use App\Http\Requests\UpdateDiagnosisRequest;

class DiagnosisController extends Controller
{
    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'appointment-' . now()->format('d-m-Y');

        $start = request('start');
        $end = request('end');
        $diagnoses = Diagnosis::with('appointment.patient.user', 'appointment.service')
            ->when($start, function ($query) use ($start) {
                $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
                return $query->whereHas('appointment', function ($query) use ($formattedStart) {
                    $query->where('date', '>=', $formattedStart);
                });
            })
            ->when($end, function ($query) use ($end) {
                $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
                return $query->whereHas('appointment', function ($query) use ($formattedEnd) {
                    $query->where('date', '<=', $formattedEnd);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        if ($type == 'csv') {
            return Excel::download(new DiagnosisExport($diagnoses), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.diagnosis', [
                'diagnoses' => $diagnoses
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

        $diagnoses = Diagnosis::with('appointment.patient.user', 'appointment.service')
            ->when($start, function ($query) use ($start) {
                $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
                return $query->whereHas('appointment', function ($query) use ($formattedStart) {
                    $query->where('date', '>=', $formattedStart);
                });
            })
            ->when($end, function ($query) use ($end) {
                $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
                return $query->whereHas('appointment', function ($query) use ($formattedEnd) {
                    $query->where('date', '<=', $formattedEnd);
                });
            })
            ->orderBy('created_at', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('admins.reports.diagnosis', [
            'diagnoses' => $diagnoses,
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
    $registrationNumber = request('registration_number');
    $name = request('name'); // Ambil input dari field name

    $user = auth()->user();
    $diagnoses = Diagnosis::with('appointment.service', 'appointment.patient.user')
    ->withCount(['appointment as appointments_count' => function ($query) {
        $query->withCount('patient');
    }])
    ->when($user, function ($query) use ($user) {
        return $query->whereHas('appointment', function ($query) use ($user) {
            return $query->whereHas('patient', function ($query) use ($user) {
                return in_array($user->role, ['admin', 'bidan']) ? $query : $query->where('user_id', $user->id);
            });
        });
    })
    ->when($start, function ($query) use ($start) {
        $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
        return $query->whereHas('appointment', function ($query) use ($formattedStart) {
            $query->where('date', '>=', $formattedStart);
        });
    })
    ->when($end, function ($query) use ($end) {
        $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
        return $query->whereHas('appointment', function ($query) use ($formattedEnd) {
            $query->where('date', '<=', $formattedEnd);
        });
    })
    ->when($registrationNumber, function ($query) use ($registrationNumber) {
        return $query->whereHas('appointment.patient', function ($query) use ($registrationNumber) {
            $query->where('no_registrasi', 'like', "%{$registrationNumber}%");
        });
    })
    ->when($name, function ($query) use ($name) {
        // Filter berdasarkan nama pengguna
        return $query->whereHas('appointment.patient.user', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
    })
    ->orderBy('id')
    ->orderBy('created_at', 'desc')
    ->paginate(10)
    ->withQueryString();

    return view('patients.diagnoses.index', [
        'diagnoses' => $diagnoses,
        'start' => $start,
        'end' => $end,
        'registrationNumber' => $registrationNumber,
        'name' => $name, // Pastikan variabel ini dikirim ke view
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create(Appointment $appointment)
{
    // Cek status appointment, hanya bisa menambahkan diagnosis jika appointment terkonfirmasi
    if ($appointment->status !== 'confirmed') {
        return redirect()->route('patients.diagnoses.index', $appointment)
            ->with('error', __('Tidak dapat menambahkan rekam medis, periksa status janji temu'));
    }

    $jenisKelamin = $appointment->patient->gender ?? 'Jenis Kelamin Tidak Diketahui';
    $genderTranslations = [
    'male' => 'Laki-laki',
    'female' => 'Perempuan',
    'L' => 'Laki-laki',
    'P' => 'Perempuan',
    ];
    $jenisKelamin = $genderTranslations[$jenisKelamin] ?? 'Jenis Kelamin Tidak Diketahui';

    $detail = '
        <strong>I. Identitas Pasien:</strong><br>
        NIK: '. ($appointment->patient->nik ?? 'NIK Tidak Diketahui') . '<br>
        Nama: ' . ($appointment->patient->user->name ?? 'Nama Tidak Diketahui') . '<br>
        Tempat Lahir: '. ($appointment->patient->birth_place?? 'Tempat Tidak Diketahui') . '<br>
        Tanggal Lahir: '. (\Carbon\Carbon::parse($appointment->patient->birth_date)->translatedFormat('d F Y') ) . '<br>
        Umur: '. \Carbon\Carbon::parse($appointment->patient->birth_date)->age .' tahun<br>
        Jenis Kelamin: ' . $jenisKelamin . '<br>
        Alamat: '. ($appointment->patient->address ?? 'Alamat Tidak Diketahui') . '<br>
        No. Telp/HP: '. ($appointment->patient->phone ?? 'No. Telp Tidak Diketahui') . '<br>
        <br>

        <strong>II. Data Kehamilan:</strong><br>
        Tanggal Pemeriksaan: ' . now()->translatedFormat('d F Y') . '<br>
        Umur Kehamilan: 28 Minggu<br>
        Gravida: 2<br>
        Para: 1<br>
        Aborsi: 0<br><br>
        
        <strong>III. Keluhan Utama:</strong><br>
        Nyeri punggung bawah<br>
        Sering kram perut<br>
        Sesak napas ringan<br><br>
        
        <strong>IV. Riwayat Kesehatan:</strong><br>
        Riwayat Penyakit Sebelumnya: Tidak ada penyakit kronis<br>
        Riwayat Kesehatan Keluarga: Tidak ada penyakit keturunan<br>
        Riwayat Alergi: Tidak ada alergi yang diketahui<br>
        Riwayat Kehamilan Sebelumnya: Kehamilan pertama, melahirkan secara normal<br><br>
        
        <strong>V. Pemeriksaan Fisik:</strong><br>
        Tekanan Darah: 110/70 mmHg<br>
        Berat Badan: 70 kg<br>
        Tinggi Badan: 160 cm<br>
        Pemeriksaan Abdomen: Perut membesar sesuai umur kehamilan, tidak ada nyeri tekan<br>
        Pemeriksaan Jantung: Irama jantung normal, tidak ada murmur<br>
        Pemeriksaan Paru: Pernapasan normal, tidak ada wheezing<br><br>
        
        <strong>VI. Pemeriksaan Obstetri:</strong><br>
        Denyut Jantung Janin: 140 bpm<br>
        Ukuran Rahim: Tinggi fundus uteri 28 cm<br>
        Posisi Janin: Kepala di bawah, posisi cephalic<br>
        Tindakan Khusus: Tidak ada tindakan khusus<br><br>
        
        <strong>VII. Laboratorium dan Pemeriksaan Penunjang:</strong><br>
        Hasil Laboratorium: Hemoglobin 12 g/dL, Glukosa darah normal<br>
        Pemeriksaan Penunjang: USG menunjukkan janin dalam posisi yang baik dan perkembangan normal<br><br>
        
        <strong>VIII. Diagnosis:</strong><br>
        Kehamilan 28 minggu, dalam keadaan baik<br>
        Keluhan nyeri punggung bawah mungkin terkait dengan perubahan fisik selama kehamilan<br><br>
        
        <strong>IX. Rencana Tindak Lanjut:</strong><br>
        Jadwal Pemeriksaan Berikutnya: ' . now()->addWeeks(2)->format('d F Y') . '<br>
        Pengobatan atau Terapi: Rekomendasi untuk istirahat dan penggunaan bantal kehamilan<br>
        Konseling atau Edukasi: Edukasi mengenai latihan pernapasan dan posisi tidur yang nyaman
    ';

    return view('admins.diagnoses.create', [
        'appointment' => $appointment,
        'detail' => $detail, // Mengirim template ke view
    ]);
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'confirmed') {
            return redirect()->route('patients.diagnoses.index', $appointment)
                ->with('error', __('Tidak dapat menambahkan rekam medis, periksa status janji temu'));
        }
    
        $diagnosis = Diagnosis::create([
            'detail' => $request->get('detail'),
            'appointment_id' => $appointment->id,
        ]);

        $appointment->status = 'finished';
        $appointment->save();

        if ($appointment->status === 'finished') {
            Mail::to($appointment->patient->user->email)
                ->send(new AppointmentNotification($appointment));
        }

        return redirect()->route('patients.diagnoses.index', $appointment)
            ->with('success', __('Berhasil menambahkan rekam medis' . ' ' . $appointment->patient->user->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(Diagnosis $diagnosis)
    {
        $user = $diagnosis->appointment->patient->user;
        if (!in_array(auth()->user()->role, ['admin', 'bidan']) && auth()->user()->id !== $user->id) {
            return redirect()->route('patients.diagnoses.index', $diagnosis)
                ->with('error', __('Tidak dapat melihat rekam medis, hanya pasien terkait dapat melihatnya'));
        }        

        return view('patients.diagnoses.show', [
            'diagnosis' => $diagnosis,
            'appointment' => $diagnosis->appointment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diagnosis $diagnosis)
    {
        return view('admins.diagnoses.edit', [
            'diagnosis' => $diagnosis,
            'appointment' => $diagnosis->appointment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    

     public function update(UpdateDiagnosisRequest $request, Diagnosis $diagnosis)
{
    // Menggunakan validasi dari UpdateDiagnosisRequest
    $diagnosis->update($request->validated());

    return redirect()->route('patients.diagnoses.index', $diagnosis)
        ->with('success', __('Berhasil perbarui rekam medis ' . $diagnosis->appointment->patient->user->name));
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diagnosis $diagnosis)
    {
        //
    }
}
