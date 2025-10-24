<x-layouts.app :title="__('Departments')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
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

            <div class="flex gap-2 items-center">
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
            <!-- Список -->
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
                        <tr class="border-b dark:border-zinc-700" data-folder-id="{{ $folder->id }}">
                            <td class="px-6 py-4 flex items-center gap-2">
                                <x-icon.folder-icon/>
                                <a href="{{ route('admin.folders.index', ['parent_id' => $folder->id]) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $folder->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $folder->created_at->format('d.m.Y') }}</td>
                            <td class="px-6 py-4">
                                <x-actions.folder-dropdown :folder="$folder" />
                            </td>
                        </tr>
                        <x-actions.folder-context-menu :folder="$folder"/>
                    @endforeach

                    @foreach($documents as $document)
                        <tr class="border-b dark:border-zinc-700" data-document-id="{{ $document->id }}">
                            <td class="px-6 py-4 flex items-center gap-2">
                                <x-icon.document-icon />
                                <a href="{{ route('admin.documents.show', $document->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $document->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $document->created_at->format('d.m.Y') }}</td>
                            <td class="px-6 py-4">
{{--                                <button class="text-blue-600 hover:underline">Открыть</button>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Сетка -->
            <div id="gridView" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach($folders as $folder)
                    <div class="group folder-card bg-zinc-50 dark:bg-zinc-900 rounded-xl p-4 flex flex-col items-center justify-between border border-zinc-200 dark:border-zinc-700 hover:shadow-lg transition" data-folder-id="{{ $folder->id }}">
                        <a href="{{ route('admin.folders.index', ['parent_id' => $folder->id]) }}" class="flex flex-col items-center folder-link">
                            <x-icon.folder-icon/>
                            <span class="text-sm text-gray-900 dark:text-gray-100 truncate max-w-full text-center">{{ $folder->name }}</span>
                        </a>
                        <div class="flex items-center justify-between w-full mt-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $folder->created_at->format('d.m.Y') }}</span>
                            <x-actions.folder-dropdown :folder="$folder" />
                        </div>
                    </div>
                    <x-actions.folder-context-menu :folder="$folder"/>
                @endforeach

                <!-- Вывод документов -->
                @foreach($documents as $document)
                    <div class="document-card bg-zinc-50 dark:bg-zinc-900 rounded-xl p-4 flex flex-col items-center justify-between border border-zinc-200 dark:border-zinc-700 hover:shadow-lg transition" data-document-id="{{ $document->id }}">
                        <span class="text-sm text-gray-900 dark:text-gray-100 truncate max-w-full text-center">{{ $document->title }}</span>
                        <div class="flex items-center justify-between w-full mt-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $document->created_at->format('d.m.Y') }}</span>
                            <button class="text-blue-600 hover:underline text-xs">Открыть</button>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
<x-modal-create-folder/>
</x-layouts.app>
