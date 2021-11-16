<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Spec
 *
 * @property int $id
 * @property string $device
 * @property string $name
 * @property string $value
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Spec newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spec newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spec query()
 * @method static \Illuminate\Database\Eloquent\Builder|Spec whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spec whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spec whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spec whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spec whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spec whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spec whereValue($value)
 * @mixin \Eloquent
 */
class Spec extends Model
{
    use HasFactory;

    protected $fillable = [
        'device',
        'name',
        'value',
        'slug'
    ];
}
