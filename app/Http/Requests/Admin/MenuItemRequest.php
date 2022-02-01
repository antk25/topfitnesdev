<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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
            'link' => 'required',
            'group_menu_id' => 'required|exists:group_menus,id',
            'name' => [
                'required',
                'min:5',
                Rule::unique('menu_items', 'name')->ignore($this->menuitem),
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Название ссылки',
            'link' => 'URL',
            'group_menu_id' => 'Группа',
        ];
    }
}
