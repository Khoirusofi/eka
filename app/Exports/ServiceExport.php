<?php

namespace App\Exports;

use App\Models\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceExport implements FromArray, WithHeadings
{
    protected Collection $services;

    public function __construct(Collection $services)
    {
        $this->services = $services;
    }

    /**
     * array of data to export
     *
     * @return array
     */
    public function array(): array
    {
        return $this->services->map(function (Service $service) {
            return [
                $service->id,
                $service->created_at,
                $service->title,
                $service->price,
                $service->description,
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
            'title',
            'price',
            'description',
        ];
    }
}
