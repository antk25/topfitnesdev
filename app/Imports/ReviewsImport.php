<?php

namespace App\Imports;

use App\Models\Bracelet;
use App\Models\Review;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReviewsImport implements ToModel, WithHeadingRow
{
    private $bracelets;

    public function __construct()
    {
        $this->bracelets = Bracelet::select('id', 'name')->get();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
//        $bracelet = $this->bracelets->where('name', $row['bracelet_name'])->first();
        $bracelet = Bracelet::where('name', $row['bracelet_name'])->pluck('id')->first();

        if ($bracelet) {
            return new Review([
                'reviewable_id' => Bracelet::where('name', $row['bracelet_name'])->pluck('id')->first(),
                'reviewable_type' => $row['reviewable_type'],
                'name' => $row['name'],
                'email' => $row['email'],
                'period_use' => $row['period_use'],
                'rating_user' => $row['rating_user'],
                'review_text' => $row['review_text'],
                'what_like' => $row['what_like'],
                'what_nolike' => $row['what_nolike'],
                'votes_review' => $row['votes_review'],
                'created_at' => $row['created_at'],
            ]);
        }
        else {
            return null;
        }
    }
}
