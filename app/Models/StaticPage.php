<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model implements HasMedia
{
   use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'title',
        'subtitle',
        'description',
        'content_raw',
        'published',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('covers')->singleFile();
    }

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(640);
    }
}
