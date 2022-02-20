<?php

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Exceptions\InvalidManipulation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Bracelet $bracelet
 * @property-read Collection|Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read MenuItem $menuitem
 * @property-read User $user
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
 * @mixin Eloquent
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
        'content_raw',
        'published',
        'user_id',
        'bracelet_id'
    ];

    // Связываем с одним браслетом

    public function bracelet(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Bracelet::class);
    }

    // Связываем с одним пользователем

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Связываем с комментариями

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function commentsParentless()
    {
        return $this->comments()->whereNull('parent_id');
    }

    // Связываем с меню

    public function menuitem(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('covers')->singleFile();
    }

    public function getLink(): string
    {
        return route('pub.overviews.show', ['overview' => $this]);
    }

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
                ->width(640);
        $this->addMediaConversion('lquip')
                ->fit(Manipulations::FIT_MAX, 20, 20);
    }


}
