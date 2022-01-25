<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use App\Models\Bracelet;
use App\Models\Manual;
use App\Models\Comparison;
use App\Models\Overview;

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
                $this->category = 'blog';
                break;
            case('Manual'):
                $this->links = Manual::get();
                $this->category = 'manuals';
                break;
            case('Comparison'):
                $this->links = Comparison::get();
                $this->category = 'sravneniya';
                break;
            case('Overview'):
                $this->links = Overview::get();
                $this->category = 'obzory';
                break;
            case ('Bracelet'):
                $this->links = Bracelet::get();
                $this->category = 'katalog';
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
