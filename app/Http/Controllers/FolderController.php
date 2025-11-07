<?php

namespace App\Http\Controllers;

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
        $data = $this->folderDocumentService->getFolderData($parentId);

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

        $folder = Folder::create([
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

    public function destroy(Folder $folder)
    {
        if ($folder->is_root ?? false) {
            return redirect()->back()->with('error', 'Нельзя удалить корневую папку.');
        }

        $folder->delete();

        return redirect()
            ->route('admin.folders.index')
            ->with('success', 'Папка успешно удалена.');
    }






}
