<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'grade_name',
        'grade_about'
    ];

    // Связь с моделями браслетов
    public function bracelets() {
        return $this->belongsToMany(Bracelet::class)->withPivot('position', 'value');
    }
}
