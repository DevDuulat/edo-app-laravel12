<?php

namespace App\Http\Controllers;

use App\Enums\DocumentType;
use App\Enums\WorkflowStatus;
use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::query()->paginate('10');
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $users = User::query()->paginate(10);

        return view('admin.documents.create', compact('users'));
    }


    public function store(StoreDocumentRequest $request)
    {
        $data = $request->validated();
        $data['due_date'] = $request->due_date;
        $data['user_id'] = auth()->id();
        $data['document_type'] = DocumentType::internal->value;
        $data['workflow_status'] = WorkflowStatus::draft->value;
        $data['slug'] = Str::slug($data['title']);
        Document::create($data);

        return redirect()
            ->route('admin.folders.index')
            ->with('success', 'Документ успешно создан.');
    }



    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }
    public function update(Request $request, Document $document)
    {

    }

    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Department deleted successfully.');
    }
}
