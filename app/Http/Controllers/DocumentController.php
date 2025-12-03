<?php

namespace App\Http\Controllers;

use App\Enums\DocumentType;
use App\Enums\Status;
use App\Enums\WorkflowStatus;
use App\Http\Requests\StoreDocumentRequest;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\FolderDocumentService;

class DocumentController extends Controller
{
    public function __construct(
        protected FolderDocumentService $folderDocumentService
    ) {}

    public function index(Request $request)
    {
        $parentId = $request->query('parent_id');
        $categoryId = $request->query('category_id');

        $data = $this->folderDocumentService->getFolderData(
            parentId: $parentId,
            status: Status::published,
            categoryId: $categoryId
        );

        $data['categories'] = Category::orderBy('name')->get();

        return view('admin.documents.index', $data);
    }


    public function create()
    {
        $users = User::query()->paginate(10);
        $categories = Category::all();
        $templates = \App\Models\DocumentTemplate::where('active', true)
            ->select('id', 'name', 'content')
            ->get();

        return view('admin.documents.create', compact('templates', 'users', 'categories'));
    }

    public function store(StoreDocumentRequest $request)
    {
        $data = $request->validated();
        $data['due_date'] = $request->due_date;
        $data['user_id'] = auth()->id();
        $data['document_type'] = DocumentType::internal->value;
        $data['workflow_status'] = WorkflowStatus::draft->value;

        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = \Str::slug($data['title']);
        }

        $document = Document::create($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('documents', 'public');
                $document->files()->create(['file_path' => $path]);
            }
        }

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Документ успешно создан.');
    }


    public function show(Document $document)
    {
        $document->load('template');

        return view('admin.documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $templates = \App\Models\DocumentTemplate::where('active', true)
            ->select('id', 'name', 'content')
            ->get();

        return view('admin.documents.edit', [
            'document' => $document,
            'templates' => $templates,
        ]);
    }

    public function update(StoreDocumentRequest $request, Document $document)
    {
        $data = $request->validated();

        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = \Str::slug($data['title']);
        }

        $document->update($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('documents', 'public');
                $document->files()->create(['file_path' => $path]);
            }
        }

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Документ успешно обновлен.');
    }


    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Department deleted successfully.');
    }
}