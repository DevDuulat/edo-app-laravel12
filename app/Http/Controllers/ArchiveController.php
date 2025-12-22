<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\ArchiveService;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    protected ArchiveService $archiveService;

    public function __construct(ArchiveService $archiveService)
    {
        $this->archiveService = $archiveService;
    }

    public function index(Request $request)
    {
        $parentId = $request->query('parent_id');
        $categoryId = $request->query('category_id');
        $date = $request->query('date');

        $data = $this->archiveService->getArchiveData($parentId, $categoryId, $date);
        $data['categories'] = Category::orderBy('name')->get();

        return view('admin.documents.index', $data);
    }
}
