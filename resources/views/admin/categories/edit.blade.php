<x-layouts.app :title="__('Редактирование Категории')">
    <style>
        .form-actions button,
        .form-actions a {
            min-width: 120px;
        }
    </style>

    <div class="content-wrapper">
        @if(session('alert'))
            <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 5000)"
                    class="mb-6"
            >
                <x-alerts.alert
                        :type="session('alert.type')"
                        :message="session('alert.message')"
                />
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <flux:breadcrumbs class="mt-4 md:mt-0">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" />
                <flux:breadcrumbs.item href="{{ route('admin.categories.index') }}">Категории</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Редактирование категории</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-900">Редактирование категории</h2>
                <p class="text-sm text-gray-600 mt-1">Измените данные категории и сохраните изменения</p>
            </div>

            <form
                    action="{{ route('admin.categories.update', $category) }}"
                    method="POST"
                    class="p-6 space-y-6"
            >
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Название категории
                    </label>
                    <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $category->name) }}"
                            required
                            placeholder="Введите название категории"
                            class="w-full max-w-md px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-gray-900 placeholder-gray-400"
                    />
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200 form-actions">
                    <a href="{{ route('admin.categories.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Отмена
                    </a>

                    <flux:button
                            type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
                    >
                        Сохранить изменения
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
