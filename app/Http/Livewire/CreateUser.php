<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Component
{
    public $name, $email, $password, $password_confirmation;

    public $massage;

    protected $rules = [
        'name' => [
            'required',
        ],
        'email' => [
            'required',
            'email',
            'unique:users'
        ],
        'password' => [
            'required',
            'confirmed'
        ]

    ];
    
    public function createUser()
    {
        $this->message = '';
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);

        $this->message = 'Вы зарегистрированы';

        return redirect()->home();

    }

    public function render()
    {
        return view('livewire.create-user');
    }
}
