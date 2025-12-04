@props(['document'])

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
                    icon="clipboard-document"
                    href="#"
                    onclick="copyDocument({{ $document->id }})"
            >
                Копировать
            </flux:menu.item>

            <flux:menu.item
                    icon="folder-arrow-down"
                    href="#"
                    onclick="moveDocument({{ $document->id }})"
            >
                Переместить
            </flux:menu.item>

            <flux:menu.item
                    icon="pencil-square"
                    href="#"
                    onclick="renameDocument({{ $document->id }})"
            >
                Переименовать
            </flux:menu.item>

            <flux:menu.item
                    icon="archive-box"
                    href="#"
                    onclick="archiveDocument({{ $document->id }})"
            >
                В архив
            </flux:menu.item>

            <flux:menu.item
                    icon="arrow-path"
                    href="#"
                    onclick="restoreDocument({{ $document->id }})"
            >
                Восстановить
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
                    onclick="trashDocument({{ $document->id }})"
            >
                Удалить
            </flux:menu.item>
        @endif
    </flux:menu>
</flux:dropdown>
