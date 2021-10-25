<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Image;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Rating extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'published',
        'title',
        'description',
        'name',
        'subtitle',
        'text',
        'slug'
    ];

    public function bracelets() {
        return $this->belongsToMany(Bracelet::class)->withPivot('position', 'text_rating', 'head_rating')->orderBy('pivot_position');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('320')
            ->width(320);

        $this->addMediaConversion('640')
            ->width(640);

        $this->addMediaConversion('960')
            ->width(960);

        $this->addMediaConversion('1280')
            ->width(1280);

        $this->addMediaConversion('thumb')
        ->crop('crop-center', 300, 300);
    }

    public function getLink() {

        $link = $this->slug;

        return route('pub.ratings.show', ['slug' => $link]);

     }
}
