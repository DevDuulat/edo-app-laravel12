<x-layouts.app :title="'Employees'">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Сотрудники</h1>
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
                        <a href="{{ route('admin.employees.show', $employee) }}"
                           class="px-3 py-1 bg-gray-600 dark:bg-gray-700 text-white text-sm font-medium rounded-lg shadow hover:bg-gray-500 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all duration-200">
                            Посмотреть
                        </a>

                        <a href="{{ route('admin.employees.edit', $employee) }}"
                           class="px-3 py-1 bg-gray-600 dark:bg-gray-700 text-white text-sm font-medium rounded-lg shadow hover:bg-gray-500 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all duration-200">
                            Редактировать
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-sm font-medium rounded-lg bg-red-600 dark:bg-red-700 text-white hover:bg-red-500 dark:hover:bg-red-600 shadow transition-all duration-200">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
</x-layouts.app>
