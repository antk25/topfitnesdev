<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'about' => $input['about'],
                'whatsapp' => $input['whatsapp'],
                'telegram' => $input['telegram'],
                'vk' => $input['vk'],
                'facebook' => $input['facebook'],
            ])->save();

            if (isset($input['avatar'])) {
                $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
            }
            redirectPath();
        }
        
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'about' => $input['about'],
            'whatsapp' => $input['whatsapp'],
            'telegram' => $input['telegram'],
            'vk' => $input['vk'],
            'facebook' => $input['facebook'],
            'email_verified_at' => null,
        ])->save();

        if (isset($input['avatar'])) {
          $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        $user->sendEmailVerificationNotification();
        redirectPath();
    }
    public function redirectPath()
    {
        return route('profile.index');
    }
}
