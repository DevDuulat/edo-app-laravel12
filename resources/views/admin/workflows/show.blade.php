<x-layouts.app :title="__('Рабочий процесс')">
    @php
        $status = \App\Enums\WorkflowStatus::from($workflow->workflow_status);
    @endphp

    <div class="space-y-6">
        <div class="mb-8">
            <nav id="workflowTabs" class="flex overflow-x-auto bg-gray-100/70 rounded-2xl border border-gray-300 p-1">
                @foreach(['overview' => 'Обзор', 'users' => 'Пользователи', 'files' => 'Файлы', 'comments' => 'Комментарии', 'history' => 'История'] as $id => $label)
                    <button data-tab="{{ $id }}"
                            class="whitespace-nowrap px-5 py-2.5 text-sm font-medium rounded-xl text-gray-600 hover:text-gray-800 hover:bg-white/60">
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </div>

        <div id="tabContent">
            <div id="overview" class="tab-pane">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ $workflow->title }}
                        </h1>
                        <span class="px-3 py-1 text-sm rounded-full
                            bg-{{ $status->color() }}-200 text-{{ $status->color() }}-800">
                            {{ $status->label() }}
                        </span>
                    </div>
                    @if($workflow->note)
                        <p class="text-gray-600 dark:text-gray-400">{{ $workflow->note }}</p>
                    @endif
                </div>

                <section class="p-6 bg-white rounded-xl border border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Инициатор</h2>
                    @if($initiator)
                        <div class="flex flex-col gap-2">
                            <div class="font-medium text-gray-800">{{ $initiator->name }}</div>
                            <div class="text-gray-500">{{ $initiator->email }}</div>
                            <div class="text-gray-600 mt-2">просит Вас одобрить документ</div>
                        </div>
                    @else
                        <div class="text-gray-500">Инициатор не указан</div>
                    @endif
                </section>

                @include('admin.workflows.partials._actions')
            </div>

            <div id="users" class="tab-pane hidden">
                @include('admin.workflows.partials._users')
            </div>

            <div id="files" class="tab-pane hidden">
                @include('admin.workflows.partials._files')
            </div>

            <div id="comments" class="tab-pane hidden flex flex-col bg-white rounded-xl border border-gray-200 h-[70vh] max-h-[800px]">
                @include('admin.workflows.partials._comment')
            </div>

            <div id="history" class="tab-pane hidden">
                @include('admin.workflows.partials._history')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('#workflowTabs button');
            const panes = document.querySelectorAll('.tab-pane');
            const hash = window.location.hash.substring(1);
            let activeTab = localStorage.getItem('workflow-active-tab') || (['overview','users','files','comments','history'].includes(hash) ? hash : 'overview');

            function showTab(id) {
                panes.forEach(p => p.classList.add('hidden'));
                document.getElementById(id).classList.remove('hidden');

                tabs.forEach(btn => {
                    btn.classList.remove('bg-white', 'text-gray-900', 'border', 'border-gray-300');
                    btn.classList.add('text-gray-600', 'hover:text-gray-800', 'hover:bg-white/60');
                    if (btn.dataset.tab === id) {
                        btn.classList.add('bg-white', 'text-gray-900', 'border', 'border-gray-300');
                        btn.classList.remove('text-gray-600', 'hover:text-gray-800', 'hover:bg-white/60');
                    }
                });

                localStorage.setItem('workflow-active-tab', id);
                window.history.replaceState(null, '', '#' + id);

                if (id === 'comments') scrollCommentsBottom();
            }

            tabs.forEach(btn => btn.addEventListener('click', () => showTab(btn.dataset.tab)));

            function scrollCommentsBottom() {
                const container = document.getElementById('commentsContainer');
                if (container) container.scrollTop = container.scrollHeight;
            }

            showTab(activeTab);

            const workflowId = {{ $workflow->id }};
            const authId = {{ auth()->id() }};
            const commentsContainer = document.getElementById('commentsContainer');

            if (commentsContainer) {
                commentsContainer.scrollTop = commentsContainer.scrollHeight;
            }

            window.Echo.channel(`workflow.${workflowId}`)
                .listen('CommentCreated', (e) => {
                    const isOwn = e.user_id === authId;
                    const div = document.createElement('div');
                    div.className = `flex ${isOwn ? 'justify-end' : 'justify-start'} gap-3 max-w-full group`;
                    div.innerHTML = `
                        <div class="flex flex-col relative leading-snug ${isOwn ? 'items-end' : 'items-start'}">
                            <div class="flex flex-col px-4 py-3 shadow-sm max-w-xs sm:max-w-md lg:max-w-lg ${
                        isOwn
                            ? 'bg-blue-100 text-gray-900 rounded-2xl rounded-br-none'
                            : 'bg-gray-100 border border-gray-200 text-gray-900 rounded-2xl rounded-bl-none'
                    }">
                                <div class="flex items-center gap-2 mb-1 text-sm ${isOwn ? 'justify-end' : 'justify-start'}">
                                    <span class="font-semibold text-gray-900">${e.user}</span>
                                    <span class="text-xs text-gray-500">${e.created_at}</span>
                                </div>
                                <p class="text-sm leading-relaxed whitespace-pre-wrap break-words">${e.text}</p>
                            </div>
                        </div>`;
                    commentsContainer.appendChild(div);
                    commentsContainer.scrollTop = commentsContainer.scrollHeight;
                });
        });
    </script>
</x-layouts.app>
