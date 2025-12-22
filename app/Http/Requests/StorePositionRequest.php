<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:positions,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле название обязательно для заполнения',
            'name.string' => 'Поле название должно быть строкой',
            'name.max' => 'Поле название не должно превышать 255 символов',
            'name.unique' => 'Отдел с таким названием уже существует',
        ];
    }
}
