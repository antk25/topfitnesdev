<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Overview extends Model implements HasMedia
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
        'user_id',
        'bracelet_id'
    ];

    // Связываем с одним браслетом

    public function bracelet()
    {
        return $this->belongsTo(Bracelet::class);
    }

    // Связываем с одним пользователем

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связываем с комментариями

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    // Связываем с меню

    public function menuitem()
    {
        return $this->belongsTo(MenuItem::class);
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

}
