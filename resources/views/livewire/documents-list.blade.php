<div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="p-4">
                <input type="checkbox" wire:click="toggleSelectAll"
                       {{ (count($selectedFolders) + count($selectedDocuments)) === ($folders->count() + $documents->count()) ? 'checked' : '' }}
                       class="w-4 h-4 accent-blue-500 rounded cursor-pointer"/>
            </th>
            <th class="px-6 py-3 text-left">Название</th>
            <th class="px-6 py-3 text-left">Статус</th>
            <th class="px-6 py-3 text-left">Дата создания</th>
            <th class="px-6 py-3 text-left">Действия</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">

        @foreach($folders as $folder)
            <tr class="hover:bg-gray-50 transition">
                <td class="w-4 p-4">
                    <input type="checkbox" wire:model="selectedFolders" value="{{ $folder->id }}"
                           class="accent-blue-500 w-4 h-4 rounded cursor-pointer"/>
                </td>
                <td class="px-6 py-4 flex items-center gap-3">
                    <x-icon.folder-icon />
                    <a href="{{ route('admin.folders.index', ['parent_id' => $folder->id]) }}" class="font-medium text-gray-900 hover:text-gray-700 transition">
                        {{ $folder->name }}
                    </a>
                </td>
                <td class="px-6 py-4"><flux:badge color="zinc">В работе</flux:badge></td>
                <td class="px-6 py-4">{{ $folder->created_at->format('d.m.Y') }}</td>
                <td class="px-6 py-4 text-left">
                    <flux:dropdown align="end">
                        <flux:button icon="ellipsis-vertical" />
                        <flux:menu>
                            <flux:menu.item icon="eye" href="{{ route('admin.folders.index', ['parent_id' => $folder->id]) }}">Открыть</flux:menu.item>
                            <flux:menu.item icon="archive-box" href="#" wire:click.prevent="archiveFolder({{ $folder->id }})">Архивировать</flux:menu.item>
                            <flux:menu.item icon="trash" href="#" variant="danger" wire:click.prevent="deleteFolder({{ $folder->id }})">Удалить</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </td>
            </tr>
        @endforeach

        @foreach($documents as $document)
            <tr class="hover:bg-gray-50 transition">
                <td class="w-4 p-4">
                    <input type="checkbox" wire:model="selectedDocuments" value="{{ $document->id }}" class="accent-blue-500 w-4 h-4 rounded cursor-pointer"/>
                </td>
                <td class="px-6 py-4 flex items-center gap-3">
                    @if($document->workflows->isNotEmpty())
                        <x-icon.workflow-document-icon />
                        <a href="{{ route('admin.workflows.show', $document->workflows->first()->id) }}" class="font-medium text-gray-900 hover:text-gray-700 transition">{{ $document->title }}</a>
                    @else
                        <x-icon.document-icon />
                        <a href="{{ route('admin.documents.show', $document->id) }}" class="font-medium text-gray-900 hover:text-gray-700 transition">{{ $document->title }}</a>
                    @endif
                </td>
                <td class="px-6 py-4"><flux:badge color="lime">Активен</flux:badge></td>
                <td class="px-6 py-4">{{ $document->created_at->format('d.m.Y') }}</td>
                <td class="px-6 py-4 text-left">
                    <flux:dropdown align="end">
                        <flux:button icon="ellipsis-vertical" />
                        <flux:menu>
                            <flux:menu.item icon="eye" href="{{ $document->workflows->isNotEmpty() ? route('admin.workflows.show', $document->workflows->first()->id) : route('admin.documents.show', $document->id) }}">Просмотр</flux:menu.item>
                            @if($document->workflows->isEmpty())
                                <flux:menu.item icon="pencil" href="{{ route('admin.documents.edit', $document->id) }}">Редактировать</flux:menu.item>
                            @endif
                            <flux:menu.separator />
                            <flux:menu.item icon="trash" href="#" variant="danger">Удалить</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </td>
            </tr>
        @endforeach

        </tbody>

    </table>
</div>
