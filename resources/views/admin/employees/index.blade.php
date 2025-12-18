<x-layouts.app :title="'Сотрудники'">
    {{ Breadcrumbs::render(Route::currentRouteName(), ...array_values(Route::current()->parameters())) }}

    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">

        <div class="flex items-center justify-between mb-6">
        @if(isset($department))
            <h3 class="mb-2 text-2xl font-bold text-center text-gray-900">{{ __('Сотрудники департамента: ":name"', ['name' => $department->name]) }}</h3>
        @else
            <h3 class="mb-2 text-2xl font-bold text-center text-gray-900">{{ __('Сотрудники') }}</h3>
        @endif
            {{--            @can('edo-employee-add')--}}
            <flux:button href="{{ route('admin.employees.create') }}" icon="plus" class="bg-black hover:bg-gray-800 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                {{ __('Добавить сотрудников') }}
            </flux:button>
            {{--            @endcan--}}
        </div>

        <div class="border rounded-xl border-gray-300 overflow-x-auto bg-white shadow-lg w-full">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th class="p-4">
                        <input
                                type="checkbox"
                                :checked="selectedEmployees.length === {{ $employees->count() }}"
                                @click="selectedEmployees = selectedEmployees.length === {{ $employees->count() }} ? [] : @js($employees->pluck('id'))"
                                class="w-4 h-4 text-black bg-white border-gray-300 rounded focus:ring-black"
                        />
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Фото</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Полное имя</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Должность</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Департамент</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Действия</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($employees as $employee)
                    <tr class="hover:bg-gray-50 transition duration-150" data-employee-id="{{ $employee->id }}">
                        <td class="w-4 p-4">
                            <label class="flex items-center justify-center w-6 h-6 bg-white transition cursor-pointer">
                                <input
                                        type="checkbox"
                                        value="{{ $employee->id }}"
                                        x-model="selectedEmployees"
                                        class="w-4 h-4 text-black bg-white border-gray-300 rounded focus:ring-black cursor-pointer"
                                />
                            </label>
                        </td>

                        <td class="px-6 py-4">
                            @if($employee->avatar_url)
                                <img src="{{ asset('storage/' . $employee->avatar_url) }}"
                                     alt="{{ $employee->full_name }}"
                                     class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-semibold text-sm border border-gray-200">
                                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $employee->full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->position }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.employees.byDepartment', $employee->department) }}"
                               class="text-gray-900 hover:text-black underline font-medium">
                                {{ $employee->department->name }}
                            </a>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <flux:button href="{{ route('admin.employees.show', $employee) }}" icon="eye" class="text-gray-700 hover:text-black border border-gray-300 bg-white hover:bg-gray-100" />
                            <flux:button href="{{ route('admin.employees.edit', $employee) }}" icon="pencil" class="text-gray-700 hover:text-black border border-gray-300 bg-white hover:bg-gray-100" />
                            <flux:button
                                    icon="trash"
                                    icon-only
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

        <div class="mt-4 w-full">
            {{ $employees->links() }}
        </div>
    </div>
</x-layouts.app>