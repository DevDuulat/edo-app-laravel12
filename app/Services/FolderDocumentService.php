<?php

namespace App\Services;

use App\Enums\Status;
use App\Enums\WorkflowUserRole;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use App\Enums\ActiveStatus;

class FolderDocumentService
{
    public function getFolderData(
        ?int $parentId = null,
        ?Status $status = null,
        ?int $categoryId = null,
        ?string $date = null
    ): array {
        $currentFolder = $parentId
            ? Folder::with('parent')
                ->when($status, fn($q) => $q->where('status', $status))
                ->findOrFail($parentId)
            : null;

        $folders = Folder::where('parent_id', $parentId)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($date, fn($q) => $q->whereDate('created_at', $date))
            ->orderBy('order_index')
            ->get(['id','name','slug','status','created_at']);

        $documents = Document::where('folder_id', $parentId)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($date, fn($q) => $q->whereDate('created_at', $date))
            ->with('workflows')
            ->get(['id','title','folder_id','category_id','created_at']);

        $users = User::select('id','name')->get();
        $roles = WorkflowUserRole::cases();
        $activeStatus = ActiveStatus::cases();

        return compact('folders','documents','currentFolder','users','activeStatus','roles');
    }
}
