<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use App\Models\Bracelet;

class CreateLinks extends Component
{
    public $model;
    public $links;
    public $link;
    public $category;

    public $selectedModel = null;
    public $selectedLink = null;

    public function mount($selectedModel = null)
    {
        $this->model = [
            'Блог' => 'Post',
            'Браслеты' => 'Bracelet',
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
