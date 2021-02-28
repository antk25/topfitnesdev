<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = [
        'published',
        'name',
        'slug',
        'title',
        'subtitle',
        'description',
        'rating',
        'about'
    ];

    // Связь с моделями браслетов
    public function bracelets() {
        return $this->hasMany(Bracelet::class);
    }
}
