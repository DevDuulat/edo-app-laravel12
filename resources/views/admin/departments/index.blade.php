<x-layouts.app :title="__('Departments')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between">
            <!-- Breadcrumb -->

            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="#" icon="home" />
                <flux:breadcrumbs.item>{{ __('Департамент') }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>

            <flux:button href="{{ route('admin.departments.create') }}" icon="plus" variant="primary">
                {{ __('Добавить департамент') }}
            </flux:button>

        </div>
        <h3 class="mb-2 text-2xl leading-none tracking-tight text-center text-gray-900 md:text-2xl dark:text-white">
            Департамент
        </h3>
        <div class="relative overflow-x-auto rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <table class="min-w-full overflow-hidden">
                <thead class="bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left">ID</th>
                    <th scope="col" class="px-6 py-3 text-left">Название</th>
                    <th scope="col" class="px-6 py-3 text-left">Локация</th>
                    <th scope="col" class="px-6 py-3 text-left">Cотрудники</th>
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
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.employees.byDepartment', $department->id) }}"
                               class="text-blue-600 dark:text-blue-400 hover:underline block mb-2">
                                {{ $department->name }}
                            </a>

                            <div class="flex -space-x-4 rtl:space-x-reverse">
                                @foreach($department->employees as $employee)
                                    <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                         src="{{ asset('storage/' . $employee->avatar_url) }} "
                                         alt="{{ $employee->name }}">
                                @endforeach

                                @if($department->employees()->count() > 4)
                                    <a class="flex items-center justify-center w-10 h-10 text-xs font-medium text-white bg-gray-700 border-2 border-white rounded-full hover:bg-gray-600 dark:border-gray-800"
                                       href="{{ route('admin.employees.byDepartment', $department->id) }}">
                                        +{{ $department->employees()->count() - 4 }}
                                    </a>
                                @endif
                            </div>
                        </td>

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
