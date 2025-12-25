<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDocumentTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'active' => ['sometimes', 'boolean'],
            'slug' => [
                'required',
                'string',
                Rule::unique('document_templates', 'slug')
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Название" обязательно для заполнения.',
            'name.string' => 'Название должно быть строкой.',
            'name.max' => 'Название не может превышать 255 символов.',
            'slug.unique' => 'Шаблон с таким названием (или ссылкой) уже существует.',
            'description.max' => 'Описание не должно превышать 255 символов.',
            'active.boolean' => 'Некорректное значение поля активности.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->filled('name')) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->name),
            ]);
        }
    }

}
