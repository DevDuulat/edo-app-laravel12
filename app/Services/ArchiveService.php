<?php

namespace App\Services;

use App\Enums\Status;
use App\Enums\WorkflowUserRole;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use App\Enums\ActiveStatus;

class ArchiveService
{
    public function getArchiveData(
        ?int $parentId = null,
        ?int $categoryId = null,
        ?string $date = null
    ): array {
        $currentFolder = $parentId
            ? Folder::with('parent')
                ->where('status', Status::archived)
                ->findOrFail($parentId)
            : null;

        $folders = Folder::where('parent_id', $parentId)
            ->where('status', Status::archived)
            ->when($date, fn($q) => $q->whereDate('created_at', $date))
            ->orderBy('order_index')
            ->get(['id','name','slug','status','created_at']);

        $documents = Document::where('folder_id', $parentId)
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($date, fn($q) => $q->whereDate('created_at', $date))
            ->where(function($q) {
                $q->where('status', Status::archived->value)
                    ->orWhereHas('workflows', fn($qq) => $qq->where('status', Status::archived->value));
            })
            ->with(['workflows' => fn($q) => $q->where('status', Status::archived->value)])
            ->get(['id','title','folder_id','category_id','created_at']);

        $documents = $documents->sortByDesc(fn($doc) => $doc->workflows->isNotEmpty() ? 1 : 0);

        $users = User::select('id','name')->get();
        $roles = WorkflowUserRole::cases();
        $activeStatus = ActiveStatus::cases();

        return compact('folders','documents','currentFolder','users','activeStatus','roles');
    }
}
