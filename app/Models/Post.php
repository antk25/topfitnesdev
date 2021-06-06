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
        'published',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function getLink() {

        $link = $this->slug;

        return route('pub.posts.show', ['slug' => $link]); 
        
     }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('320')
            ->width(320);
        
        $this->addMediaConversion('640')
            ->width(640);

    }

    
}
