<?php

namespace App\Http\Controllers;

use App\Enums\DocumentType;
use App\Enums\WorkflowStatus;
use App\Events\DocumentCreated;
use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\FolderDocumentService;

class DocumentController extends Controller
{
    public function __construct(
        protected FolderDocumentService $folderDocumentService
    ) {}

    public function index(Request $request)
    {
        $parentId = $request->query('parent_id');
        $data = $this->folderDocumentService->getFolderData($parentId);

        return view('admin.documents.index', $data);
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

        $document = Document::create($data);
        event(new DocumentCreated($document));

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('documents', 'public');
                $document->files()->create(['file_path' => $path]);
            }
        }

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