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
 * App\Models\Comparison
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property string|null $content
 * @property int $published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Bracelet[] $bracelets
 * @property-read int|null $bracelets_count
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comparison whereUserId($value)
 * @mixin Eloquent
 */
class Comparison extends Model implements HasMedia
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
        'type_table',
        'list_specs',
    ];

    protected $casts = [
        'list_specs' => 'array',
    ];

    public function bracelets(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Bracelet::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Включаем комментарии

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function commentsParentless()
    {
        return $this->comments()->whereNull('parent_id');
    }

    // Связываем с несколькими CompareItems

    public function compareitems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CompareItems::class);
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('covers')->singleFile();
    }

    public function getLink(): string
    {
        return route('pub.comparisons.show', ['comparison' => $this]);
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
