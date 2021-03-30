<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Review;
use App\Models\Bracelet;

use App\Models\User;

class Reviews extends Component
{
    public $review_text, $bracelet, $name, $email, $period_use, $what_like, $what_nolike, $rating_user;

    public function store()

    {
        $bracelet = $this->bracelet;
        $bracelet->reviews()->create([
            'name' => $this->name,
            'email' => $this->email,
            'review_text' => $this->review_text,
            'rating_user' => $this->rating_user,
            'period_use' => $this->period_use,
        ]);
        
        
        $allrating = (json_decode(Review::where([['rating_user','>', 0],['bracelet_id', '=', $bracelet->id]])->pluck('rating_user')));
        $sumVotes = array_sum ($allrating);
        $totalVotes = count($allrating);
        $votesRange = [1, 2, 3, 4, 5];

        $z = 1.64485;
        $vMin = min($votesRange);
        $vWidth = floatval(max($votesRange) - $vMin);

        $phat = ($sumVotes - $totalVotes * $vMin) / $vWidth / floatval($totalVotes);

        $rating = ($phat + $z * $z / (2 * $totalVotes) - $z * sqrt(($phat * (1 - $phat) + $z * $z / (4 * $totalVotes)) / $totalVotes)) / (1 + $z * $z / $totalVotes);

        $endRating = round($rating * $vWidth + $vMin, 6);

        $bracelet = Bracelet::where('id', $bracelet->id)->first();
        $bracelet->rating_bracelet = $endRating;
        $bracelet->save();
    }

    public function render()
    {
        
        $reviews = Review::where('bracelet_id', $this->bracelet->id)->get();
        return view('livewire.reviews', compact('reviews'));
    }
}
