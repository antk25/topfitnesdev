<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Review
 *
 * @property int $id
 * @property int $bracelet_id
 * @property string $name
 * @property string|null $email
 * @property string|null $period_use
 * @property int|null $rating_user
 * @property string $review_text
 * @property string|null $what_like
 * @property string|null $what_nolike
 * @property int|null $votes_review
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bracelet $bracelet
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereBraceletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review wherePeriodUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereRatingUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereReviewText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereVotesReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereWhatLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereWhatNolike($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    protected $fillable = [
        'bracelet_id',
        'name',
        'email',
        'period_use',
        'rating_user',
        'review_text',
        'what_like',
        'what_nolike'
    ];

    public function bracelet() {
        return $this->belongsTo(Bracelet::class);
    }
}