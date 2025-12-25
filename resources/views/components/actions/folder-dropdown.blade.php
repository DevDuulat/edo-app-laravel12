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
{{--        <flux:menu.item--}}
{{--                icon="share"--}}
{{--                href="#"--}}
{{--                onclick="openShareModal('{{ $folder->slug }}')"--}}
{{--        >--}}
{{--            Поделиться--}}
{{--        </flux:menu.item>--}}
{{--        <flux:menu.item--}}
{{--                icon="lock-closed"--}}
{{--                href="#"--}}
{{--                onclick="copyFolder({{ $folder->id }})"--}}
{{--        >--}}
{{--            Настройка прав--}}
{{--        </flux:menu.item>--}}
        <flux:menu.item
                icon="clipboard-document"
                href="#"
                onclick="copyFolder({{ $folder->id }})"
        >
            Копировать
        </flux:menu.item>
{{--        TODO изменить ui перемещение папок--}}
{{--        <flux:menu.item--}}
{{--                icon="folder-arrow-down"--}}
{{--                href="#"--}}
{{--                onclick="moveFolder({{ $folder->id }})"--}}
{{--        >--}}
{{--            Переместить--}}
{{--        </flux:menu.item>--}}
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