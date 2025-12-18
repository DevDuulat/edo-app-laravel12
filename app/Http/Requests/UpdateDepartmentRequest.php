<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:departments,name,' . $this->department->id,
            'location' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле название обязательно для заполнения',
            'name.string' => 'Поле название должно быть строкой',
            'name.max' => 'Поле название не должно превышать 255 символов',
            'name.unique' => 'Отдел с таким названием уже существует',

            'location.string' => 'Поле местоположение должно быть строкой',
            'location.max' => 'Поле местоположение не должно превышать 255 символов',
        ];
    }
}
