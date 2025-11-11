<x-layouts.app :title="__('Рабочий процесс')">
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item :href="route('dashboard')">Главная</flux:breadcrumbs.item>
        <flux:breadcrumbs.item active>{{ $workflow->title }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="space-y-6">
        @php
            $status = \App\Enums\WorkflowStatus::from($workflow->workflow_status);
        @endphp

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
            @if($initiator)
                <div class="flex flex-col gap-2">
                    <div class="font-medium text-gray-800">{{ $initiator->name }}</div>
                    <div class="text-gray-500">{{ $initiator->email }}</div>
                    <div class="text-gray-600">просит Вас одобрить документ</div>
                </div>
            @else
                <div class="text-gray-500">Инициатор не указан</div>
            @endif
        </section>

        <div class="flex flex-col md:flex-row gap-6">
            <section class="flex flex-col w-full md:w-1/2 gap-6">
                <div class="flex-1 p-6 bg-white rounded-xl border border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Пользователи в процессе утверждения</h2>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">Пользователь</th>
                            <th class="px-6 py-3 text-left">Роль</th>
                            <th class="px-6 py-3 text-left">Статус</th>
                            <th class="px-6 py-3 text-left">Действие</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $workflowUser)
                            @php
                                $user = $workflowUser->user;
                                $status = $workflowUser->status;
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <x-user-avatar :user="$user" size="10" />
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                            <span class="text-gray-500 text-sm truncate">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $workflowUser->role->label() }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $status = $workflowUser->status;
                                        $colors = [
                                            'pending' => 'amber',
                                            'approved' => 'green',
                                            'rejected' => 'red',
                                            'redirected' => 'cyan',
                                        ];
                                        $color = $colors[$status->slug()] ?? 'zinc';
                                    @endphp
                                    <flux:badge color="{{ $color }}">
                                        {{ $status->label() }}
                                    </flux:badge>
                                </td>

                                <td class="px-6 py-4">
                                    @if($workflowUser->acted_at)
                                        <span class="text-gray-600">{{ $workflowUser->acted_at->format('d.m.Y H:i') }}</span>
                                    @else
                                        <span class="text-gray-500">Ожидает действия</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex-1 p-6 bg-white rounded-xl border border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Файлы</h2>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">Название файла</th>
                            <th class="px-6 py-3 text-left">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($documents as $document)
                            @forelse($document->files as $file)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">{{ $file->original_name ?? 'Файл ' . $loop->iteration }}</td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                                           class="px-3 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">Открыть</a>
                                        <a href="{{ Storage::url($file->file_path) }}" download
                                           class="px-3 py-1 bg-green-50 text-green-600 rounded hover:bg-green-100 transition">Скачать</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-gray-500 text-center">Файлы отсутствуют</td>
                                </tr>
                            @endforelse
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="flex flex-col w-full md:w-1/2 bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex-1 overflow-y-auto flex flex-col gap-6" id="commentsContainer">
                    @foreach($workflow->comments()->oldest()->get() as $comment)
                        @php
                            $isOwn = $comment->user_id === auth()->id();
                            $colors = ['red','orange','amber','yellow','lime','green','emerald','teal','cyan','sky','blue','indigo','violet','purple','fuchsia','pink','rose'];
                            $colorIndex = crc32($comment->user->name) % count($colors);
                            $color = $colors[$colorIndex];
                        @endphp

                        <div class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }} gap-3 max-w-2xl group">
                            @if(!$isOwn)
                                <flux:avatar
                                        name="{{ $comment->user->name }}"
                                        color="{{ $color }}"
                                        size="9"
                                        class="self-end"
                                />
                            @endif

                            <div class="flex flex-col relative leading-snug {{ $isOwn ? 'items-end' : 'items-start' }}">
                                <div class="flex flex-col px-4 py-3 shadow-sm
                        {{ $isOwn
                            ? 'bg-blue-100 text-gray-900 rounded-2xl rounded-br-none'
                            : 'bg-gray-100 border border-gray-200 text-gray-900 rounded-2xl rounded-bl-none'
                        }}">
                                    <div class="flex items-center gap-2 mb-1 text-sm {{ $isOwn ? 'justify-end' : 'justify-start' }}">
                                        <span class="font-semibold text-gray-900">
                                            {{ $comment->user->name }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $comment->created_at->format('H:i d.m.Y') }}
                                        </span>
                                    </div>

                                    <p class="text-sm leading-relaxed">{{ $comment->comment }}</p>
                                </div>

                                <div class="flex items-center space-x-1.5 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="text-lg hover:scale-110 transition">👍</button>
                                    <button class="text-lg hover:scale-110 transition">❤️</button>
                                    <button class="text-lg hover:scale-110 transition">😂</button>
                                </div>
                            </div>

                            @if($isOwn)
                                <flux:avatar
                                        name="{{ $comment->user->name }}"
                                        color="{{ $color }}"
                                        size="9"
                                        class="self-end"
                                />
                            @endif
                        </div>
                    @endforeach


                    <form method="POST" action="{{ route('admin.workflows.comment.store', $workflow->id) }}" class="mt-6 flex items-center gap-3 border-t border-gray-200 pt-4">
                    @csrf
                    <textarea id="comment" name="comment" rows="1"
                              class="flex-1 p-2 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none"
                              placeholder="Введите комментарий..."></textarea>
                    <button type="submit" class="p-2 text-blue-600 rounded-full hover:bg-blue-100">
                        <svg class="w-5 h-5 rotate-90" fill="currentColor" viewBox="0 0 18 20">
                            <path d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z"/>
                        </svg>
                    </button>
                </form>
                </div>
            </section>
        </div>


        <script>
            const container = document.getElementById('commentsContainer');
            container.scrollTop = container.scrollHeight;
        </script>

        <footer class="p-6 border-t bg-gray-50 rounded-b-xl flex flex-col items-center gap-5">
            @if($currentUserWorkflow && $currentUserWorkflow->isPending())
                @php
                    $role = $currentUserWorkflow->role;
                @endphp
                @if($role->can('approve'))
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
                @endif

                @if($role->can('approve'))
                <form method="POST" action="{{ route('admin.workflows.redirect', $workflow->id) }}"
                          class="flex flex-col sm:flex-row gap-3 w-full max-w-md justify-center">
                        @csrf
                        <select name="redirect_to"
                                class="flex-1 py-2.5 border-gray-300 rounded-xl bg-white shadow-sm
                               focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                            @foreach($users as $workflowUser)
                                @if($workflowUser->user_id !== auth()->id())
                                    <option value="{{ $workflowUser->user_id }}">{{ $workflowUser->user->name }}</option>
                                @endif
                            @endforeach
                        </select>

                        <button type="submit"
                                class="py-2.5 px-5 bg-yellow-500 text-white font-medium rounded-xl
                               shadow-sm hover:bg-yellow-600 active:scale-[0.98] transition-all">
                            Перенаправить
                        </button>
                    </form>
                @endif
            @else
                <p class="text-gray-500 text-center text-sm">Вы уже выполнили действие в этом процессе.</p>
            @endif
        </footer>

    </div>
</x-layouts.app>
