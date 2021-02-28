<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
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
            'grade_name' => 'required|min:3',
        ];
    }

    public function messages() 
    {
        return [
            'grade_name.required' => 'Поле ":attribute" обязательно для заполнения',
            'grade_name.min' => '":attribute" должно быть не менее 3-х символов',
        ];
    }

    public function attributes()
    {
        return [
            'grade_name' => 'Название оценки',
        ];
    }
}
