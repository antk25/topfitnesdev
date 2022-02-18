<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HtmlComponentRequest extends FormRequest
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
            'name' => [
                'required',
                'min:5',
                Rule::unique('html_components', 'name')->ignore($this->htmlcomponent),
            ],
            'code' => [
                'required',
                'min:20'
            ],
            'link' => [
                'required',
                'url'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Название',
            'code' => 'Код компонента',
            'link' => 'Ссылка на источник',
        ];
    }
}
