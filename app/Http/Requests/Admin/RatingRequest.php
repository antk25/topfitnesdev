<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RatingRequest extends FormRequest
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
            'type_table' => 'required',
            'name' => [
                'required',
                'min:5',
                Rule::unique('ratings', 'name')->ignore($this->rating),
            ]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле ":attribute" обязательно для заполнения',
            'title.min' => '":attribute" должно быть не менее 5 символов',
            'name.required' => 'Поле ":attribute" обязательно для заполнения',
            'name.min' => '":attribute" должно быть не менее 5 символов',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Название рейтинга',
            'title' => 'title рейтинга',
            'type_table' => 'Тип таблицы',
            'user_id' => 'Автор'
        ];
    }
}
