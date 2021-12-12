<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::user()),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле ":attribute" обязательно для заполнения',
            'name.min' => '":attribute" должно быть не менее 3-х символов',
            'email.required' => 'Поле ":attribute" обязательно для заполнения',
            'email.unique' => 'Поле ":attribute" должно быть уникальным',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Имя',
            'email' => 'email',
        ];
    }
}
