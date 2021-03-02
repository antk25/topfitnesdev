<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'title',
        'subtitle',
        'description',
        'content',
        'published'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('post')
              ->withResponsiveImages()
              ->format('webp');
    }
}
