<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\StoreFolderRequest;
use App\Models\Folder;
use App\Services\FolderDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FolderController extends Controller
{
    public function __construct(
        protected FolderDocumentService $folderDocumentService
    ) {}

    public function index(Request $request)
    {
        $parentId = $request->query('parent_id');
        $data = $this->folderDocumentService->getFolderData(
            parentId: $parentId,
            status: Status::published
        );

        return view('admin.folders.index', $data);
    }

    public function store(StoreFolderRequest $request)
    {
        $parentPath = null;
        if ($request->parent_id) {
            $parentFolder = Folder::find($request->parent_id);
            $parentPath = $parentFolder->path;
        }

        $slug = Str::slug($request->name);
        $path = $parentPath ? $parentPath . '/' . $slug : 'root/' . $slug;

        Folder::create([
            'name' => $request->name,
            'slug' => $slug,
            'path' => $path,
            'parent_id' => $request->parent_id,
            'order_index' => 0,
            'status' => 1,
            'retention_period' => $request->retention_period,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'user_id' => auth()->id(),
        ]);

        Storage::disk('local')->makeDirectory($path);

        return redirect()->route('admin.folders.index')->with('alert', [
            'type' => 'success',
            'message' => 'Папка успешно создана!'
        ]);
    }

    public function show(Folder $folder)
    {
        $subfolders = Folder::where('parent_id', $folder->id)->orderBy('order_index')->get();

        $files = $folder->files()->orderBy('created_at', 'desc')->get();
        return view('admin.folders.show', compact('folder', 'subfolders', 'files'));
    }

    public function copy($id)
    {
        $folder = Folder::findOrFail($id);

        $newName = $folder->name . ' копия';
        $slug = Str::slug($newName);
        $path = $folder->parent_id ? $folder->parent->path . '/' . $slug : 'root/' . $slug;

        $newFolder = Folder::create([
            'name' => $newName,
            'slug' => $slug,
            'path' => $path,
            'parent_id' => $folder->parent_id,
            'order_index' => 0,
            'status' => 1,
            'retention_period' => $folder->retention_period,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'user_id' => auth()->id(),
        ]);

        Storage::disk('local')->makeDirectory($path);

        return response()->json(['success' => true, 'id' => $newFolder->id, 'name' => $newFolder->name]);
    }

    public function move(Request $request, $id)
    {
        $request->validate([
            'parent_id' => 'nullable|exists:folders,id'
        ]);

        $folder = Folder::findOrFail($id);
        $parentPath = $request->parent_id ? Folder::find($request->parent_id)->path : null;
        $slug = Str::slug($folder->name);
        $folder->parent_id = $request->parent_id;
        $folder->path = $parentPath ? $parentPath . '/' . $slug : 'root/' . $slug;
        $folder->save();

        return response()->json(['success' => true, 'path' => $folder->path]);
    }


    public function archive($id)
    {
        $model = Folder::findOrFail($id);
        $model->markArchived();

        return response()->json(['success' => true]);
    }

    public function unarchive($id)
    {
        $model = Folder::findOrFail($id);
        $model->markActive();

        return response()->json(['success' => true]);
    }

    public function trash($id)
    {
        $model = Folder::findOrFail($id);
        $model->markTrashed();

        return response()->json(['success' => true]);
    }

    public function restore($id)
    {
        $model = Folder::findOrFail($id);
        $model->markActive();

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $model = Folder::findOrFail($id);
        $model->forceRemove();

        return response()->json(['success' => true]);
    }

    public function rename(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $folder = Folder::findOrFail($id);
        $folder->name = $request->name;
        $folder->save();

        return response()->json(['success' => true, 'name' => $folder->name]);
    }


}
