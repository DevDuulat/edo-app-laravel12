<!-- Модалки -->
<flux:modal name="create-folder" class="md:w-96">
    <form action="{{ route('admin.folders.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <flux:heading size="lg">Создать папку</flux:heading>
        </div>
        <flux:input name="name" label="Название" placeholder="Введите название папки" required />
        <flux:input type="number" name="retention_period" label="Срок хранения (в днях)" placeholder="Например, 365" />
        <input type="hidden" name="parent_id" id="parent_id" value="{{ $currentFolder->id ?? '' }}">
        <div class="flex justify-end space-x-2">
            <flux:button type="button" modal:close variant="ghost">Отмена</flux:button>
            <flux:button type="submit" variant="primary">Сохранить</flux:button>
        </div>
    </form>
</flux:modal>