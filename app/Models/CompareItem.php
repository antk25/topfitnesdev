<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CompareItem
 *
 * @property int $id
 * @property int $bracelet_id
 * @property int $comparison_id
 * @property int|null $position
 * @property string $name
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bracelet $bracelet
 * @property-read \App\Models\Comparison $comparison
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem whereBraceletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem whereComparisonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompareItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompareItem extends Model
{
    // Связываем с одним браслетом

    public function bracelet()
    {
        return $this->belongsTo(Bracelet::class);
    }

    // Связываем с одной статьей-сравнением 
    public function comparison()
    {
        return $this->belongsTo(Comparison::class);
    }
}
