<?php

namespace App\Exports;

use App\Models\Patient;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientExport implements FromArray, WithHeadings
{
    protected Collection $patients;

    public function __construct(Collection $patients)
    {
        $this->patients = $patients;
    }

    /**
     * array of data to export
     * 
     * @return array
     */
    public function array(): array
    {
        return $this->patients->map(function (Patient $patient) {
            return [
                $patient->id,
                $patient->user->name,
                $patient->nik,
                $patient->no_registrasi,
                $patient->phone,
                $patient->address,
                $patient->birth_date,
                $patient->birth_place,
                $patient->gender,
                $patient->blood_type,
                $patient->total,
                $patient->cancelled,
                $patient->total == 0 ? 0 : 100 - ($patient->cancelled / $patient->total) * 100,
                $patient->created_at,
                $patient->updated_at,
            ];
        })->toArray();
    }

    /**
     * Column titles
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'no',
            'name',
            'nik',
            'no_registrasi',
            'phone',
            'address',
            'birth_date',
            'birth_place',
            'gender',
            'blood_type',
            'total_appointments',
            'cancelled_appointments',
            'obedience_percentage',
            'created_at',
            'updated_at',
        ];
    }
}
