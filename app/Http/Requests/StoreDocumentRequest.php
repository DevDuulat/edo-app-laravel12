<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $documentId = $this->route('document')?->id;

        return [
            'folder_id' => ['nullable', 'integer', 'exists:folders,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('documents', 'title')->ignore($documentId)
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('documents', 'slug')->ignore($documentId)
            ],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
            'comment' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'template_id' => ['nullable', 'integer', 'exists:document_templates,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Введите заголовок документа.',
            'title.string' => 'Заголовок должен быть текстовой строкой.',
            'title.max' => 'Заголовок не должен превышать 255 символов.',
            'title.unique' => 'Документ с таким заголовком уже существует.',
            'slug.required' => 'Поле slug обязательно для заполнения.',
            'slug.unique' => 'Этот URL-адрес (slug) уже используется.',
            'due_date.required' => 'Укажите срок исполнения (дата).',
            'due_date.date' => 'Введите корректный формат даты.',
            'due_date.after_or_equal' => 'Дата не может быть в прошлом.',
            'folder_id.integer' => 'ID папки должен быть числом.',
            'folder_id.exists' => 'Выбранная папка не существует.',
            'category_id.integer' => 'ID категории должен быть числом.',
            'category_id.exists' => 'Выбранная категория не существует.',
            'template_id.integer' => 'ID шаблона должен быть числом.',
            'template_id.exists' => 'Выбранный шаблон документа не найден.',
            'content.string' => 'Содержимое должно быть текстом.',
            'comment.string' => 'Комментарий должен быть текстом.',
        ];
    }
}