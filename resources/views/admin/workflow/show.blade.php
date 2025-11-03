<x-layouts.app :title="__('Workflow')">

    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Документ на утверждение</h1>
        </div>

        <section class="p-4 bg-white rounded-xl border border-gray-200">
            @if($initiator)
                <div class="flex flex-col gap-1">
                    <div class="font-medium text-gray-800">{{ $initiator->name }}</div>
                    <div class="text-gray-500">{{ $initiator->email }}</div>
                    <div class="text-gray-600">просит Вас одобрить документ</div>
                </div>
            @else
                <div class="text-gray-500">Инициатор не указан</div>
            @endif
        </section>

        <section class="p-4 bg-white rounded-xl border border-gray-200">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Пользователи в процессе утверждения</h2>

            <div class="">
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
                                    <span class="flex items-center justify-center w-10 h-10">
                                        <x-icon.user-icon class="w-5 h-5"/>
                                    </span>

                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                        <span class="text-gray-500 text-sm truncate">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">{{ $workflowUser->role->label() }}</td>
                            <td class="px-6 py-4">{{ $status->label() }}</td>
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
        </section>

        {{-- Документы --}}
        <section class="p-4 bg-white rounded-xl border border-gray-200">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Документы</h2>

            <div class="">
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

        <section class="p-4 bg-white rounded-xl border border-gray-200">
            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Комментарий</label>
            <textarea id="comment" name="comment" rows="3"
                      placeholder="Введите комментарий к документу..."
                      class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
        </section>

        <footer class="flex flex-col gap-3">
            @if($currentUserWorkflow && $currentUserWorkflow->isPending())
                <form method="POST" action="{{ route('admin.workflows.approve', $workflow->id) }}">
                    @csrf
                    <button type="submit"
                            class="w-full py-2 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Утвердить
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.workflows.reject', $workflow->id) }}">
                    @csrf
                    <button type="submit"
                            class="w-full py-2 px-4 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Отклонить
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.workflows.redirect', $workflow->id) }}" class="flex gap-2">
                    @csrf
                    <select name="redirect_to"
                            class="flex-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @foreach($users as $workflowUser)
                            @if($workflowUser->user_id !== auth()->id())
                                <option value="{{ $workflowUser->user_id }}">{{ $workflowUser->user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit"
                            class="py-2 px-4 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">Перенаправить
                    </button>
                </form>
            @else
                <p class="text-gray-500">Вы уже выполнили действие в этом процессе.</p>
            @endif
        </footer>
    </div>

</x-layouts.app>
