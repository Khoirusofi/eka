<?php

namespace App\Exports;

use App\Models\Diagnosis;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DiagnosisExport implements FromArray, WithHeadings
{
    protected $diagnoses;

    public function __construct($diagnoses)
    {
        $this->diagnoses = $diagnoses;
    }

    /**
     * array of data to export
     * 
     * @return array
     */
    public function array(): array
    {
        return $this->diagnoses->map(function (Diagnosis $diagnosis) {
            return [
                $diagnosis->id,
                $diagnosis->appointment->patient->user->name,
                $diagnosis->appointment->date,
                $diagnosis->appointment->time,
                $diagnosis->appointment->service->title,
                $diagnosis->detail,
                $diagnosis->created_at,
                $diagnosis->updated_at,
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
            'date',
            'time',
            'service',
            'detail',
            'created_at',
            'updated_at',
        ];
    }
}
