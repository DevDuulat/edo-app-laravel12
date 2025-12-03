<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Category;
use App\Models\Department;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Folder;
use App\Services\FolderDocumentService;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function __construct(
        protected FolderDocumentService $folderDocumentService
    ) {}

    public function index(Request $request)
    {
        $parentId = $request->query('parent_id');
        $data = $this->folderDocumentService->getFolderData(
            parentId: $parentId,
            status: Status::archived
        );

        return view('admin.folders.index', $data);
    }

}
