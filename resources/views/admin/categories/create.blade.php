<x-layouts.app :title="__('Создание Категории')">
    <style>
        .form-actions button,
        .form-actions a {
            min-width: 120px;
        }
        @media (max-width: 768px) {
            .form-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>

    <div class="content-wrapper py-6">
        {{-- Уведомление --}}
        @if(session('alert'))
            <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 5000)"
                    x-transition
                    class="mb-4 relative max-w-md mx-auto"
            >
                <x-alerts.alert
                        :type="session('alert.type')"
                        :message="session('alert.message')"
                />
                <button @click="show = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">×</button>
            </div>
        @endif

        {{-- Хлебные крошки --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 max-w-md mx-auto">
            {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}
        </div>

        {{-- Карточка формы --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-md mx-auto">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                <h2 class="text-lg font-semibold text-gray-900">Новая категория</h2>
                <p class="text-sm text-gray-600 mt-1">Заполните форму, чтобы добавить категорию</p>
            </div>

            <form
                    action="{{ route('admin.categories.store') }}"
                    method="POST"
                    class="p-4 space-y-4"
            >
                @csrf

                <flux:field>
                    <flux:label badge="Обязательно">Название категории</flux:label>
                    <p class="text-xs text-gray-400 mt-1">Например: "Входящие документы", "Договоры", "Отчёты"</p>

                    <flux:input
                            name="name"
                            id="name"
                            required
                            placeholder="Введите название категории"
                            value="{{ old('name') }}"
                            autofocus
                            aria-describedby="name-error"
                            class="@error('name') border-red-500 @enderror"
                    />
                    @error('name')
                    <p id="name-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </flux:field>

                {{-- Кнопки --}}
                <div class="flex justify-end space-x-2 pt-3 border-t border-gray-200 form-actions">
                    <flux:button
                            href="{{ route('admin.categories.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition"
                    >
                        Отмена
                    </flux:button>

                    <flux:button
                            variant="primary"
                            type="submit"
                            class="px-4 py-2 text-sm font-medium rounded-lg"
                    >
                        Сохранить категорию
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
