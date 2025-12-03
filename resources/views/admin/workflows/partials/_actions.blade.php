<!-- Footer Actions for Overview -->
<footer class="p-6 border-t bg-gray-50 rounded-xl flex flex-col items-center gap-5">
    @php
        $workflowStatus = \App\Enums\WorkflowStatus::from($workflow->workflow_status);
        $currentRole = $currentUserWorkflow?->role;
    @endphp

    @if($currentUserWorkflow)

        @if($currentUserWorkflow->isPending() && $currentRole->can('approve'))
            <div class="flex flex-wrap justify-center gap-4">
                <form method="POST" action="{{ route('admin.workflows.approve', $workflow->id) }}">
                    @csrf
                    <button type="submit"
                            class="min-w-[180px] py-2.5 px-6 bg-green-600 text-white font-medium rounded-xl
                                       shadow-sm hover:bg-green-700 active:scale-[0.98] transition-all">
                        Утвердить
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.workflows.reject', $workflow->id) }}">
                    @csrf
                    <button type="submit"
                            class="min-w-[180px] py-2.5 px-6 bg-red-600 text-white font-medium rounded-xl
                                       shadow-sm hover:bg-red-700 active:scale-[0.98] transition-all">
                        Отклонить
                    </button>
                </form>
            </div>

            <form method="POST" action="{{ route('admin.workflows.redirect', $workflow->id) }}"
                  class="flex flex-col sm:flex-row gap-3 w-full max-w-md justify-center mt-4">
                @csrf
                <select name="redirect_to"
                        class="flex-1 py-2.5 border-gray-300 rounded-xl bg-white shadow-sm
                                   focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                    @foreach($users as $workflowUserItem)
                        @if($workflowUserItem->user_id !== auth()->id())
                            <option value="{{ $workflowUserItem->user_id }}">{{ $workflowUserItem->user->name }}</option>
                        @endif
                    @endforeach
                </select>

                <button type="submit"
                        class="py-2.5 px-5 bg-yellow-500 text-white font-medium rounded-xl
                                   shadow-sm hover:bg-yellow-600 active:scale-[0.98] transition-all">
                    Перенаправить
                </button>
            </form>

        @elseif($workflowStatus === \App\Enums\WorkflowStatus::approved && $currentRole->can('execute'))
            <form method="POST" action="{{ route('admin.workflows.execute', $workflow->id) }}">
                @csrf
                <button type="submit"
                        class="min-w-[180px] py-2.5 px-6 bg-blue-600 text-white font-medium rounded-xl
                                   shadow-sm hover:bg-blue-700 active:scale-[0.98] transition-all">
                    Выполнить задачу
                </button>
            </form>

        @else
            <p class="text-gray-500 text-center text-sm">
                Вы уже выполнили действие в этом процессе или у вас нет прав.
            </p>
        @endif

    @else
        <p class="text-gray-500 text-center text-sm">Вы не участвуете в этом процессе.</p>
    @endif
</footer>