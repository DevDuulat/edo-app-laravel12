<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'folder_id' => ['nullable', 'integer', 'exists:folders,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'title' => 'required|string|max:255|unique:documents,title,' . ($this->document?->id ?? ''),
            'slug' => 'required|string|max:255|unique:documents,title,' . ($this->document?->id ?? ''),
            'due_date' => 'required|date|after_or_equal:today',
            'comment' => 'nullable|string',
            'content' => ['nullable', 'string'],
            'template_id' => 'nullable|integer|exists:document_templates,id',
        ];
    }

}
