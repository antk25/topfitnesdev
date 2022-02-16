<?php

namespace App\Models;

use Spatie\Image\Image;
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
 * App\Models\Rating
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property string|null $text
 * @property int $published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Bracelet[] $bracelets
 * @property-read int|null $bracelets_count
 * @property-read Collection|Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rating whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rating extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'published',
        'title',
        'description',
        'name',
        'subtitle',
        'intro',
        'conclusion_raw',
        'slug',
        'list_specs',
        'type_table',
        'type_grade',
        'user_id',
    ];

    protected $casts = [
     'list_specs' => 'array',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bracelets(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Bracelet::class)->withPivot('position', 'text_rating', 'head_rating')->orderBy('pivot_position');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


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
        $this->addMediaConversion('lquip')
            ->fit(Manipulations::FIT_MAX, 20, 20);
    }

    public function getLink()
    {
        return route('pub.ratings.show', ['rating' => $this]);
    }
}
