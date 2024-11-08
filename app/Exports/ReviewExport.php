<?php

namespace App\Exports;

use App\Models\Review;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReviewExport implements FromArray, WithHeadings
{
    protected Collection $reviews;

    public function __construct(Collection $reviews)
    {
        $this->reviews = $reviews;
    }

    /**
     * array of data to export
     *
     * @return array
     */
    public function array(): array
    {
        return $this->reviews->map(function (Review $review) {
            return [
                $review->id,
                $review->created_at,
                $review->user->name,
                $review->body,
                $review->status,
                $review->action,
                $review->respond,
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
            'user',
            'body',
            'status',
            'action',
            'respond',
        ];
    }
}
