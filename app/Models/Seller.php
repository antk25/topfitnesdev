<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Seller
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property string|null $about
 * @property float|null $rating
 * @property int $published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bracelet[] $bracelets
 * @property-read int|null $bracelets_count
 * @method static \Illuminate\Database\Eloquent\Builder|Seller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seller query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Seller extends Model
{
    protected $fillable = [
        'name',
        'marketplace',
        'about'
    ];

    // Связь с моделями браслетов
    public function bracelets() {
        return $this->belongsToMany(Bracelet::class)->withPivot('link', 'price', 'old_price');
    }
}
