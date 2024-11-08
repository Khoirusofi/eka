<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AppointmentExport implements FromArray, WithHeadings
{
    protected $appointments;

    public function __construct($appointments)
    {
        $this->appointments = $appointments;
    }

    /**
     * array of data to export
     * 
     * @return array
     */
    public function array(): array
    {
        return $this->appointments->map(function (Appointment $appointment) {
            return [
                $appointment->id,
                $appointment->patient->user->name,
                $appointment->service->title,
                $appointment->date,
                $appointment->time,
                $appointment->status,
                $appointment->payment->account,
                $appointment->service->price + $appointment->code,
                $appointment->created_at,
                $appointment->updated_at,
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
            'service',
            'date',
            'time',
            'status',
            'payment',
            'sum',
            'created_at',
            'updated_at',
        ];
    }
}
