<x-layouts.app :title="$employee->full_name">
    {{ Breadcrumbs::render(Route::currentRouteName(), ...array_values(Route::current()->parameters())) }}
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="max-w-4xl mx-auto w-full">

            <h3 class="mb-2 text-2xl leading-none tracking-tight text-center text-gray-900 md:text-2xl">
                Страница сотрудника
            </h3>
        </div>

        <div class="p-5 rounded-xl border border-gray-200 bg-white max-w-4xl mx-auto w-full shadow-lg">

            <div class="flex flex-col items-center mb-6">
                @if ($employee->avatar_url)
                    <img src="{{ asset('storage/' . $employee->avatar_url) }}"
                         alt="{{ $employee->full_name }}"
                         class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                @else
                    <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 text-2xl font-bold border border-gray-300">
                        {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                    </div>
                @endif
                <h1 class="mt-4 text-3xl font-bold text-gray-900 text-center">
                    {{ $employee->full_name }}
                </h1>
            </div>

            <div class="space-y-4 pt-4 border-t border-gray-200">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-500">Должность</span>
                        <span class="text-lg text-gray-900">{{ $employee->position }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-500">Заработная плата</span>
                        <span class="text-lg text-gray-900">{{ $employee->salary }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-500">Дата найма</span>
                        <span class="text-lg text-gray-900">{{ $employee->hire_date->format('d.m.Y') }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-500">Департамент</span>
                        <span class="text-lg text-gray-900">{{ $employee->department->name }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-500">Номер паспорта</span>
                        <span class="text-lg text-gray-900">{{ $employee->passport_number ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-500">ИНН</span>
                        <span class="text-lg text-gray-900">{{ $employee->inn ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <flux:heading size="xl" class="mb-4 font-bold text-gray-900">
                    Паспорта
                </flux:heading>

                <div id="passport-gallery"
                     class="flex flex-wrap gap-3 mt-2 pswp-gallery passport-gallery">

                    @if ($passportFiles->isNotEmpty())
                        @foreach ($passportFiles as $file)
                            <x-file-preview :file="$file" :can-delete="false" />
                        @endforeach
                    @else
                        <p class="text-gray-500">
                            Паспорта отсутствуют.
                        </p>
                    @endif
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <flux:heading size="xl" class="mb-4 font-bold text-gray-900">
                    Документы
                </flux:heading>
                <div id="other-documents-gallery"
                     class="flex flex-wrap gap-3 mt-2 pswp-gallery">

                    @if ($otherFiles->isNotEmpty() )
                        @foreach ($otherFiles as $file)
                            <x-file-preview :file="$file" :can-delete="false" />
                        @endforeach
                    @else
                        <p class="text-gray-500">
                            Документы отсутствуют.
                        </p>
                    @endif
                </div>
            </div>

        </div>

        <div class="mt-6 flex gap-3 max-w-4xl mx-auto w-full">
            <flux:button
                    as="a"
                    href="{{ route('admin.employees.edit', $employee) }}"
                    icon="pencil-square"
                    class="bg-black hover:bg-gray-800 text-white font-semibold"
            >
                Редактировать
            </flux:button>

            <flux:button
                    as="a"
                    href="{{ route('admin.employees.index') }}"
                    icon="arrow-left"
                    class="bg-white border border-gray-400 hover:bg-gray-100 text-gray-900 font-semibold"
            >
                Назад
            </flux:button>
        </div>

    </div>
</x-layouts.app>