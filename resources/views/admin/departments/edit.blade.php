<x-layouts.app :title="__('Редактировать департамент')">
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
                            <a href="{{route('admin.departments.index')}}" class="ms-1 text-sm font-medium text-gray-700 hover:text-zinc-800 md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ __('Департамент') }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <x-icon.arrow-breadcrumb-icon/>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Создание Департамента</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="px-5 py-5 rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <form action="{{ route('admin.departments.update', $department->id) }}" method="POST" class="grid gap-5 max-w-lg">
            @csrf
            @method('PUT')

            <!-- Name Input -->
            <div class="flex flex-col gap-2">
                <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Название') }}
                </label>
                <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $department->name) }}"
                        required
                        placeholder="Введите название департамента"
                        class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300"
                />
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location Input -->
            <div class="flex flex-col gap-2">
                <label for="location" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Локация') }}
                </label>
                <input
                        type="text"
                        name="location"
                        id="location"
                        value="{{ old('location', $department->location) }}"
                        placeholder="Введите локацию"
                        class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300"
                />
                @error('location')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 mt-4">
                <button type="submit"
                        class="px-6 py-2 bg-gray-600 dark:bg-gray-700 hover:bg-gray-500 dark:hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                    {{ __('Обновить') }}
                </button>
                <a href="{{ route('admin.departments.index') }}"
                   class="px-6 py-2 border border-gray-400 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                    {{ __('Отмена') }}
                </a>
            </div>
        </form>
        </div>
    </div>
</x-layouts.app>
