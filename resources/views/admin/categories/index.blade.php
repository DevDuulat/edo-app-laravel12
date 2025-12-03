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

            <flux:modal.trigger name="create-category">
                <flux:button variant="primary" icon="plus">Новая категория</flux:button>
            </flux:modal.trigger>
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
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $category->created_at->format('d.m.Y') }}</td>
                        <td class="px-6 py-4 flex gap-2">

                            <flux:modal.trigger name="edit-category-{{ $category->id }}">
                                <flux:button icon="pencil" variant="outline" title="Редактировать"
                                             class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 transition shadow-sm"/>
                            </flux:modal.trigger>

                            <flux:modal.trigger name="delete-category-{{ $category->id }}">
                                <flux:button icon="trash" icon-only variant="ghost" color="red" title="Удалить"/>
                            </flux:modal.trigger>
                        </td>
                    </tr>

                    <flux:modal name="edit-category-{{ $category->id }}" class="md:w-96">
                        <div class="space-y-4">
                            <div>
                                <flux:heading size="lg">Редактирование категории</flux:heading>
                                <flux:text class="mt-1 text-gray-500">Измените данные категории и сохраните изменения</flux:text>
                            </div>

                            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <flux:field>
                                    <flux:label badge="Обязательно">Название категории</flux:label>
                                    <flux:input name="name" required value="{{ old('name', $category->name) }}"
                                                class="@error('name') border-red-500 @enderror"/>
                                    @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </flux:field>

                                <div class="flex justify-end gap-2 pt-3 border-t border-gray-200">
                                    <flux:button type="submit" variant="primary">Сохранить изменения</flux:button>
                                </div>
                            </form>
                        </div>
                    </flux:modal>

                    <flux:modal name="delete-category-{{ $category->id }}" class="md:w-80">
                        <div class="space-y-4 text-center">
                            <flux:heading size="lg" class="text-red-600">Удаление категории</flux:heading>
                            <flux:text>Вы уверены, что хотите удалить категорию "<strong>{{ $category->name }}</strong>"? Это действие нельзя будет отменить.</flux:text>
                            <div class="flex justify-center gap-3 mt-4">
                                <flux:button variant="outline" color="red"
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
                                >Удалить</flux:button>
                            </div>
                        </div>
                    </flux:modal>

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

    <flux:modal name="create-category" class="md:w-96">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Новая категория</flux:heading>
                <flux:text class="mt-1 text-gray-500">Заполните форму для добавления категории</flux:text>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <flux:field>
                    <flux:label badge="Обязательно">Название категории</flux:label>
                    <flux:input name="name" placeholder="Введите название категории" required
                                value="{{ old('name') }}" class="@error('name') border-red-500 @enderror"/>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </flux:field>

                <div class="flex justify-end gap-2 pt-3 border-t border-gray-200">
                    <flux:button type="submit" variant="primary">Сохранить</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</x-layouts.app>
