<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class ControlImages extends Component
{
    public $images;
    public $imageName;
    public $imageId = null;

    public function imageEdit($imageId)
    {
       $this->imageId = $imageId;
       $image = $this->images->where('id', $this->imageId)->first();
       $this->imageName = $image->name;
    }

    public function updateName($imageId)
    {        $this->imageId = $imageId;
        $image = $this->images->where('id', $this->imageId)->first();
        $image->update([
            'name' => $this->imageName
        ]);

        $this->reset(['imageId']);
    }

    public function imageDelete($imageId)
    {
        $this->imageId = $imageId;
        $this->images->where('id', $this->imageId)->first()->delete();
    }

    public function refresh()
    {
        return;
    }

    public function render()
    {
        return view('livewire.admin.control-images');
    }
}
