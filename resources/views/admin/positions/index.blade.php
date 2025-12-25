<x-layouts.app :title="__('Должности')">
    <div x-data="resourceManager()" class="flex flex-col flex-1 w-full h-full gap-6 p-4">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Все должности</h1>

            <flux:modal.trigger name="create-position">
                <flux:button icon="plus" class="bg-black hover:bg-gray-800 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                    Новая должность
                </flux:button>
            </flux:modal.trigger>
        </div>

        <div class="border rounded-xl border-gray-300 overflow-hidden bg-white shadow-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="w-4 p-4"><input type="checkbox" class="accent-black" /></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Название</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Дата создания</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Действия</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($positions as $position)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="w-4 p-4">
                            <input type="checkbox" value="{{ $position->id }}" class="accent-black" />
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $position->name }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $position->created_at?->format('d.m.Y') ?? '—' }}
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <flux:modal.trigger name="edit-position-{{ $position->id }}">
                                <flux:button icon="pencil"
                                              title="Редактировать"
                                              icon-only
                                              type="button" />
                            </flux:modal.trigger>
                            <flux:button
                                    icon="trash"
                                    variant="ghost"
                                    x-on:click="handleAction('delete', '{{ route('admin.positions.destroy', $position) }}')"
                            />
                        </td>
                    </tr>

                    {{-- МОДАЛКА РЕДАКТИРОВАНИЯ ДОЛЖНА БЫТЬ ВНУТРИ ЦИКЛА --}}
                    <flux:modal name="edit-position-{{ $position->id }}" class="md:w-96">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Редактирование должности</h3>
                                <p class="mt-1 text-sm text-gray-600">Измените название должности</p>
                            </div>

                            <form action="{{ route('admin.positions.update', $position) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-900">Название</label>
                                    <input type="text" name="name" required value="{{ old('name', $position->name) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-black focus:border-black sm:text-sm"
                                    />
                                </div>

                                <div class="flex justify-end gap-2 pt-3 border-t border-gray-200">
                                    <flux:modal.close>
                                        <flux:button variant="ghost">Отмена</flux:button>
                                    </flux:modal.close>
                                    <flux:button type="submit" class="bg-black text-white">Сохранить</flux:button>
                                </div>
                            </form>
                        </div>
                    </flux:modal>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end">
            {{ $positions->links() }}
        </div>
    </div>

    {{-- МОДАЛКА СОЗДАНИЯ (ВНЕ ЦИКЛА) --}}
    <flux:modal name="create-position" class="md:w-96">
        <div class="space-y-4">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Новая должность</h3>
                <p class="mt-1 text-sm text-gray-600">Добавьте новую позицию в список</p>
            </div>

            <form action="{{ route('admin.positions.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-900">Название</label>
                    <input type="text" name="name" placeholder="Напр: Менеджер" required value="{{ old('name') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-black focus:border-black sm:text-sm"
                    />
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-gray-200">
                    <flux:modal.close>
                        <flux:button variant="ghost">Отмена</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" class="bg-black text-white">Создать</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</x-layouts.app>