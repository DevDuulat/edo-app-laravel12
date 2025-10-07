<x-layouts.app :title="$employee->full_name">

    <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-xl shadow-lg max-w-lg mx-auto">

        <!-- Аватар -->
        <div class="flex justify-center mb-4">
            @if ($employee->avatar_url)
                <img src="{{ asset('storage/' . $employee->avatar_url) }}"
                     alt="{{ $employee->full_name }}"
                     class="w-24 h-24 rounded-full object-cover border border-gray-300 dark:border-gray-700 shadow-sm">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 text-2xl font-bold">
                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                </div>
            @endif
        </div>


        <!-- Имя -->
        <flux:heading size="2xl" class="mt-4 mb-4 text-gray-900 dark:text-gray-100">
            {{ $employee->full_name }}
        </flux:heading>

        <!-- Информация -->
        <div class="space-y-2">
            <flux:text><strong>Должность:</strong> {{ $employee->position }}</flux:text>
            <flux:text><strong>Заработная плата:</strong> {{ $employee->salary }}</flux:text>
            <flux:text><strong>Дата найма:</strong> {{ $employee->hire_date->format('d.m.Y') }}</flux:text>
            <flux:text><strong>Департамент:</strong> {{ $employee->department->name }}</flux:text>
            <flux:text><strong>Номер паспорта:</strong> {{ $employee->passport_number ?? '-' }}</flux:text>
            <flux:text><strong>ИНН:</strong> {{ $employee->inn ?? '-' }}</flux:text>
        </div>

        <!-- Кнопки -->
        <div class="mt-6 flex gap-3">
            <flux:button
                    as="a"
                    href="{{ route('admin.employees.edit', $employee) }}"
                    icon="pencil-square"
                    class="bg-gray-600 dark:bg-gray-700 text-white"
            >
                Редактировать
            </flux:button>

            <flux:button
                    as="a"
                    href="{{ route('admin.employees.index') }}"
                    icon="arrow-left"
                    class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300"
            >
                Назад
            </flux:button>
        </div>

    </div>
</x-layouts.app>
