<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bracelet[] $bracelets
 * @property-read int|null $bracelets_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
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
 * @mixin \Eloquent
 */
class Comparison extends Model implements HasMedia
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

    public function bracelets() {
        return $this->belongsToMany(Bracelet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Включаем комментарии

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    // Связываем с несколькими CompareItems

    public function compareitems()
    {
        return $this->hasMany(CompareItems::class);
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
