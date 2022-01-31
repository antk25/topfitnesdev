<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Image\Manipulations;

/**
 * App\Models\MenuItem
 *
 * @property int $id
 * @property int $post_id
 * @property int $group_menu_id
 * @property string $name
 * @property string|null $place
 * @property int|null $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\GroupMenu $groupmenu
 * @property-read \App\Models\Post|null $post
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereGroupMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MenuItem extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'link',
        'about',
        'position',
        'group_menu_id',
    ];

    public static function header() {
        return self::where('place', 'header');
        // return DB::table('menu_items')
        //              ->select('group', 'name')
        //              ->orderBy('group')
        //              ->get();
        // return self::where('place', 'header')->select('name')->groupBy('group')->get();
    }

    public static function footer() {
        return self::where('place', 'footer')->get();
    }

    public function post()
    {
        return $this->hasOne(Post::class);
    }

    public function groupmenu()
    {
        return $this->belongsTo(GroupMenu::class, 'group_menu_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('menu')->singleFile();
    }

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
        // ->crop('crop-center', 200, 200);
        ->fit(Manipulations::FIT_CROP, 100, 100)
        ->quality(70);

        // $this->addMediaConversion('thumb')
        // ->crop('crop-center', 200, 200)
        // ->watermark(public_path('img/watermark.png'));

        // $this->addMediaConversion('thumb')
        //     ->crop(Manipulations::CROP_CENTER, 200, 200);
    }
}
