<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserPorfileInformation extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        if(Gate::check('view-admin-panel'))

        {
            return view('admin.profile.edit', compact('user'));

        }
            return view('profile.edit', compact('user'));

    }

    public function update(UpdateUserRequest $request)
    {
        $request = $request->all();

        $user = Auth::user();

        if(Gate::check('view-admin-panel'))
        {

        $allcontacts = $request['allcontacts'];

        if ($allcontacts) {

            $attributes = array_column($allcontacts, 'contacts');
            $value = array_column($allcontacts, 'value');

            $data_contacts = array_combine($attributes, $value);
        }
        }

        $user->forceFill([
            'name' => $request['name'],
            'email' => $request['email'],
            'about' => $request['about'],
            'contacts' => $data_contacts ?? [],
        ])->save();

        if (isset($request['avatar'])) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');

        }

        return redirect(route('profile.index'));
    }
}
