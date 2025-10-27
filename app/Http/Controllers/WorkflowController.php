<?php

namespace App\Http\Controllers;

use App\Enums\WorkflowUserRole;
use App\Enums\WorkflowUserStatus;
use App\Models\Document;
use App\Models\Workflow;
use App\Models\WorkflowUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = Workflow::all();
        return view('admin.folders.index', compact('workflows'));
    }
    public function create()
    {
        return view('admin.workflow.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'due_date' => ['required', 'date'],
            'comment' => ['nullable', 'string'],
            'folder_id' => ['nullable', 'integer', 'exists:folders,id'],
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
        ]);

        DB::transaction(function () use ($validated, $request) {

            $workflow = Workflow::create([
                'title' => 'Рабочий процесс — ' . now()->format('d.m.Y'),
                'slug' => Str::uuid(),
                'note' => $validated['comment'] ?? null,
                'due_date' => $validated['due_date'],
                'workflow_status' => 0,
                'user_id' => auth()->id(),
            ]);

            if (!empty($validated['folder_id'])) {
                $documents = Document::where('folder_id', $validated['folder_id'])->pluck('id');

                if ($documents->isNotEmpty()) {
                    $workflow->documents()->attach($documents);
                }
            }

            foreach ($validated['user_ids'] as $index => $userId) {
                WorkflowUser::create([
                    'workflow_id' => $workflow->id,
                    'user_id' => $userId,
                    'role' => WorkflowUserRole::Participant->value,
                    'order_index' => $index + 1,
                    'status' => WorkflowUserStatus::Pending->value,
                ]);
            }

            WorkflowUser::create([
                'workflow_id' => $workflow->id,
                'user_id' => auth()->id(),
                'role' => WorkflowUserRole::Initiator->value,
                'order_index' => 0,
                'status' => WorkflowUserStatus::Approved->value,
                'acted_at' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Рабочий процесс успешно создан.');
    }

}
