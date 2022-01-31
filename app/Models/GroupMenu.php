<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GroupMenu
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MenuItem[] $menuitems
 * @property-read int|null $menuitems_count
 * @method static \Illuminate\Database\Eloquent\Builder|GroupMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupMenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupMenu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GroupMenu extends Model
{
    protected $fillable = [
        'name',
        'place',
        'about',
    ];

    public function menuitems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
