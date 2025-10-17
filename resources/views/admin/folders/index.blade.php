<x-layouts.app :title="__('Departments')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">

        <!-- Хлебные крошки / Назад -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                @if($currentFolder)
                    <a href="{{ route('admin.folders.index', ['parent_id' => $currentFolder->parent_id]) }}" class="text-blue-600 hover:underline">
                        ← Назад
                    </a>
                    <span>/ {{ $currentFolder->name }}</span>
                @else
                    <span>Корневые папки</span>
                @endif
            </div>

            <!-- Переключение режима -->
            <div class="flex gap-2 items-center">
                <!-- Переключение режима -->
                    <flux:button id="listViewBtn" icon="bars-3" variant="ghost" title="Список" />
                    <flux:button id="gridViewBtn" icon="squares-2x2" variant="ghost" title="Сетка" />

                    <flux:modal.trigger name="create-folder">
                        <flux:button icon="plus" variant="primary">Создать папку</flux:button>
                    </flux:modal.trigger>
            </div>
        </div>
    <x-modal-create-folder/>
    <x-modal-share-folder/>

        <!-- Контейнер папок -->
        <div id="foldersContainer" class="transition-all">
            <!-- Список (по умолчанию) -->
            <div id="listView" class="">
                <table class="min-w-full rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                    <thead class="bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Название</th>
                        <th class="px-6 py-3 text-left">Дата создания</th>
                        <th class="px-6 py-3 text-left">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($folders as $folder)
                        <tr class="border-b dark:border-zinc-700">
                            <td class="px-6 py-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10 4H2v16h20V6H12l-2-2z"/>
                                </svg>
                                <a href="{{ route('admin.folders.index', ['parent_id' => $folder->id]) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $folder->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $folder->created_at->format('d.m.Y') }}</td>
                            <td class="px-6 py-4">
                                <x-folder-actions :folder="$folder" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Сетка -->
            <div id="gridView" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach($folders as $folder)
                    <div class="group bg-zinc-50 dark:bg-zinc-900 rounded-xl p-6 flex flex-col items-center justify-between border border-zinc-200 dark:border-zinc-700 hover:shadow-lg transition">
                        <a href="{{ route('admin.folders.index', ['parent_id' => $folder->id]) }}" class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-400 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 4H2v16h20V6H12l-2-2z"/>
                            </svg>
                            <span class="text-sm text-gray-900 dark:text-gray-100 truncate max-w-full text-center">{{ $folder->name }}</span>
                        </a>
                        <div class="flex items-center justify-between w-full mt-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $folder->created_at->format('d.m.Y') }}</span>
                            <x-folder-actions :folder="$folder" />

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script>
        const listBtn = document.getElementById('listViewBtn');
        const gridBtn = document.getElementById('gridViewBtn');
        const listView = document.getElementById('listView');
        const gridView = document.getElementById('gridView');

        listBtn.addEventListener('click', () => {
            listView.classList.remove('hidden');
            gridView.classList.add('hidden');
        });

        gridBtn.addEventListener('click', () => {
            listView.classList.add('hidden');
            gridView.classList.remove('hidden');
        });
    </script>
</x-layouts.app>
