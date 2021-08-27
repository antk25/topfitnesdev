<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Comparison extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'title',
        'subtitle',
        'description',
        'content',
        'published',
        'user_id'
    ];

    public function bracelets() {
        return $this->belongsToMany(Bracelet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связываем с несколькими CompareItems

    public function compareitems()
    {
        return $this->hasMany(CompareItems::class);
    }
}
