<flux:modal name="share-folder" class="md:w-[28rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Поделиться папкой</flux:heading>
            <flux:text class="mt-2 text-gray-600 dark:text-gray-300">
                Укажите пользователей, с которыми хотите поделиться этой папкой, и настройте их права доступа.
            </flux:text>
        </div>
        <flux:input label="Пользователи" placeholder="Введите email или имя пользователя" icon="user-plus" />
        <flux:select label="Права доступа">
            <option value="read">Только просмотр</option>
            <option value="edit">Редактирование</option>
            <option value="owner">Полный доступ</option>
        </flux:select>
        <flux:textarea label="Сообщение (необязательно)" placeholder="Добавьте комментарий к приглашению..." />
        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Отправить приглашение</flux:button>
        </div>
    </div>
</flux:modal>