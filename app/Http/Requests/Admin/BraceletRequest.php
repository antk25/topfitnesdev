<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BraceletRequest extends FormRequest
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
            'title' => 'required|min:5',
            'name' => [
                'required',
                'min:5',
                Rule::unique('bracelets', 'name')->ignore($this->bracelet),
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
            'name' => 'Название модели',
            'title' => 'Title'
        ];
    }
}
