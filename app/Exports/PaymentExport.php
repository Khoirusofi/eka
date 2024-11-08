<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentExport implements FromArray, WithHeadings
{
    protected Collection $payments;

    public function __construct(Collection $payments)
    {
        $this->payments = $payments;
    }

    /**
     * array of data to export
     *
     * @return array
     */
    public function array(): array
    {
        return $this->payments->map(function (Payment $payment) {
            return [
                $payment->id,
                $payment->created_at,
                $payment->account,
                $payment->number,
                $payment->description,
            ];
        })->toArray();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'no',
            'created_at',
            'account',
            'number',
            'description',
        ];
    }
}
