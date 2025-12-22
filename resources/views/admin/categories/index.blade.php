<x-layouts.app :title="__('Категории')">
    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}


    <div class="flex flex-col flex-1 w-full h-full gap-6 p-4">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Все категории</h1>

            <flux:modal.trigger name="create-category">
                <flux:button
                        icon="plus"
                        type="button"
                        class="inline-flex items-center px-4 py-2 border text-sm font-medium rounded-lg shadow-md text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition"
                >
                    Новая категория
                </flux:button>
            </flux:modal.trigger>
        </div>

        <div class="border rounded-xl border-gray-300 overflow-hidden bg-white shadow-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="w-4 p-4">
                        <input type="checkbox" class="accent-black w-4 h-4 rounded cursor-pointer border-gray-300 focus:ring-black" />
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Название</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Дата создания</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Действия</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="w-4 p-4">
                            <input type="checkbox" value="{{ $category->id }}" class="accent-black w-4 h-4 rounded cursor-pointer border-gray-300 focus:ring-black" />
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $category->created_at?->format('d.m.Y') ?? '—' }}
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <flux:modal.trigger name="edit-category-{{ $category->id }}">
                                <flux:button
                                        icon="pencil"
                                        title="Редактировать"
                                        icon-only
                                        type="button"
                                />
                            </flux:modal.trigger>

                            <flux:modal.trigger name="delete-category-{{ $category->id }}">
                                <flux:button
                                        icon="trash"
                                        icon-only
                                        title="Удалить"
                                        type="button"
                                />
                            </flux:modal.trigger>
                        </td>
                    </tr>

                    <flux:modal name="edit-category-{{ $category->id }}" class="md:w-96">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Редактирование категории</h3>
                                <p class="mt-1 text-sm text-gray-600">Измените данные категории и сохраните изменения</p>
                            </div>

                            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div class="space-y-1">
                                    <label for="edit_name_{{ $category->id }}" class="block text-sm font-medium text-gray-900">
                                        Название категории <span class="ml-1 text-xs px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full font-semibold">Обязательно</span>
                                    </label>
                                    <input type="text" name="name" id="edit_name_{{ $category->id }}" required value="{{ old('name', $category->name) }}"
                                           class="block w-full px-3 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-black focus:border-black sm:text-sm bg-white text-gray-900"
                                    />
                                    @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end gap-2 pt-3 border-t border-gray-200">
                                    <flux:spacer />
                                    <flux:button type="button" x-on:click="$dispatch('close-modal', { name: 'edit-category-{{ $category->id }}' })"
                                                 class="px-4 py-2 border border-gray-400 shadow-sm text-sm font-medium rounded-lg text-gray-900 bg-white hover:bg-gray-100 transition">
                                        Отмена
                                    </flux:button>
                                    <flux:button type="submit"
                                                 class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">
                                        Сохранить изменения
                                    </flux:button>
                                </div>
                            </form>
                        </div>
                    </flux:modal>

                    <flux:modal name="delete-category-{{ $category->id }}" class="md:w-80">
                        <div class="space-y-4 text-center">
                            <h3 class="text-xl font-semibold text-red-700">Удаление категории</h3>
                            <p class="text-gray-700">Вы уверены, что хотите удалить категорию "<strong>{{ $category->name }}</strong>"? Это действие нельзя будет отменить.</p>
                            <div class="flex justify-center gap-3 mt-4 pt-4 border-t border-gray-200">
                                <flux:button type="button" x-on:click="$dispatch('close-modal', { name: 'delete-category-{{ $category->id }}' })"
                                             class="px-4 py-2 border border-gray-400 shadow-sm text-sm font-medium rounded-lg text-gray-900 bg-white hover:bg-gray-100 transition">
                                    Отмена
                                </flux:button>
                                <button type="button"
                                        class="inline-flex justify-center py-2 px-4 border border-red-700 shadow-sm text-sm font-medium rounded-lg text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700 transition"
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
                    </flux:modal>

                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Нет категорий</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end">
            {{ $categories->links() }}
        </div>
    </div>

    <flux:modal name="create-category" class="md:w-96">
        <div class="space-y-4">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Новая категория</h3>
                <p class="mt-1 text-sm text-gray-600">Заполните форму для добавления категории</p>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label for="create_name" class="block text-sm font-medium text-gray-900">
                        Название категории <span class="ml-1 text-xs px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full font-semibold">Обязательно</span>
                    </label>
                    <input type="text" name="name" id="create_name" placeholder="Введите название категории" required
                           value="{{ old('name') }}"
                           class="block w-full px-3 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-black focus:border-black sm:text-sm bg-white text-gray-900"
                    />
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-gray-200">
                    <flux:spacer />
                    <flux:button type="button" x-on:click="$dispatch('close-modal', { name: 'create-category' })"
                                 class="px-4 py-2 border border-gray-400 shadow-sm text-sm font-medium rounded-lg text-gray-900 bg-white hover:bg-gray-100 transition">
                        Отмена
                    </flux:button>
                    <flux:button type="submit"
                                 class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">
                        Сохранить
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

</x-layouts.app>