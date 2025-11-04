<x-layouts.app :title="'Employees'">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between mb-6">
            <!-- Breadcrumb -->
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" />
                <flux:breadcrumbs.item>Сотрудники</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            @can('edo-employee-add')
            <flux:button href="{{ route('admin.employees.create') }}" icon="plus" variant="primary">
                {{ __('Добавить сотрудников') }}
            </flux:button>
            @endcan
        </div>

        @if(isset($department))
            <h3 class="mb-2 text-2xl font-bold text-center">{{ __('Сотрудники департамента: ":name"', ['name' => $department->name]) }}</h3>
        @else
            <h3 class="mb-2 text-2xl font-bold text-center">{{ __('Сотрудники') }}</h3>
        @endif

        <div class="border rounded-xl border-gray-200 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="p-4">
                        <input
                                type="checkbox"
                                :checked="selectedEmployees.length === {{ $employees->count() }}"
                                @click="selectedEmployees = selectedEmployees.length === {{ $employees->count() }} ? [] : @js($employees->pluck('id'))"
                                class="w-4 h-4"
                        />
                    </th>
                    <th class="px-6 py-3 text-left">Фото</th>
                    <th class="px-6 py-3 text-left">Полное имя</th>
                    <th class="px-6 py-3 text-left">Должность</th>
                    <th class="px-6 py-3 text-left">Департамент</th>
                    <th class="px-6 py-3 text-left">Действия</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($employees as $employee)
                    <tr class="hover:bg-gray-50" data-employee-id="{{ $employee->id }}">
                        <td class="w-4 p-4">
                            <label class="flex items-center justify-center w-6 h-6 border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition cursor-pointer">
                                <input
                                        type="checkbox"
                                        value="{{ $employee->id }}"
                                        x-model="selectedEmployees"
                                        class="accent-blue-500 w-4 h-4 rounded cursor-pointer"
                                />
                            </label>
                        </td>

                        <td class="px-6 py-4">
                            @if($employee->avatar_url)
                                <img src="{{ asset('storage/' . $employee->avatar_url) }}"
                                     alt="{{ $employee->full_name }}"
                                     class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4">{{ $employee->full_name }}</td>
                        <td class="px-6 py-4">{{ $employee->position }}</td>

                        <td class="px-6 py-4">
                            <a href="{{ route('admin.employees.byDepartment', $employee->department) }}"
                               class="text-blue-600 hover:underline">
                                {{ $employee->department->name }}
                            </a>
                        </td>

                        <td class="px-6 py-4 flex gap-2">
                            <flux:button href="{{ route('admin.employees.show', $employee) }}" icon="eye" />
                            <flux:button href="{{ route('admin.employees.edit', $employee) }}" icon="pencil" />
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
