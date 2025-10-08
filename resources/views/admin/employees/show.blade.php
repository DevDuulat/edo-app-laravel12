<x-layouts.app :title="$employee->full_name">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between">
            <nav class="flex px-5 py-3 text-gray-700 rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{route('dashboard')}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-zinc-800 dark:text-gray-400 dark:hover:text-white">
                            <x-icon.home-icon/>
                            Панель управление
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-icon.arrow-breadcrumb-icon/>
                            <a href="{{route('admin.employees.index')}}" class="ms-1 text-sm font-medium text-gray-700 hover:text-zinc-800 md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ __('Сотрудники') }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <x-icon.arrow-breadcrumb-icon/>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Редактирование Сотрудника</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    <div class="p-5 rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

        <!-- Аватар -->
        <div class="flex justify-left mb-4">
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
