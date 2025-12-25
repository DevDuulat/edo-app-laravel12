<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UpdateDocumentTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $templateId = $this->route('document_template')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'active' => ['sometimes', 'boolean'],
            'slug' => [
                'required',
                'string',
                Rule::unique('document_templates', 'slug')->ignore($templateId)
            ],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->filled('name')) {
            $this->merge([
                'slug' => Str::slug($this->name),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Название" обязательно.',
            'slug.unique' => 'Шаблон с таким названием уже существует.',
        ];
    }
}
