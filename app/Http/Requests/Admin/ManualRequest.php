<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManualRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'title' => 'required|min:5',
            'name' => [
                'required',
                'min:5',
                Rule::unique('manuals', 'name')->ignore($this->manual),
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле ":attribute" обязательно для заполнения',
            'name.min' => '":attribute" должно быть не менее 5 символов',
            'title.required' => 'Поле ":attribute" обязательно для заполнения',
            'titile.min' => '":attribute" должно быть не менее 5 символов',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Название статьи',
            'title' => 'Title',
            'user_id' => 'Автор'
        ];
    }
}
