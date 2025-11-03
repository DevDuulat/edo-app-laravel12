<x-layouts.app :title="__('Редактировать шаблон')">
    <form action="{{ route('admin.document-templates.update', $documentTemplate->id) }}" method="POST" class="max-w-3xl mx-auto p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="border-b border-gray-200 pb-4">
            <flux:heading size="lg" class="text-gray-900 font-semibold">Редактировать шаблон</flux:heading>
            <p class="text-sm text-gray-500 mt-1">
                Внесите изменения и сохраните обновлённый шаблон документа.
            </p>
        </div>

        <div>
            <flux:input
                    name="name"
                    label="Название"
                    placeholder="Введите название шаблона"
                    value="{{ old('name', $documentTemplate->name) }}"
                    required
                    class="w-full"
            />
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Содержимое шаблона</label>
            <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm focus-within:ring-2 focus-within:ring-blue-500">
                <x-trix-input
                        id="content"
                        name="content"
                        :value="old('content', $documentTemplate->content?->toHtml())"
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
                                @checked(old('status', $documentTemplate->active ? 0 : 1) == $status->value)
                        >
                        <span class="text-gray-700">{{ $status->label() }}</span>
                    </label>
                @endforeach

            </div>
        </div>

        <div class="flex justify-between pt-5 border-t border-gray-200">
            <flux:button
                    href="{{ route('admin.document-templates.index') }}"
                    variant="ghost"
                    class="rounded-xl border border-gray-200 hover:bg-gray-50 transition"
            >
                Назад
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
</x-layouts.app>
