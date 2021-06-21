<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
