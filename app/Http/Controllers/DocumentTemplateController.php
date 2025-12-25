<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentTemplateRequest;
use App\Http\Requests\UpdateDocumentTemplateRequest;
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
    public function store(StoreDocumentTemplateRequest $request)
    {
        DocumentTemplate::create($request->validated());

        Alert::success('Шаблон успешно создан!', 'Готово');

        return redirect()->route('admin.document-templates.index');
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

    public function update(UpdateDocumentTemplateRequest $request, DocumentTemplate $documentTemplate)
    {
        $documentTemplate->update($request->validated());

        Alert::success('Шаблон успешно обновлен!', 'Готово');

        return redirect()->route('admin.document-templates.index');
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
