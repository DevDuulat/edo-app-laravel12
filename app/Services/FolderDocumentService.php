<?php

namespace App\Services;

use App\Enums\WorkflowUserRole;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use App\Enums\ActiveStatus;

class FolderDocumentService
{
    public function getFolderData(?int $parentId = null, ?int $categoryId = null): array
    {
        $currentFolder = $parentId
            ? Folder::with('parent')->findOrFail($parentId)
            : null;

        $folders = Folder::where('parent_id', $parentId)
            ->orderBy('order_index')
            ->get(['id', 'name', 'created_at']);

        $documents = Document::query()
            ->where('folder_id', $parentId)
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->with('workflows')
            ->get(['id', 'title', 'folder_id', 'category_id', 'created_at']);

        $users = User::select('id', 'name')->get();
        $roles = WorkflowUserRole::cases();
        $activeStatus = ActiveStatus::cases();

        return compact('folders', 'documents', 'currentFolder', 'users', 'activeStatus', 'roles');
    }
}
