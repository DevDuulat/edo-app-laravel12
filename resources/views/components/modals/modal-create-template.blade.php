<flux:modal name="template-modal" variant="flyout" class="max-w-2xl">
    <form action="{{ route('admin.document-templates.store') }}" method="POST" class="space-y-6 p-6">
        @csrf

        <div class="border-b pb-3">
            <flux:heading size="lg" class="text-gray-900">Создать шаблон</flux:heading>
            <p class="text-sm text-gray-500 mt-1">Заполните форму, чтобы добавить новый шаблон документа.</p>
        </div>

        <div>
            <flux:input
                    name="name"
                    label="Название"
                    placeholder="Введите название шаблона"
                    required
                    class="w-full"
            />
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Содержимое шаблона</label>
            <x-trix-input
                    id="content"
                    name="content"
                    :value="old('content')"
                    autocomplete="off"
                    class="w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            />
        </div>

        <div>
            <span class="block text-sm font-medium text-gray-700 mb-2">Статус</span>
            <div class="grid grid-cols-2 gap-4">
                @foreach (\App\Enums\ActiveStatus::cases() as $status)
                    <label class="flex items-center space-x-2">
                        <input
                                type="checkbox"
                                name="status[]"
                                value="{{ $status->value }}"
                                class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                                @if(is_array(old('status')) && in_array($status->value, old('status'))) checked @endif
                        >
                        <span class="text-gray-700">{{ $status->label() }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Кнопки -->
        <div class="flex justify-end space-x-3 pt-4 border-t">
            <flux:button type="button" modal:close variant="ghost">Отмена</flux:button>
            <flux:button type="submit" variant="primary">Сохранить</flux:button>
        </div>
    </form>
</flux:modal>
