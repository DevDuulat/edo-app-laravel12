<?php

namespace App\Http\Controllers;

use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class DocumentTemplateController extends Controller
{
    public function index()
    {
        $documentTemplates = DocumentTemplate::all();

        return view('admin.document-templates.index', [
            'folders' => collect(),
            'documents' => $documentTemplates,
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'active' => ['sometimes', 'boolean'],
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        DocumentTemplate::create($validatedData);

        return redirect()
            ->route('admin.document-templates.index')
            ->with('success', 'Шаблон документа успешно создан.');
    }

    public function show(DocumentTemplate $documentTemplate)
    {
        return view('admin.document-templates.show', compact('documentTemplate'));
    }

}
