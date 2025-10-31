<x-layouts.app :title="__('Workflow')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-6 bg-gradient-to-b dark:from-gray-900 dark:to-gray-950">

        {{-- === Документ === --}}
        <div class="flex flex-col bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 overflow-hidden">

            <header class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Документ на утверждение</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Просмотр и утверждение рабочих документов
                </p>
            </header>

            {{-- Инициатор --}}
            <section class="mb-6">
                @if($initiator)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-700 shadow-inner">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                                {{ $initiator->name }}
                            </h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $initiator->email }}
                            </p>
                        </div>

                        <div class="mt-2 sm:mt-0 text-xs text-gray-600 dark:text-gray-300">
                            просит Вас одобрить документ
                        </div>
                    </div>
                @else
                    <div class="text-xs text-gray-600 dark:text-gray-300">
                        Инициатор не указан
                    </div>
                @endif
            </section>

            {{-- Таблица пользователей --}}
            <section class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                    Пользователи в процессе утверждения
                </h2>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Пользователь</th>
                            <th scope="col" class="px-6 py-3">Роль</th>
                            <th scope="col" class="px-6 py-3">Статус</th>
                            <th scope="col" class="px-6 py-3">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $workflowUser)
                            @php
                                $user = $workflowUser->user;
                                $status = $workflowUser->status;
                            @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 dark:text-white">
                                    <img class="w-10 h-10 rounded-full"
                                         src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
                                         alt="{{ $user->name }}">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">{{ $user->name }}</div>
                                        <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full
                                    bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $workflowUser->role->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($workflowUser->isApproved())
                                        <span class="flex items-center text-green-600 dark:text-green-400">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                            {{ $status->label() }}
                                        </span>
                                    @elseif($workflowUser->isRejected())
                                        <span class="flex items-center text-red-600 dark:text-red-400">
                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                                            {{ $status->label() }}
                                        </span>
                                    @elseif($workflowUser->isPending())
                                        <span class="flex items-center text-yellow-600 dark:text-yellow-400">
                                            <div class="h-2.5 w-2.5 rounded-full bg-yellow-400 me-2"></div>
                                            {{ $status->label() }}
                                        </span>
                                    @else
                                        <span class="flex items-center text-gray-500 dark:text-gray-400">
                                            <div class="h-2.5 w-2.5 rounded-full bg-gray-400 me-2"></div>
                                            {{ $status->label() }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($workflowUser->acted_at)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $workflowUser->acted_at->format('d.m.Y H:i') }}
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">Ожидает действия</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <flux:separator />

            {{-- Документы --}}
            <section class="mt-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                    Документы
                </h2>

                @foreach($documents as $document)
                    <div class="mb-2">
                        <ul class="space-y-2">
                            @forelse($document->files as $file)
                                <li class="flex items-center justify-between p-2 bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center gap-2">
                                        <x-icon.document-icon class="w-4 h-4 text-blue-500" />
                                        <span class="text-xs text-gray-700 dark:text-gray-300">Файл {{ $loop->iteration }}</span>
                                    </div>

                                    <div class="flex items-center gap-1">
                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                                           class="px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md transition">
                                            Открыть
                                        </a>
                                        <a href="{{ Storage::url($file->file_path) }}" download
                                           class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md transition">
                                            Скачать
                                        </a>
                                    </div>
                                </li>
                            @empty
                                <li class="text-xs text-gray-400 dark:text-gray-500">Файлы отсутствуют</li>
                            @endforelse
                        </ul>
                    </div>
                @endforeach
            </section>

            <flux:separator />

            {{-- Комментарий --}}
            <section class="mt-6 mb-6">
                <label for="comment" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Комментарий
                </label>
                <textarea id="comment" name="comment" rows="3"
                          class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                          placeholder="Введите комментарий к документу..."></textarea>
            </section>

            {{-- Действия --}}
            <footer class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                @if($currentUserWorkflow && $currentUserWorkflow->isPending())
                    <form method="POST" action="{{ route('admin.workflows.approve', $workflow->id) }}">
                        @csrf
                        <flux:button type="submit" variant="primary" color="emerald" class="w-full sm:w-auto">Утвердить</flux:button>
                    </form>

                    <form method="POST" action="{{ route('admin.workflows.reject', $workflow->id) }}">
                        @csrf
                        <flux:button type="submit" variant="primary" color="red" class="w-full sm:w-auto">Отклонить</flux:button>
                    </form>

                    <form method="POST" action="{{ route('admin.workflows.redirect', $workflow->id) }}">
                        @csrf
                        <select name="redirect_to" class="rounded-lg text-sm border-gray-300 dark:bg-gray-800 dark:text-gray-100">
                            @foreach($users as $workflowUser)
                                @if($workflowUser->user_id !== auth()->id())
                                    <option value="{{ $workflowUser->user_id }}">{{ $workflowUser->user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <flux:button type="submit" variant="primary" color="zinc" class="w-full sm:w-auto">Перенаправить</flux:button>
                    </form>
                @else
                    <p class="text-sm text-gray-400 dark:text-gray-500">
                        Вы уже выполнили действие в этом процессе.
                    </p>
                @endif
            </footer>

        </div>
    </div>
</x-layouts.app>
