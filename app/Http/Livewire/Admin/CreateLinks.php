<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use App\Models\Manual;
use App\Models\Rating;
use Livewire\Component;
use App\Models\Bracelet;
use App\Models\Overview;
use App\Models\Comparison;

class CreateLinks extends Component
{
    public $model;
    public $links;
    public $link;
    public $category;
    public $linkText = "";
    public $domain = "https://topfitnesbraslet.ru";

    public $selectedModel = null;
    public $selectedLink = null;

    public function mount($selectedModel = null)
    {
        $this->model = [
            'Блог' => 'Post',
            'Браслеты' => 'Bracelet',
            'Сравнения' => 'Comparison',
            'Обзоры' => 'Overview',
            'Мануалы' => 'Manual',
            'Рейтинги' => 'Rating',
        ];

        $this->link = null;

        $this->selectedModel = $selectedModel;

    }

    public function render()
    {
        return view('livewire.admin.create-links');
    }

    public function updatedSelectedModel($model)
    {
        switch ($model){
            case('Post'):
                $this->links = Post::get();
                $this->category = 'blog/';
                break;
            case('Manual'):
                $this->links = Manual::get();
                $this->category = 'manuals/';
                break;
            case('Comparison'):
                $this->links = Comparison::get();
                $this->category = 'sravneniya/';
                break;
            case('Overview'):
                $this->links = Overview::get();
                $this->category = 'obzory/';
                break;
            case ('Bracelet'):
                $this->links = Bracelet::get();
                $this->category = 'katalog/';
                break;
            case ('Rating'):
                $this->links = Rating::get();
                $this->category = '';
                break;
        }
        $this->selectedLink = NULL;
    }
    public function updatedSelectedLink($link)
    {
        if(!is_null($link)) {
            $this->link = $this->links->where('id', $link)->first();
        }
    }

}
