<x-layouts.app :title="__('Departments')">
    @if(session('alert'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <x-alerts.alert :type="session('alert.type')" :message="session('alert.message')" />
        </div>
    @endif

    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">{{ __('Департаменты') }}</h1>
            <flux:button href="{{ route('admin.departments.create') }}" icon="plus" variant="primary">
                {{ __('Добавить департамент') }}
            </flux:button>
        </div>

        <div class="border rounded-xl border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="p-4">
                        <input
                                type="checkbox"
                                :checked="selectedDepartments.length === {{ $departments->count() }}"
                                @click="selectedDepartments = selectedDepartments.length === {{ $departments->count() }} ? [] : @js($departments->pluck('id'))"
                                class="w-4 h-4"
                        />
                    </th>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Название</th>
                    <th class="px-6 py-3 text-left">Локация</th>
                    <th class="px-6 py-3 text-left">Сотрудники</th>
                    <th class="px-6 py-3 text-left">Дата создания</th>
                    <th class="px-6 py-3 text-left">Действия</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($departments as $department)
                    <tr class="hover:bg-gray-50" data-department-id="{{ $department->id }}">
                        <td class="w-4 p-4">
                            <label class="flex items-center justify-center w-6 h-6 border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition cursor-pointer">
                                <input
                                        type="checkbox"
                                        name="department_ids[]"
                                        value="{{ $department->id }}"
                                        x-model="selectedDepartments"
                                        class="accent-blue-500 w-4 h-4 rounded cursor-pointer"
                                />
                            </label>
                        </td>

                        <td class="px-6 py-4">{{ $department->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $department->name }}</td>
                        <td class="px-6 py-4">{{ $department->location ?? '-' }}</td>

                        <td class="px-6 py-4">
                            <!-- Название департамента -->
                            <a href="{{ route('admin.employees.byDepartment', $department->id) }}"
                               class="font-medium text-gray-900 hover:text-blue-600 transition duration-150">
                                {{ $department->name }}
                            </a>

                            <!-- Аватары сотрудников с подсказкой и прокруткой -->
                            <div class="flex items-center mt-2 space-x-2 overflow-x-auto py-1">
                                @foreach($department->employees as $index => $employee)
                                    @if($index < 4)
                                        <img
                                                class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover hover:scale-110 transition-transform duration-200 cursor-pointer"
                                                src="{{ asset('storage/' . $employee->avatar_url) }}"
                                                alt="{{ $employee->name }}"
                                                title="{{ $employee->name }}"
                                        >
                                    @endif
                                @endforeach

                                @if($department->employees()->count() > 4)
                                    <a href="{{ route('admin.employees.byDepartment', $department->id) }}"
                                       class="flex items-center justify-center w-10 h-10 text-xs font-semibold text-white bg-gray-700 border-2 border-white rounded-full shadow-sm hover:bg-gray-600 hover:scale-105 transition-transform duration-200"
                                       title="Еще {{ $department->employees()->count() - 4 }} сотрудников">
                                        +{{ $department->employees()->count() - 4 }}
                                    </a>
                                @endif
                            </div>
                        </td>



                        <td class="px-6 py-4">{{ $department->created_at->format('d.m.Y') }}</td>

                        <td class="px-6 py-4 flex gap-2">
                            <flux:button
                                    href="{{ route('admin.departments.edit', $department) }}"
                                    icon="pencil"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition shadow-sm"
                            />
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
