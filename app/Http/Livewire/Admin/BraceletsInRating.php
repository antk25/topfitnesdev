<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Bracelet;
use App\Models\Rating;

class BraceletsInRating extends Component
{
    public $ratingBracelets = [];
    public $allBracelets = [];
    public $rating;
    public $edit;
    public $name;
    public $title;
    public $subtitle;
    public $description;
    public $slug;
    public $text;

    public function mount()
    {
        $this->allBracelets = Bracelet::all();
        
        if (!empty($this->rating->bracelets[0])) 
        
        foreach ($this->rating->bracelets as $item)
         {
             array_push($this->ratingBracelets, ['bracelet_id' => $item->pivot->bracelet_id, 'position' => $item->pivot->position, 'text_rating' => $item->pivot->text_rating]);
         }
        else
         $this->ratingBracelets = [
             ['bracelet_id' => '', 'position' => 1, 'text_rating' => '']
         ];
    if ($this->edit == 1) {
        $this->name = $this->rating->name;
        $this->title = $this->rating->title;
        $this->subtitle = $this->rating->subtitle;
        $this->description = $this->rating->description;
        $this->slug = $this->rating->slug;
        $this->text = $this->rating->text;
        }
        
    }

    public function addBracelet()
    {
        $this->ratingBracelets[] = ['bracelet_id' => '', 'position' => 1, 'text_rating' => ''];
    }

    public function removeBracelet($index)
    {
        unset($this->ratingBracelets[$index]);
        $this->ratingBracelets = array_values($this->ratingBracelets);
    }
    

    public function render()
    {
        
        info($this->ratingBracelets);
        return view('livewire.admin.bracelets-in-rating');

    }
}
