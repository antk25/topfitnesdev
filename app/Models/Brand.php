<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Brand extends Model
{
    protected $fillable = [
        'published',
        'title',
        'slug',
        'description',
        'name',
        'about'
    ];

    // Связь с моделями браслетов
    public function bracelets() {
        return $this->hasMany(Bracelet::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('320')
            ->width(320);
        
        $this->addMediaConversion('640')
            ->width(640);

    }

}
