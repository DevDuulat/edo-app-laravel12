<x-layouts.app :title="__('Departments')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between">
            <!-- Breadcrumb -->

            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="#" icon="home" />
                <flux:breadcrumbs.item>{{ __('Департамент') }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>


            <a href="{{ route('admin.departments.create') }}"  class="px-4 py-2 bg-gray-600 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-500 dark:hover:bg-gray-600 transition-all duration-200">
                {{ __('Добавить департамент') }}
            </a>
        </div>

        <div class="relative overflow-x-auto rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <table class="min-w-full overflow-hidden">
                <thead class="bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100">
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
