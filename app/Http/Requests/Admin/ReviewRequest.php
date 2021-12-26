<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'item_id' => 'required',
            'review_text' => 'required|min:50'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле ":attribute" обязательно для заполнения',
            'name.min' => '":attribute" должно быть не менее 3-х символов',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'item_id' => 'Товар',
            'review_text' => 'Текст отзыва'
        ];
    }
}
