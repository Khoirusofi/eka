<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Patient;
use App\Exports\PatientExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;

class PatientController extends Controller
{
    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'patient-' . now()->format('d-m-Y');

        $start = request('start');
        $end = request('end');
        $patients = Patient::with('user')
            ->when($start, function ($query) use ($start) {
                $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
                return $query->where('created_at', '>=', $formattedStart);
            })
            ->when($end, function ($query) use ($end) {
                $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
                return $query->where('created_at', '<=', $formattedEnd);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        if ($type == 'csv') {
            return Excel::download(new PatientExport($patients), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.patient', ['patients' => $patients]);
            return $pdf->setPaper('auto', 'landscape')->stream($filename . '.pdf');
        }
    }

    /**
     * Display the report of the resource
     */
    public function report()
    {
        $start = request('start');
        $end = request('end');

        $patients = Patient::with('user')
            ->when($start, function ($query) use ($start) {
                $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
                return $query->where('created_at', '>=', $formattedStart);
            })
            ->when($end, function ($query) use ($end) {
                $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
                return $query->where('created_at', '<=', $formattedEnd);
            })
            ->orderBy('created_at', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('admins.reports.patient', [
            'patients' => $patients,
            'start' => $start,
            'end' => $end,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $name = request('name');
    $noRegistrasi = request('no_registrasi');

    $patients = Patient::with('user')
        ->withCount([
            'appointments as total',
            'appointments as cancelled' => function ($query) {
                return $query->where('status', 'cancelled');
            },
        ])
        ->when($name, function ($query) use ($name) {
            return $query->whereHas('user', function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            });
        })
        ->when($noRegistrasi, function ($query) use ($noRegistrasi) {
            return $query->where('no_registrasi', 'like', '%' . $noRegistrasi . '%');
        })
        ->orderBy('id')
        ->paginate(10)
        ->withQueryString();

    return view('admins.patients.index', [
        'patients' => $patients,
        'name' => $name,
        'noRegistrasi' => $noRegistrasi,
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::doesntHave('patient')
            ->where('role', 'patient')
            ->select('id', 'name')
            ->get();

        $genders = [
            'male' => __('Laki-laki'),
            'female' => __('Perempuan'),
        ];

        return view('admins.patients.create', [
            'users' => $users,
            'genders' => $genders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $validated = $request->validated();
        $patient = Patient::create($validated);

        return redirect()
            ->route('admins.patients.index')
            ->with('success', __('Berhasil menambahkan patient' . ' ' . $patient->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        // disabled
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $genders = [
            'male' => __('Laki-laki'),
            'female' => __('Perempuan'),
        ];

        return view('admins.patients.edit', [
            'patient' => $patient,
            'genders' => $genders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $validated = $request->validated();
        $patient->update($validated);

        return redirect()
            ->route('admins.patients.index')
            ->with('success', __('Berhasil mengupdate patient' . ' ' . $patient->name));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('admins.patients.index')
            ->with('success', __('Berhasil menghapus patient' . ' ' . $patient->name));
    }
}
