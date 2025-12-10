<?php

namespace App\Services\Workflow;

use App\Enums\WorkflowUserRole;
use App\Enums\WorkflowUserStatus;
use App\Models\Document;
use App\Models\Workflow;
use App\Models\WorkflowDocument;
use App\Models\WorkflowUser;
use DefStudio\Telegraph\Facades\Telegraph;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class WorkflowService
{
    public function createWorkflow(array $data): Workflow
    {
        return Workflow::create([
            'title' => $data['title'] ?? 'Рабочий процесс — ' . now()->format('d.m.Y'),
            'slug' => $data['slug'] ?? Str::uuid(),
            'note' => $data['note'] ?? null,
            'due_date' => $data['due_date'] ?? null,
            'workflow_status' => $data['workflow_status'] ?? \App\Enums\WorkflowStatus::in_review->value,
            'user_id' => $data['user_id'],
        ]);
    }

    public function getWorkflowData(Workflow $workflow): array
    {
        $documents = $workflow->documents()->with('files')->get();
        $users = $workflow->users()->with('user')->orderBy('order_index')->get();
        $initiator = $workflow->user;
        $currentUserWorkflow = $workflow->users()->where('user_id', auth()->id())->first();

        return [
            'workflow' => $workflow,
            'documents' => $documents,
            'users' => $users,
            'initiator' => $initiator,
            'currentUserWorkflow' => $currentUserWorkflow,
        ];
    }

    public function attachDocumentsFromFolders(Workflow $workflow, array|Collection $folderIds, $documentIds): void
    {
        if (empty($documentIds) && empty($folderIds)) {
            return;
        }

        $folderDocuments = collect();
        if (!empty($folderIds)) {
            $folderDocuments = Document::whereIn('folder_id', $folderIds)->pluck('id');
        }

        $documentIds = collect($documentIds);
        $documents = $folderDocuments->merge($documentIds)->unique();

        foreach ($documents as $documentId) {
            WorkflowDocument::firstOrCreate([
                'workflow_id' => $workflow->id,
                'document_id' => $documentId,
            ]);
        }
    }

    public function attachUsers(Workflow $workflow, array $usersByRole, int $initiatorId): void
    {
        foreach ($usersByRole as $roleSlug => $userIds) {
            $role = collect(\App\Enums\WorkflowUserRole::cases())
                ->firstWhere(fn($r) => $r->slug() === $roleSlug);

            if (!$role) {
                continue;
            }

            foreach ($userIds as $index => $userId) {
                WorkflowUser::create([
                    'workflow_id' => $workflow->id,
                    'user_id' => $userId,
                    'role' => $role->value,
                    'order_index' => $index + 1,
                    'status' => \App\Enums\WorkflowUserStatus::Pending->value,
                ]);
            }
        }

        WorkflowUser::create([
            'workflow_id' => $workflow->id,
            'user_id' => $initiatorId,
            'role' => WorkflowUserRole::Initiator->value,
            'order_index' => 0,
            'status' => WorkflowUserStatus::Pending->value,
        ]);
    }

    protected function notifyUsers(Workflow $workflow): void
    {
        $users = $workflow->users()->with('user')->get();
        $url = route('admin.workflows.show', $workflow->slug);

        foreach ($users as $participant) {
            $u = $participant->user;

            if (!$u || !$u->telegram_id) {
                continue;
            }

            Telegraph::chat($u->telegram_id)
                ->message(
                    "У вас новый рабочий процесс\n" .
                    "Название: {$workflow->title}\n" .
                    "Ссылка: {$url}"
                )
                ->send();
        }
    }

    public function createFullWorkflow(array $data): Workflow
    {
        $workflow = $this->createWorkflow([
            'note' => $data['note'] ?? null,
            'due_date' => $data['due_date'],
            'user_id' => $data['user_id'],
        ]);

        $this->attachDocumentsFromFolders($workflow, $data['folder_ids'] ?? [], $data['document_ids'] ?? []);
        $this->attachUsers($workflow, $data['user_ids'] ?? [], $data['user_id']);

        $this->notifyUsers($workflow);

        return $workflow;
    }
}
