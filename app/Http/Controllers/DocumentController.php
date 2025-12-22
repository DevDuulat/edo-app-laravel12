<?php

namespace App\Http\Controllers;

use App\Enums\DocumentType;
use App\Enums\WorkflowStatus;
use App\Http\Requests\StoreDocumentRequest;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\PublishedService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function __construct(
        protected PublishedService $publishedService
    ) {}

    public function index(Request $request)
    {
        $parentId = $request->query('parent_id');
        $categoryId = $request->query('category_id');
        $date = $request->query('date');

        $data = $this->publishedService->getPublishedData(
            parentId: $parentId,
            categoryId: $categoryId,
            date: $date
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

    public function archive($id)
    {
        $model = Document::findOrFail($id);
        $model->markArchived();

        return response()->json(['success' => true]);
    }
    public function unarchive($id)
    {
        $model = Document::findOrFail($id);
        $model->markActive();

        return response()->json(['success' => true]);
    }

    public function trash($id)
    {
        $model = Document::findOrFail($id);
        $model->markTrashed();

        return response()->json(['success' => true]);
    }

    public function restore($id)
    {
        $model = Document::findOrFail($id);
        $model->markActive();

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $model = Document::findOrFail($id);
        $model->forceRemove();

        return response()->json(['success' => true]);
    }

    public function rename(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $document = Document::findOrFail($id);
        $document->title = $request->title;
        $document->save();

        return response()->json(['success' => true, 'title' => $document->title]);
    }

    public function copy($id)
    {
        $document = Document::with('files')->findOrFail($id);
        $newTitle = $document->title . ' копия';
        $slug = Str::slug($newTitle) . '-' . Str::random(6);

        $newDocument = Document::create([
            'title' => $newTitle,
            'slug' => $slug,
            'document_type' => $document->document_type->value,
            'comment' => $document->comment,
            'content' => $document->content,
            'due_date' => $document->due_date,
            'template_id' => $document->template_id,
            'folder_id' => $document->folder_id,
            'category_id' => $document->category_id,
            'status' => $document->status,
            'workflow_status' => $document->workflow_status->value,
            'user_id' => auth()->id(),
            'approved_at' => $document->approved_at,
        ]);

        foreach ($document->files as $file) {
            $newPath = 'documents/' . $newDocument->id . '/' . basename($file->path);
            Storage::disk('local')->copy($file->path, $newPath);

            $newDocument->files()->create([
                'filename' => $file->filename,
                'path' => $newPath,
                'user_id' => auth()->id(),
            ]);
        }

        return response()->json([
            'success' => true,
            'id' => $newDocument->id,
            'title' => $newDocument->title
        ]);
    }

    public function move(Request $request, $id)
    {
        $request->validate([
            'folder_id' => 'nullable|exists:folders,id'
        ]);

        $document = Document::findOrFail($id);
        $document->folder_id = $request->folder_id;
        $document->save();

        return response()->json(['success' => true]);
    }



}