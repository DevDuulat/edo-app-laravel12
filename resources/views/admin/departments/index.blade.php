<x-layouts.app :title="__('Departments')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{route('dashboard')}}">Панель управление</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>{{ __('Департамент') }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <a href="{{ route('admin.departments.create') }}"  class="px-4 py-2 bg-gray-600 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-500 dark:hover:bg-gray-600 transition-all duration-200">
                {{ __('Добавить департамент') }}
            </a>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left">ID</th>
                    <th scope="col" class="px-6 py-3 text-left">Название</th>
                    <th scope="col" class="px-6 py-3 text-left">Локация</th>
                    <th scope="col" class="px-6 py-3 text-left">Дата создание</th>
                    <th scope="col" class="px-6 py-3 text-left">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($departments as $department)
                    <tr class="odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 border-b dark:border-zinc-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $department->id }}</td>
                        <td class="px-6 py-4">{{ $department->name }}</td>
                        <td class="px-6 py-4">{{ $department->location ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $department->created_at }}</td>
                        <td class="px-6 py-4 flex gap-2">

                            <flux:button
                                    href="{{ route('admin.departments.edit', $department) }}"
                                    icon="pencil-square">
                            </flux:button>
                            <flux:button
                                    icon="trash"
                                    icon-only
                                    class="text-red-600 hover:text-red-500"
                                    title="Удалить"
                                    onclick="
                                    if (!confirm('Вы уверены что хотите удалить?')) return;
                                    fetch('{{ route('admin.departments.destroy', $department) }}', {
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
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $departments->links() }}
        </div>
    </div>
</x-layouts.app>
