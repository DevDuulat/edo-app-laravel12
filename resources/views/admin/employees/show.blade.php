<x-layouts.app :title="$employee->full_name">

    <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-xl shadow-lg max-w-lg">
        @if ($employee->avatar_url)
            <img src="{{ asset('storage/' . $employee->avatar_url) }}"
                 alt="{{ $employee->full_name }}"
                 class="w-12 h-12 rounded-full object-cover border border-gray-300 dark:border-gray-700 shadow-sm">
        @else
            <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 text-sm">
                {{ strtoupper(substr($employee->first_name, 0, 1)) }}
            </div>
        @endif
        <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">
            {{ $employee->full_name }}
        </h1>

        <p><strong>Должность:</strong> {{ $employee->position }}</p>
        <p><strong>Заработная плата:</strong> {{ $employee->salary }}</p>
        <p><strong>Дата найма:</strong> {{ $employee->hire_date->format('d.m.Y') }}</p>
        <p><strong>Департамент:</strong> {{ $employee->department->name }}</p>
        <p><strong>Номер паспорта:</strong> {{ $employee->passport_number ?? '-' }}</p>
        <p><strong>ИНН:</strong> {{ $employee->inn ?? '-' }}</p>



        <div class="mt-4 flex gap-3">
            <a href="{{ route('admin.employees.edit', $employee) }}" class="px-4 py-2 bg-gray-600 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-500 dark:hover:bg-gray-600 transition-all duration-200">
                Редактировать
            </a>
            <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 border border-gray-400 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                Назад
            </a>
        </div>
    </div>
</x-layouts.app>
