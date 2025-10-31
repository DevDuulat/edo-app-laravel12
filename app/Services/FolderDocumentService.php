<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use App\Enums\ActiveStatus;

class FolderDocumentService
{
    public function getFolderData(?int $parentId = null): array
    {
        $currentFolder = $parentId
            ? Folder::with('parent')->findOrFail($parentId)
            : null;

        $folders = Folder::where('parent_id', $parentId)
            ->orderBy('order_index')
            ->get(['id', 'name', 'created_at']);

        $documents = Document::where('folder_id', $parentId)
            ->get(['id', 'title', 'folder_id', 'created_at']);

        $users = User::select('id', 'name')->get();
        $activeStatus = ActiveStatus::cases();

        return compact('folders', 'documents', 'currentFolder', 'users', 'activeStatus');
    }
}
