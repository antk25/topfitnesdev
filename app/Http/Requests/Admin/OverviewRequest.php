<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OverviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'bracelet_id' => 'required|exists:bracelets,id',
            'title' => 'required|min:5',
            'name' => [
                'required',
                'min:5',
                Rule::unique('overviews', 'name')->ignore($this->overview),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле ":attribute" обязательно для заполнения',
            'name.min' => '":attribute" должно быть не менее 5 символов',
            'title.required' => 'Поле ":attribute" обязательно для заполнения',
            'titile.min' => '":attribute" должно быть не менее 5 символов',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Название статьи',
            'title' => 'Title',
            'user_id' => 'Автор',
            'bracelet_id' => 'Браслет для обзора',
        ];
    }
}
