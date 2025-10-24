<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FolderController extends Controller
{
    public function index(Request $request)
    {
        $parentId = $request->query('parent_id');

        $currentFolder = null;
        if ($parentId) {
            $currentFolder = Folder::with('parent')->findOrFail($parentId);
        }

        $folders = Folder::where('parent_id', $parentId)
            ->with('children')
            ->orderBy('order_index')
            ->get();

        $documents = Document::where('folder_id', $parentId)->get();

        return view('admin.folders.index', compact('folders', 'currentFolder', 'documents'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:folders,id'],
            'retention_period' => ['nullable', 'integer', 'min:1'],
        ]);

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
            'status' => 1, // активна
            'retention_period' => $request->retention_period,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'user_id' => auth()->id(),
        ]);

        Storage::disk('local')->makeDirectory($path);

        return redirect()->route('admin.folders.index')
            ->with('success', 'Папка успешно создана!');
    }

    public function show(Folder $folder)
    {
        $subfolders = Folder::where('parent_id', $folder->id)->orderBy('order_index')->get();

        $files = $folder->files()->orderBy('created_at', 'desc')->get();

        return view('admin.folders.show', compact('folder', 'subfolders', 'files'));
    }





}
