<?php

namespace App\Http\Controllers;

use App\Enums\ActiveStatus;
use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

    public function edit(DocumentTemplate $documentTemplate)
    {
        return view('admin.document-templates.edit', compact('documentTemplate'));
    }

    public function update(Request $request, DocumentTemplate $documentTemplate)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'integer', 'in:0,1'],
        ]);

        $documentTemplate->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'active' => $validatedData['status'] == \App\Enums\ActiveStatus::active->value,
        ]);

        $documentTemplate->content = $validatedData['content'] ?? '';
        $documentTemplate->save();

        return redirect()->route('admin.document-templates.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Шаблон успешно обновлён.',
            ]);
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
