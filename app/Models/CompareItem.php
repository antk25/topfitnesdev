<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompareItem extends Model
{
    // Связываем с одним браслетом

    public function bracelet()
    {
        return $this->belongsTo(Bracelet::class);
    }

    // Связываем с одной статьей-сравнением 
    public function comparison()
    {
        return $this->belongsTo(Comparison::class);
    }
}
