<flux:dropdown>
    <flux:button size="sm" variant="ghost" icon="cog-6-tooth" />
    <flux:menu>
        <flux:modal.trigger name="create-folder">
            <flux:menu.item icon="plus-circle" @click="
                document.getElementById('parent_id').value = '{{ $folder->id }}';
            ">
                Создать подпапку
            </flux:menu.item>
        </flux:modal.trigger>

        <flux:menu.item icon="pencil-square">Переименовать</flux:menu.item>
        <flux:menu.separator />
        <flux:menu.item icon="lock-closed">Настроить доступ</flux:menu.item>
        <flux:menu.item icon="archive-box">Архивировать</flux:menu.item>
        <flux:menu.item icon="arrow-path">Восстановить</flux:menu.item>
        <flux:menu.separator />
        <flux:menu.item icon="trash" variant="danger">Удалить</flux:menu.item>
    </flux:menu>
</flux:dropdown>
