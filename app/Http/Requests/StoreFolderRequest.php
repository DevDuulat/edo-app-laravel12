<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreFolderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation()
    {
        if ($this->filled('name')) {
            $this->merge([
                'slug' => Str::slug($this->name),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                Rule::unique('folders', 'slug'),
            ],
            'parent_id' => ['nullable', 'exists:folders,id'],
            'retention_period' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название папки.',
            'name.string' => 'Название должно быть текстовой строкой.',
            'name.max' => 'Название папки не должно превышать 255 символов.',
            'slug.unique' => 'Папка с таким названием уже существует.',
            'parent_id.exists' => 'Выбранная родительская папка не существует.',
            'retention_period.integer' => 'Срок хранения должен быть целым числом (количество дней).',
            'retention_period.min' => 'Срок хранения должен быть не менее 1 дня.',
        ];
    }
}