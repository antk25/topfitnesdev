<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMenu extends Model
{
    protected $fillable = [
        'name',
    ];

    public function menuitems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
