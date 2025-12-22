<x-layouts.app :title="__('Департаменты')">
    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}

<div x-data="resourceManager()"  class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Департаменты') }}</h1>
            <flux:button href="{{ route('admin.departments.create') }}" icon="plus" class="bg-black hover:bg-gray-800 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                {{ __('Добавить департамент') }}
            </flux:button>
        </div>

        <div class="border rounded-xl border-gray-300 overflow-x-auto bg-white shadow-lg w-full">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="p-4">
                        <input
                            type="checkbox"
                            :checked="selectedDepartments.length === {{ $departments->count() }}"
                            @click="selectedDepartments = selectedDepartments.length === {{ $departments->count() }} ? [] : @js($departments->pluck('id'))"
                            class="w-4 h-4 text-black bg-white border-gray-300 rounded focus:ring-black"
                        />
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Название</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Локация</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Сотрудники</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Дата создания</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Действия</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($departments as $department)
                    <tr class="hover:bg-gray-50 transition duration-150" data-department-id="{{ $department->id }}">
                        <td class="w-4 p-4">
                            <label class="flex items-center justify-center w-6 h-6 bg-white transition cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="department_ids[]"
                                    value="{{ $department->id }}"
                                    x-model="selectedDepartments"
                                    class="w-4 h-4 text-black bg-white border-gray-300 rounded focus:ring-black cursor-pointer"
                                />
                            </label>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $department->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $department->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $department->location ?? '-' }}</td>

                        <td class="px-6 py-4">
                            <a href="{{ route('admin.employees.byDepartment', $department->id) }}"
                               class="font-medium text-gray-900 hover:text-black underline transition duration-150">
                                {{ $department->name }}
                            </a>

                            <div class="flex items-center mt-2 space-x-2 overflow-x-auto py-1">
                                @foreach($department->employees as $index => $employee)
                                    @if($index < 4)
                                        <img
                                            class="w-10 h-10 rounded-full border-2 border-gray-100 shadow-sm object-cover hover:scale-110 transition-transform duration-200 cursor-pointer"
                                            src="{{ asset('storage/' . $employee->avatar_url) }}"
                                            alt="{{ $employee->name }}"
                                            title="{{ $employee->name }}"
                                        >
                                    @endif
                                @endforeach

                                @if($department->employees()->count() > 4)
                                    <a href="{{ route('admin.employees.byDepartment', $department->id) }}"
                                       class="flex items-center justify-center w-10 h-10 text-xs font-semibold text-white bg-black border-2 border-gray-100 rounded-full shadow-sm hover:bg-gray-800 hover:scale-105 transition-transform duration-200"
                                       title="Еще {{ $department->employees()->count() - 4 }} сотрудников">
                                        +{{ $department->employees()->count() - 4 }}
                                    </a>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $department->created_at->format('d.m.Y') }}</td>

                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <flux:button
                                href="{{ route('admin.departments.edit', $department) }}"
                                icon="pencil"
                                class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 hover:text-black transition shadow-sm"
                            />
                                <flux:button
                                    icon="trash"
                                    icon-only
                                    title="Удалить"
                                    x-on:click="handleAction('delete', '{{ route('admin.departments.destroy', $department) }}')"
                                />
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 w-full">
            {{ $departments->links() }}
        </div>
    </div>

   
</x-layouts.app>
