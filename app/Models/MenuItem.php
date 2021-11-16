<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class MenuItem extends Model
{
    protected $fillable = [
        'name',
        'post_id',
        'group',
        'place',
        'group_menu_id'
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
        return $this->belongsTo(GroupMenu::class);
    }
}
