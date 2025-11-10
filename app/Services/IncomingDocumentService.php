<?php

namespace App\Services;

use App\Enums\WorkflowUserRole;
use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;

class IncomingDocumentService
{
    public function getIncomingDocumentsWithWorkflow(?int $folderId = null): Collection
    {
        return Document::query()
            ->when($folderId, fn($q) => $q->where('folder_id', $folderId))
            ->whereHas('workflows.users', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('role', '!=', WorkflowUserRole::Initiator);
            })
            ->with([
                'workflows' => fn($q) => $q->with(['initiator', 'users.user']),
            ])
            ->get(['id', 'title', 'folder_id', 'created_at', 'user_id']);
    }

    public function countIncomingDocuments(?int $parentId = null): int
    {
        return $this->getIncomingDocumentsWithWorkflow($parentId)->count();
    }

}