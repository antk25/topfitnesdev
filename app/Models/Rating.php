<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'published',
        'title',
        'description',
        'subtitle',
        'text',
        'slug'
    ];

    public function bracelets() {
        return $this->belongsToMany(Bracelet::class)->withPivot('position');
    }
}
