<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Trix;
use Livewire\Component;
use App\Models\Review;
use App\Models\Bracelet;

use App\Models\User;

class Reviews extends Component
{
    public $review_text;
    public $model;
    public $name;
    public $email;
//    public $what_like;
//    public $what_nolike;
    public $rating_user;
    public $period_use;


    protected $rules = [
     'name' => 'required',
     'email' => 'required',
     'review_text' => 'required',
    ];

    public function store()

    {
        $this->validate();

        $this->model->reviews()->create([
            'name' => $this->name,
            'email' => $this->email,
            'review_text' => preg_replace('#<h([1-6]).*?>(.*?)<\/h[1-6]>#si', '<p class="text-md">${2}</p>', $this->review_text),
            'rating_user' => $this->rating_user,
            'period_use' => $this->period_use,
        ]);



        $allrating = (json_decode(Review::where([['rating_user','>', 0],['reviewable_id', '=', $this->model->id],['reviewable_type', '=', get_class($this->model)]])->pluck('rating_user')));
            $sumVotes = array_sum($allrating);
            $totalVotes = count($allrating);
            $votesRange = [1, 2, 3, 4, 5];

            $z = 1.64485;
            $vMin = min($votesRange);
            $vWidth = floatval(max($votesRange) - $vMin);

            $phat = ($sumVotes - $totalVotes * $vMin) / $vWidth / floatval($totalVotes);

            $rating = ($phat + $z * $z / (2 * $totalVotes) - $z * sqrt(($phat * (1 - $phat) + $z * $z / (4 * $totalVotes)) / $totalVotes)) / (1 + $z * $z / $totalVotes);

            $endRating = round($rating * $vWidth + $vMin, 6);

            $this->model->rating_bracelet = $endRating;

            $this->model->save();

            $this->model->refresh();

            $this->reset(['review_text', 'rating_user', 'period_use']);
    }

    public function render()
    {

//        $reviews = Review::where('bracelet_id', $this->bracelet->id)->get();

        return view('livewire.reviews');
    }
}
