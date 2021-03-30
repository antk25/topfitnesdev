<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'bracelet_id',
        'name',
        'email',
        'period_use',
        'rating_user',
        'review_text',
        'what_like',
        'what_nolike'
    ];

    public function bracelet() {
        return $this->belongsTo(Bracelet::class);
    }
}