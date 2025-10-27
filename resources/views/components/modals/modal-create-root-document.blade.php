
<flux:modal name="create-document" class="md:w-96">
    <form action="{{ route('admin.documents.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <flux:heading size="lg">Создать документ</flux:heading>
        </div>

        <flux:input
                name="title"
                label="Название документа"
                placeholder="Введите название документа"
                required
        />

        <flux:input
                type="date"
                name="due_date"
                label="Срок выполнения"
                required
        />

        <flux:textarea
                name="comment"
                label="Описание"
                placeholder="Введите описание"
                rows="3"
        />

        <input type="hidden" name="folder_id" value="{{ $currentFolder->id ?? '' }}">

        <div class="flex justify-end space-x-2">
            <flux:button type="button" modal:close variant="ghost">Отмена</flux:button>
            <flux:button type="submit" variant="primary">Создать</flux:button>
        </div>
    </form>
</flux:modal>
