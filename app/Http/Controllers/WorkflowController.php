<?php

namespace App\Http\Controllers;

use App\Enums\WorkflowUserStatus;
use App\Http\Requests\StoreWorkflowRequest;
use App\Models\Workflow;
use App\Models\WorkflowUser;
use App\Services\WorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = Workflow::all();
        return view('admin.folders.index', compact('workflows'));
    }
    public function create()
    {
//        return view('admin.workflow.create');
    }

    public function store(StoreWorkflowRequest $request, WorkflowService $workflowService)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $workflowService) {
            $workflowService->createFullWorkflow([
                'note' => $validated['comment'] ?? null,
                'due_date' => $validated['due_date'],
                'user_id' => auth()->id(),
                'folder_ids' => $validated['folder_ids'] ?? [],
                'document_ids' => $validated['document_ids'] ?? [],
                'user_ids' => $validated['user_ids'] ?? [],
            ]);
        });

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Рабочий процесс успешно создан.'
        ]);
    }

    public function show(Workflow $workflow)
    {
        $documents = $workflow->documents()
            ->with('files')
            ->get();

        $users = $workflow->users()
            ->with('user')
            ->orderBy('order_index')
            ->get();

        $initiator = $workflow->user;

        $currentUserWorkflow = $workflow->users()
            ->where('user_id', auth()->id())
            ->first();

        return view('admin.workflow.show', [
            'workflow' => $workflow,
            'documents' => $documents,
            'users' => $users,
            'initiator' => $initiator,
            'currentUserWorkflow' => $currentUserWorkflow,
        ]);
    }


    public function approve(Request $request, Workflow $workflow)
    {
        $workflowUser = $this->getWorkflowUser($workflow);
        if (!$workflowUser) abort(403, 'Нет доступа к этому процессу.');

        $workflowUser->update([
            'status' => WorkflowUserStatus::Approved,
            'acted_at' => now(),
        ]);

        return back()->with('alert', [
            'type' => 'success',
            'message' => 'Вы утвердили документ.',
        ]);
    }

    public function reject(Request $request, Workflow $workflow)
    {
        $workflowUser = $this->getWorkflowUser($workflow);
        if (!$workflowUser) abort(403, 'Нет доступа к этому процессу.');

        $workflowUser->update([
            'status' => WorkflowUserStatus::Rejected,
            'acted_at' => now(),
        ]);

        return back()->with('alert', [
            'type' => 'error',
            'message' => 'Вы отклонили документ.',
        ]);
    }

    public function redirect(Request $request, Workflow $workflow)
    {
        $workflowUser = $this->getWorkflowUser($workflow);
        if (!$workflowUser) abort(403, 'Нет доступа к этому процессу.');

        $request->validate([
            'redirect_to' => 'required|exists:users,id',
        ]);

        DB::transaction(function () use ($workflowUser, $request, $workflow) {
            $workflowUser->update([
                'status' => WorkflowUserStatus::Redirected,
                'acted_at' => now(),
            ]);

            WorkflowUser::create([
                'workflow_id' => $workflow->id,
                'user_id' => $request->input('redirect_to'),
                'role' => $workflowUser->role,
                'order_index' => $workflowUser->order_index + 0.1,
                'status' => WorkflowUserStatus::Pending,
            ]);
        });

        return back()->with('alert', [
            'type' => 'info',
            'message' => 'Вы перенаправили документ другому пользователю.',
        ]);
    }

    private function getWorkflowUser(Workflow $workflow): ?WorkflowUser
    {
        return WorkflowUser::where('workflow_id', $workflow->id)
            ->where('user_id', auth()->id())
            ->first();
    }



}
