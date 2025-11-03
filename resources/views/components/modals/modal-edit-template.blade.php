<flux:modal name="template-edit-modal" variant="flyout" class="max-w-2xl">
    <form :action="editTemplateUrl" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="border-b border-gray-200 pb-4">
            <flux:heading size="lg" class="text-gray-900 font-semibold">Редактировать шаблон</flux:heading>
            <p class="text-sm text-gray-500 mt-1">Внесите изменения и сохраните обновлённый шаблон документа.</p>
        </div>

        <div>
            <flux:input
                    name="name"
                    label="Название"
                    placeholder="Введите название шаблона"
                    x-model="editTemplate.name"
                    required
                    class="w-full"
            />
        </div>

        {{-- Содержимое шаблона --}}
        <div>
            <label for="edit-content" class="block text-sm font-medium text-gray-700 mb-2">Содержимое шаблона</label>
            <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm focus-within:ring-2 focus-within:ring-blue-500">
                <x-trix-input
                        id="edit-content"
                        name="content"
                        x-bind:value="editTemplate.content"
                        autocomplete="off"
                        class="w-full bg-white text-gray-800"
                />
            </div>
        </div>

        <div>
            <span class="block text-sm font-medium text-gray-700 mb-2">Статус</span>
            <div class="grid grid-cols-2 gap-3">
                @foreach (\App\Enums\ActiveStatus::cases() as $status)
                    <label class="flex items-center space-x-2 rounded-xl border border-gray-200 p-3 bg-gray-50 hover:bg-gray-100 transition cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                        <input
                                type="radio"
                                name="status"
                                value="{{ $status->value }}"
                                class="h-5 w-5 text-blue-600 accent-blue-500 focus:ring-blue-500 cursor-pointer"
                                x-model="editTemplate.status"
                                @checked(old('status') == $status->value)
                        >
                        <span class="text-gray-700">{{ $status->label() }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200">
            <flux:button type="button" modal:close variant="ghost" class="rounded-xl border border-gray-200 hover:bg-gray-50 transition">
                Отмена
            </flux:button>
            <flux:button
                    type="submit"
                    variant="primary"
                    class="rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-sm transition"
            >
                Сохранить изменения
            </flux:button>
        </div>
    </form>
</flux:modal>
