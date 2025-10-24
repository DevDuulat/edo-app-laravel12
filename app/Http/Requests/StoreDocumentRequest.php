<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
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
            'folder_id' => ['nullable', 'integer', 'exists:folders,id'],
            'title' => 'required|string|max:255|unique:documents,title,' . ($this->document?->id ?? ''),
            'due_date' => 'required|date|after_or_equal:today',
            'comment' => 'nullable|string',
        ];
    }

}
