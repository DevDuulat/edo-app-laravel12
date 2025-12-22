<x-layouts.app :title="__('Должности')">
{{--    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}--}}

    <div class="flex flex-col flex-1 w-full h-full gap-6 p-4">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Все должности</h1>

            <flux:modal.trigger name="create-position">
                <flux:button
                        icon="plus"
                        type="button"
                        class="inline-flex items-center px-4 py-2 border text-sm font-medium rounded-lg shadow-md text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition"
                >
                    Новая должность
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
                @foreach($positions as $position)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="w-4 p-4">
                            <input type="checkbox" value="{{ $position->id }}" class="accent-black w-4 h-4 rounded cursor-pointer border-gray-300 focus:ring-black" />
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $position->name }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $position->created_at?->format('d.m.Y') ?? '—' }}
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <flux:modal.trigger name="edit-category-{{ $position->id }}">
                                <flux:button
                                        icon="pencil"
                                        title="Редактировать"
                                        icon-only
                                        type="button"
                                />
                            </flux:modal.trigger>

                            <flux:modal.trigger name="delete-category-{{ $position->id }}">
                                <flux:button
                                        icon="trash"
                                        icon-only
                                        title="Удалить"
                                        type="button"
                                />
                            </flux:modal.trigger>
                        </td>
                    </tr>

    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end">
            {{ $positions->links() }}
        </div>
    </div>

    <flux:modal name="create-position" class="md:w-96">
        <div class="space-y-4">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Новая должность</h3>
                <p class="mt-1 text-sm text-gray-600">Заполните форму для добавления должности</p>
            </div>

            <form action="{{ route('admin.positions.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label for="create_name" class="block text-sm font-medium text-gray-900">
                        Название должности <span class="ml-1 text-xs px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full font-semibold">Обязательно</span>
                    </label>
                    <input type="text" name="name" id="create_name" placeholder="Введите название должности" required
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