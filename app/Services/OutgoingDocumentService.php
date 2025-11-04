<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;

class OutgoingDocumentService
{
    public function getOutgoingDocumentsWithWorkflow(?int $folderId = null): Collection
    {
        return Document::query()
            ->when($folderId, fn($q) => $q->where('folder_id', $folderId))
            ->whereHas('workflows')
            ->where(function ($q) {
                $q->where('user_id', auth()->id())
                    ->orWhereHas('workflows', function ($query) {
                        $query->where('user_id', auth()->id());
                    });
            })
            ->with(['workflows.initiator'])
            ->get(['id', 'title', 'folder_id', 'created_at', 'user_id']);
    }
}