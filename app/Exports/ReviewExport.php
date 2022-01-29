<?php

namespace App\Exports;

use App\Models\Review;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReviewExport implements FromCollection, Responsable, WithMapping, WithHeadings
{
    use Exportable;

    private $fileName = "reviews.xlsx";

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Review::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'bracelet_name',
            'reviewable_type',
            'name',
            'period_use',
            'rating_user',
            'review_text',
            'what_like',
            'what_nolike',
            'created_at',
        ];
    }

    public function map($review): array
    {
      return [
        $review->id,
        $review->bracelet_name,
        $review->reviewable_type,
        $review->name,
        $review->period_use,
        $review->rating_user,
        $review->review_text,
        $review->what_like,
        $review->what_nolike,
        $review->created_at,
      ];
    }
}
