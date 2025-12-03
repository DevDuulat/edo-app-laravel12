<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Services\FolderDocumentService;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function __construct(
        protected FolderDocumentService $folderDocumentService
    ) {}


    public function index(Request $request)
    {
        $parentId = $request->query('parent_id');
        $data = $this->folderDocumentService->getFolderData(
            parentId: $parentId,
            status: Status::trash
        );

        return view('admin.folders.index', $data);
    }
}
