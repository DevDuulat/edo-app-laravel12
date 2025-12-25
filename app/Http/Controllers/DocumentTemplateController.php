<?php

namespace App\Http\Controllers;

use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Alert;

class DocumentTemplateController extends Controller
{
    public function index()
    {
        $documentTemplates = DocumentTemplate::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.document-templates.index', [
            'folders' => collect(),
            'documents' => $documentTemplates,
        ]);
    }

    public function create()
    {
        return view('admin.document-templates.create');
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
        Alert::success('Шаблон успешно создан!', 'Готово');

        return redirect()
            ->route('admin.document-templates.index');
    }

    public function show(DocumentTemplate $documentTemplate)
    {
        return view('admin.document-templates.show', compact('documentTemplate'));
    }

    public function edit(DocumentTemplate $documentTemplate)
    {
        return view('admin.document-templates.edit', [
            'template' => $documentTemplate,
        ]);
    }

    public function update(Request $request, DocumentTemplate $documentTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $documentTemplate->update($validated);
        Alert::success('Шаблон успешно обновлен!', 'Готово');
        return redirect()
            ->route('admin.document-templates.index');
    }


    public function destroy(DocumentTemplate $documentTemplate)
    {
        $documentTemplate->delete();

        return redirect()->route('admin.document-templates.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Шаблон успешно удалён.',
            ]);
    }



}
