<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
            'title' => 'required|min:3',
            'slug' => 'required|min:3'
        ];
    }

    public function messages() 
    {
        return [
            'title.required' => 'Поле ":attribute" обязательно для заполнения',
            'slug.required' => 'Поле ":attribute" обязательно для заполнения',
            'title.min' => '":attribute" должно быть не менее 3-х символов',
            'slug.min' => '":attribute" должно быть не менее 3-х символов'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Название рейтинга',
            'slug' => 'Slug'
        ];
    }
}
