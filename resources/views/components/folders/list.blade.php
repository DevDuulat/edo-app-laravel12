@props(['folders', 'documents'])

<div x-data="foldersList()"  id="listView" class="border rounded-xl border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="p-4">
                <input
                        type="checkbox"
                        :checked="(selectedFolders.length + selectedDocuments.length) === {{ $folders->count() + $documents->count() }}"
                        @click="if ((selectedFolders.length + selectedDocuments.length) === {{ $folders->count() + $documents->count() }}) { selectedFolders = []; selectedDocuments = []; } else { selectedFolders = @js($folders->pluck('id')); selectedDocuments = @js($documents->pluck('id')); }"
                        class="w-4 h-4 accent-blue-500 rounded cursor-pointer"
                />
            </th>
            <th class="px-6 py-3 text-left">Название</th>
            <th class="px-6 py-3 text-left">Статус</th>
            <th class="px-6 py-3 text-left">Дата создания</th>
            <th class="px-6 py-3 text-left">Действия</th>
        </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-200">

        @foreach($folders as $folder)
            <tr
                    class="hover:bg-gray-50 transition cursor-grab"
                    data-folder-id="{{ $folder->id }}"
                    draggable="true"
                    @dragstart="dragStart($event, {{ $folder->id }})"
                    @dragover.prevent
                    @drop="dropFolder($event, {{ $folder->id }})"
            >
                <td class="w-4 p-4">
                    <label class="flex items-center justify-center w-6 h-6 border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition cursor-pointer">
                        <input
                                type="checkbox"
                                name="folder_ids[]"
                                value="{{ $folder->id }}"
                                x-model="selectedFolders"
                                class="accent-blue-500 w-4 h-4 rounded cursor-pointer"
                        />
                    </label>
                </td>

                <td class="px-6 py-4 flex items-center gap-3">
                    <span class="flex items-center justify-center w-8 h-8">
                        <x-icon.folder-icon />
                    </span>
                    <a href="{{ route('admin.documents.index', ['parent_id' => $folder->id]) }}"
                       class="font-medium text-gray-900 hover:text-gray-700 transition">
                        {{ $folder->name }}
                    </a>
                </td>

                <td class="px-6 py-4">
                    <flux:badge color="zinc">{{ $folder->status->label() }}</flux:badge>
                </td>

                <td class="px-6 py-4">
                    {{ $folder->created_at->format('d.m.Y') }}
                </td>

                <td class="px-6 py-4 text-left">
                    <flux:dropdown align="end">
                        <flux:button
                                icon="ellipsis-vertical"
                                class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition shadow-sm"
                        />
                        <flux:menu>
                            <flux:menu.item
                                    icon="eye"
                                    href="{{ route('admin.documents.index', ['parent_id' => $folder->id]) }}"
                            >
                                Открыть
                            </flux:menu.item>
                            <flux:menu.item
                                    icon="share"
                                    href="#"
                                    onclick="openShareModal('{{ $folder->slug }}')"
                            >
                                Поделиться
                            </flux:menu.item>
                            <flux:menu.item
                                    icon="lock-closed"
                                    href="#"
                                    onclick="copyFolder({{ $folder->id }})"
                            >
                                Настройка прав
                            </flux:menu.item>
                            <flux:menu.item
                                    icon="clipboard-document"
                                    href="#"
                                    onclick="copyFolder({{ $folder->id }})"
                            >
                                Копировать
                            </flux:menu.item>
                            <flux:menu.item
                                    icon="folder-arrow-down"
                                    href="#"
                                    onclick="moveFolder({{ $folder->id }})"
                            >
                                Переместить
                            </flux:menu.item>
                            <flux:menu.item
                                    icon="pencil-square"
                                    href="#"
                                    onclick="renameFolder({{ $folder->id }})"
                            >
                                Переименовать
                            </flux:menu.item>
                            <flux:menu.item
                                    icon="archive-box"
                                    onclick="archiveFolder({{ $folder->id }})"
                            >
                                В архив
                            </flux:menu.item>
                            <flux:menu.item
                                    icon="arrow-path"
                                    href="#"
                                    onclick="restoreFolder({{ $folder->id }})"
                            >
                                Восстановить
                            </flux:menu.item>
                            <flux:menu.item
                                    icon="trash"
                                    href="#"
                                    variant="danger"
                                    onclick="trashFolder({{ $folder->id }})"
                            >
                                Удалить
                            </flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </td>
            </tr>

            <x-actions.folder-context-menu :folder="$folder" />
        @endforeach

        @foreach($documents as $document)
            <tr class="hover:bg-gray-50 transition" data-document-id="{{ $document->id }}">
                <td class="w-4 p-4">
                    <label class="flex items-center justify-center w-6 h-6 border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition cursor-pointer">
                        <input
                                type="checkbox"
                                name="document_ids[]"
                                value="{{ $document->id }}"
                                x-model="selectedDocuments"
                                class="accent-blue-500 w-4 h-4 rounded cursor-pointer"
                        />
                    </label>
                </td>

                <td class="px-6 py-4 flex items-center gap-3">
                    <span class="flex items-center justify-center w-8 h-8">
                        @if($document->workflows->isNotEmpty())
                            <x-icon.workflow-document-icon />
                        @else
                            <x-icon.document-icon />
                        @endif
                    </span>
                    @if($document->workflows->isNotEmpty())
                        <a href="{{ route('admin.workflows.show', $document->workflows->first()->id) }}"
                           class="font-medium text-gray-900 hover:text-gray-700 transition">
                            {{ $document->title }}
                        </a>
                    @else
                        <a href="{{ route('admin.documents.show', $document->id) }}"
                           class="font-medium text-gray-900 hover:text-gray-700 transition">
                            {{ $document->title }}
                        </a>
                    @endif
                </td>

                <td class="px-6 py-4">
                    <flux:badge color="lime">Активен</flux:badge>
                </td>

                <td class="px-6 py-4">
                    {{ $document->created_at->format('d.m.Y') }}
                </td>

                <td class="px-6 py-4 text-left">
                    <flux:dropdown align="end">
                        <flux:button
                                icon="ellipsis-vertical"
                                class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition shadow-sm"
                        />
                        <flux:menu>
                            @if($document->workflows->isNotEmpty())
                                <flux:menu.item
                                        icon="eye"
                                        href="{{ route('admin.workflows.show', $document->workflows->first()->id) }}"
                                >
                                    Просмотр
                                </flux:menu.item>
                                <flux:menu.separator />
                                <flux:menu.item
                                        icon="trash"
                                        href="#"
                                        variant="danger"
                                >
                                    Удалить
                                </flux:menu.item>
                            @else
                                <flux:menu.item
                                        icon="eye"
                                        href="{{ route('admin.documents.show', $document->id) }}"
                                >
                                    Просмотр
                                </flux:menu.item>
                                <flux:menu.item
                                        icon="pencil"
                                        href="{{ route('admin.documents.edit', $document->id) }}"
                                >
                                    Редактировать
                                </flux:menu.item>
                                <flux:menu.separator />
                                <flux:menu.item
                                        icon="trash"
                                        href="#"
                                        variant="danger"
                                >
                                    Удалить
                                </flux:menu.item>
                            @endif
                        </flux:menu>
                    </flux:dropdown>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>