<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Image;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bracelet[] $bracelets
 * @property-read int|null $bracelets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
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
