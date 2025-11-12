<x-layouts.app :title="__('Категории')">
    @if(session('alert'))
        <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
        >
            <x-alerts.alert
                    :type="session('alert.type')"
                    :message="session('alert.message')"
            />
        </div>
    @endif



    <div class="flex flex-col flex-1 w-full h-full gap-4">
        <div class="flex items-center justify-between mb-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <flux:breadcrumbs class="mt-4 md:mt-0">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" />
                    <flux:breadcrumbs.item>Категории</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>

            <div class="flex gap-2 items-center">
                <flux:button href="{{ route('admin.categories.create') }}" icon="plus" variant="primary">
                    {{ __('Добавить категорию') }}
                </flux:button>
            </div>
        </div>

        <div class="border rounded-xl border-gray-200 overflow-hidden bg-white dark:bg-gray-900">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="w-4 p-4"></th>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Название</th>
                    <th class="px-6 py-3 text-left">Дата создания</th>
                    <th class="px-6 py-3 text-left">Действия</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="w-4 p-4">
                            <input
                                    type="checkbox"
                                    value="{{ $category->id }}"
                                    class="accent-blue-500 w-4 h-4 rounded cursor-pointer"
                            />
                        </td>

                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $category->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                            {{ $category->created_at->format('d.m.Y') }}
                        </td>

                        <td class="px-6 py-4 flex gap-2">
                            <flux:button
                                    href="{{ route('admin.categories.edit', $category) }}"
                                    icon="pencil"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 transition shadow-sm"
                            />
                            <flux:button
                                    icon="trash"
                                    icon-only
                                    class="text-red-600 hover:text-red-500"
                                    title="Удалить"
                                    onclick="
                                        if (!confirm('Вы уверены, что хотите удалить категорию?')) return;
                                        fetch('{{ route('admin.categories.destroy', $category) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json'
                                            },
                                            body: JSON.stringify({ _method: 'DELETE' })
                                        }).then(() => location.reload());
                                    "
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Нет категорий
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-layouts.app>
