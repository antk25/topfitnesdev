<?php

namespace App\Http\Livewire\Review;

use Livewire\Component;
use App\Models\Review;
use App\Models\Bracelet;

use App\Models\User;

class Reviews extends Component
{
    public $review_text = "<i>Ваш комментарий...</i>";
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

        $this->model->refresh();

        $this->reset([
            'review_text',
            'rating_user',
            'period_use',
            'name',
            'email',
        ]);

    }

    public function render()
    {

//        $reviews = Review::where('bracelet_id', $this->bracelet->id)->get();

        return view('livewire.reviews');
    }
}
