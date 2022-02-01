<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StaticPageRequest extends FormRequest
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
            'title' => 'required|min:5',
            'name' => [
                'required',
                'min:5',
                Rule::unique('static_pages', 'name')->ignore($this->static_page),
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Название',
            'title' => 'Title',
        ];
    }
}
