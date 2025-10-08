<x-layouts.app :title="'Employees'">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between">
            <div>
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{route('dashboard')}}">Панель управление</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>{{ __('Сотрудники') }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>
                @if(isset($department))
                    <h2 class="text-xl font-semibold mt-1 text-gray-800 dark:text-gray-200">
                        Департамент: "{{ $department->name }}"
                    </h2>
                @endif
            </div>
            <a href="{{ route('admin.employees.create') }}" class="px-4 py-2 bg-gray-600 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-500 dark:hover:bg-gray-600 transition-all duration-200">
               Добавить сотрудников
            </a>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            <tr>
                <th class="px-6 py-3 text-left">Фото</th>
                <th class="px-6 py-3 text-left">Полное имя</th>
                <th class="px-6 py-3 text-left">Должность</th>
                <th class="px-6 py-3 text-left">Департамент</th>
                <th class="px-6 py-3 text-left">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <td class="px-6 py-4">
                        @if ($employee->avatar_url)
                            <img src="{{ asset('storage/' . $employee->avatar_url) }}"
                                 alt="{{ $employee->full_name }}"
                                 class="w-12 h-12 rounded-full object-cover border border-gray-300 dark:border-gray-700 shadow-sm">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 text-sm">
                                {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $employee->full_name }}</td>
                    <td class="px-6 py-4">{{ $employee->position }}</td>

                    <td class="px-6 py-4">
                        <a href="{{ route('admin.employees.byDepartment', $employee->department) }}"
                           class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $employee->department->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 flex gap-2 justify-left">

                        <flux:button
                                href="{{ route('admin.employees.show', $employee) }}"
                                icon="eye">
                        </flux:button>
                        <flux:button
                                href="{{ route('admin.employees.edit', $employee) }}"
                                icon="pencil-square">
                        </flux:button>

                        <flux:button
                                icon="trash"
                                icon-only
                                class="text-red-600 hover:text-red-500"
                                title="Удалить"
                                onclick="
                                    if (!confirm('Вы уверены что хотите удалить?')) return;
                                    fetch('{{ route('admin.employees.destroy', $employee) }}', {
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
            {{ $employees->links() }}
        </div>
    </div>
</x-layouts.app>
