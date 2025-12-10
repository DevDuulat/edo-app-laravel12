<?php

namespace App\Http\Controllers;

use App\Enums\ActiveStatus;
use App\Enums\WorkflowStatus;
use App\Enums\WorkflowUserRole;
use App\Enums\WorkflowUserStatus;
use App\Events\CommentCreated;
use App\Http\Requests\StoreWorkflowRequest;
use App\Models\User;
use App\Models\Workflow;
use App\Models\WorkflowUser;
use App\Services\FolderDocumentService;
use App\Services\IncomingDocumentService;
use App\Services\OutgoingDocumentService;
use App\Services\Workflow\WorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkflowController extends Controller
{
    protected WorkflowService $workflowService;
    protected FolderDocumentService $folderDocumentService;

    public function __construct(
        WorkflowService $workflowService,
        FolderDocumentService $folderDocumentService
    ) {
        $this->workflowService = $workflowService;
        $this->folderDocumentService = $folderDocumentService;
    }

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
                'note' => $validated['note'] ?? null,
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
        $data = $this->workflowService->getWorkflowData($workflow);
        return view('admin.workflows.show', $data);
    }


    public function approve(Request $request, Workflow $workflow)
    {
        $workflowUser = $this->getWorkflowUser($workflow);

        if (!$workflowUser) {
            abort(403, 'Нет доступа к этому процессу.');
        }

        if ($workflowUser->role !== \App\Enums\WorkflowUserRole::Approver) {
            abort(403, 'Только согласующие могут утверждать документ.');
        }

        $workflowUser->update([
            'status' => \App\Enums\WorkflowUserStatus::Approved,
            'acted_at' => now(),
        ]);

        $allApproved = $workflow->users()
            ->where('role', \App\Enums\WorkflowUserRole::Approver)
            ->whereNotIn('status', [
                \App\Enums\WorkflowUserStatus::Approved,
                \App\Enums\WorkflowUserStatus::Redirected
            ])
            ->doesntExist();

        if ($allApproved) {
            $workflow->update([
                'workflow_status' => \App\Enums\WorkflowStatus::approved,
            ]);
        }

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

        if (!$workflowUser) {
            abort(403, 'Нет доступа к этому процессу.');
        }

        $request->validate([
            'redirect_to' => 'required|exists:users,id',
        ]);

        $targetUserId = $request->input('redirect_to');

        DB::transaction(function () use ($workflowUser, $workflow, $targetUserId) {
            $workflowUser->update([
                'status' => WorkflowUserStatus::Redirected,
                'acted_at' => now(),
            ]);

            $workflow->users()->updateOrCreate(
                [
                    'workflow_id' => $workflow->id,
                    'user_id' => $targetUserId,
                ],
                [
                    'role' => $workflowUser->role->value,
                    'order_index' => $workflowUser->order_index + 0.1,
                    'status' => WorkflowUserStatus::Pending->value,
                ]
            );
        });

        return back()->with('alert', [
            'type' => 'info',
            'message' => 'Вы перенаправили документ другому пользователю.',
        ]);
    }

    public function execute(Request $request, Workflow $workflow)
    {
        $user = auth()->user();

        $workflowUser = $workflow->users()
            ->where('user_id', $user->id)
            ->where('role', \App\Enums\WorkflowUserRole::Executor)
            ->first();

        if (!$workflowUser) {
            return back()->with('error', 'Вы не являетесь исполнителем этого процесса.');
        }

        $workflowUser->update([
            'status' => WorkflowUserStatus::Approved,
            'acted_at' => now(),
        ]);

        if ($workflow->workflow_status === WorkflowStatus::approved->value) {
            $workflow->update([
                'workflow_status' => WorkflowStatus::completed->value,
            ]);
        }

        return back()->with('success', 'Задача успешно выполнена.');
    }



    private function getWorkflowUser(Workflow $workflow): ?WorkflowUser
    {
        return WorkflowUser::where('workflow_id', $workflow->id)
            ->where('user_id', auth()->id())
            ->first();
    }

    public function outgoing(Request $request, OutgoingDocumentService $outgoingService)
    {
        $parentId = $request->query('parent_id');
        $categoryId = $request->query('category_id');

        $documents = $outgoingService->getOutgoingDocumentsWithWorkflow($parentId);

        $documents = $documents->when($categoryId, function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        });

        $folders = collect();
        $users = User::select('id', 'name')->get();
        $activeStatus = ActiveStatus::cases();
        $currentFolder = null;
        $roles = WorkflowUserRole::cases();
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('admin.documents.index', compact(
            'folders',
            'documents',
            'currentFolder',
            'users',
            'activeStatus',
            'roles',
            'categories'
        ));
    }


    public function incoming(Request $request, IncomingDocumentService $incomingService)
    {
        $parentId = $request->query('parent_id');
        $categoryId = $request->query('category_id');

        $documents = $incomingService->getIncomingDocumentsWithWorkflow($parentId);

        $documents = $documents->when($categoryId, fn($q) => $q->where('category_id', $categoryId));

        $folders = collect();
        $users = User::select('id', 'name')->get();
        $activeStatus = ActiveStatus::cases();
        $currentFolder = null;
        $roles = WorkflowUserRole::cases();
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('admin.documents.index', compact(
            'folders',
            'documents',
            'currentFolder',
            'users',
            'activeStatus',
            'roles',
            'categories'
        ));
    }

    public function storeComment(Request $request, Workflow $workflow)
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        $comment = $workflow->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Комментарий добавлен.',
                'comment' => [
                    'user' => $comment->user->name,
                    'text' => $comment->comment,
                    'created_at' => $comment->created_at->diffForHumans(),
                ]
            ]);
        }
        event(new CommentCreated($comment));

        return back()->with('success', 'Комментарий добавлен.');
    }



}
