<x-layouts.app :title="__('Категории')">
    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}
    @if(session('alert'))
        <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
                class="fixed top-4 right-4 z-50"
        >
            <x-alerts.alert
                    :type="session('alert.type')"
                    :message="session('alert.message')"
                    icon="check-circle"
            />
        </div>
    @endif

    <div class="flex flex-col flex-1 w-full h-full gap-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Все категории</h1>

            <div x-data @click="$dispatch('open-modal', { name: 'create-category' })">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Новая категория
                </button>
            </div>
        </div>

        <div class="border rounded-xl border-gray-200 overflow-hidden bg-white dark:bg-gray-900 shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="w-4 p-4">
                        <input type="checkbox" class="accent-blue-500 w-4 h-4 rounded cursor-pointer" />
                    </th>
                    <th class="px-6 py-3 text-left">Название</th>
                    <th class="px-6 py-3 text-left">Дата создания</th>
                    <th class="px-6 py-3 text-left">Действия</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="w-4 p-4">
                            <input type="checkbox" value="{{ $category->id }}" class="accent-blue-500 w-4 h-4 rounded cursor-pointer" />
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                            {{ $category->created_at?->format('d.m.Y') ?? '—' }}
                        </td>
                        <td class="px-6 py-4 flex gap-2">

                            <div x-data @click="$dispatch('open-modal', { name: 'edit-category-{{ $category->id }}' })">
                                <button type="button" title="Редактировать"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 transition shadow-sm text-gray-500 hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#000000"><g fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3l8.385-8.415zM16 5l3 3"/></g></svg>
                                </button>
                            </div>

                                <div x-data @click="$dispatch('open-modal', { name: 'delete-category-{{ $category->id }}' })">
                                <button type="button" title="Удалить"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 transition shadow-sm text-gray-500 hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 15 15"><path fill="#ff0000" fill-rule="evenodd" d="M5.5 1a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4ZM3 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H11v8a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4h-.5a.5.5 0 0 1-.5-.5ZM5 4h5v8H5V4Z" clip-rule="evenodd"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <div x-data="{ show: false, name: 'edit-category-{{ $category->id }}' }"
                         x-show="show"
                         x-on:open-modal.window="show = ($event.detail.name === name)"
                         x-on:close-modal.window="show = false"
                         x-on:keydown.escape.window="show = false"
                         class="fixed inset-0 z-50 overflow-y-auto"
                         style="display: none;"
                    >
                        <div x-show="show" class="fixed inset-0 bg-gray-900/50 dark:bg-gray-900/80 transition-opacity"
                             x-on:click="show = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

                        <div x-show="show" class="fixed inset-0 flex items-center justify-center p-4 md:p-8"
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                            <div class="md:w-96 w-full max-w-lg mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden" role="dialog" aria-modal="true">
                                <div class="space-y-4 p-6">
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Редактирование категории</h3>
                                        <button x-on:click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Измените данные категории и сохраните изменения</p>

                                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
                                        @csrf
                                        @method('PUT')

                                        <div class="space-y-1">
                                            <label for="edit_name_{{ $category->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Название категории <span class="ml-1 text-xs px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full font-semibold">Обязательно</span>
                                            </label>
                                            <input type="text" name="name" id="edit_name_{{ $category->id }}" required value="{{ old('name', $category->name) }}"
                                                   class="block w-full px-3 py-2 border @error('name') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 dark:text-gray-100"
                                            />
                                            @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="flex justify-end gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                                Сохранить изменения
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ show: false, name: 'delete-category-{{ $category->id }}' }"
                         x-show="show"
                         x-on:open-modal.window="show = ($event.detail.name === name)"
                         x-on:close-modal.window="show = false"
                         x-on:keydown.escape.window="show = false"
                         class="fixed inset-0 z-50 overflow-y-auto"
                         style="display: none;"
                    >
                        <div x-show="show" class="fixed inset-0 bg-gray-900/50 dark:bg-gray-900/80 transition-opacity"
                             x-on:click="show = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

                        <div x-show="show" class="fixed inset-0 flex items-center justify-center p-4 md:p-8"
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                            <div class="md:w-80 w-full max-w-sm mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden" role="dialog" aria-modal="true">
                                <div class="space-y-4 text-center p-6">
                                    <h3 class="text-xl font-semibold text-red-600">Удаление категории</h3>
                                    <p class="text-gray-600 dark:text-gray-400">Вы уверены, что хотите удалить категорию "<strong>{{ $category->name }}</strong>"? Это действие нельзя будет отменить.</p>
                                    <div class="flex justify-center gap-3 mt-4">
                                        <button x-on:click="show = false" type="button" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                                            Отмена
                                        </button>
                                        <button type="button"
                                                class="inline-flex justify-center py-2 px-4 border border-red-600 shadow-sm text-sm font-medium rounded-md text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition dark:bg-gray-900 dark:hover:bg-red-900 dark:border-red-700 dark:text-red-400"
                                                @click="
                                            fetch('{{ route('admin.categories.destroy', $category) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify({ _method: 'DELETE' })
                                            }).then(() => {
                                                $dispatch('close-modal', { name: 'delete-category-{{ $category->id }}' });
                                                location.reload();
                                            });
                                            "
                                        >Удалить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Нет категорий</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end">
            {{ $categories->links() }}
        </div>
    </div>

    <div x-data="{ show: false, name: 'create-category' }"
         x-show="show"
         x-on:open-modal.window="show = ($event.detail.name === name)"
         x-on:close-modal.window="show = false"
         x-on:keydown.escape.window="show = false"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
    >
        <div x-show="show" class="fixed inset-0 bg-gray-900/50 dark:bg-gray-900/80 transition-opacity"
             x-on:click="show = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div x-show="show" class="fixed inset-0 flex items-center justify-center p-4 md:p-8"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
            <div class="md:w-96 w-full max-w-lg mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden" role="dialog" aria-modal="true">
                <div class="space-y-4 p-6">
                    <div class="flex justify-between items-start">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Новая категория</h3>
                        <button x-on:click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Заполните форму для добавления категории</p>

                    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label for="create_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Название категории <span class="ml-1 text-xs px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full font-semibold">Обязательно</span>
                            </label>
                            <input type="text" name="name" id="create_name" placeholder="Введите название категории" required
                                   value="{{ old('name') }}"
                                   class="block w-full px-3 py-2 border @error('name') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 dark:text-gray-100"
                            />
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>