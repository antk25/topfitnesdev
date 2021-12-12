<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Overview
 *
 * @property int $id
 * @property int $user_id
 * @property int $bracelet_id
 * @property string $name
 * @property string $slug
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property string|null $content
 * @property int $published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bracelet $bracelet
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\MenuItem $menuitem
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Overview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Overview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Overview query()
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereBraceletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Overview whereUserId($value)
 * @mixin \Eloquent
 */
class Overview extends Model implements HasMedia
{

   use InteractsWithMedia, SoftDeletes;

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
