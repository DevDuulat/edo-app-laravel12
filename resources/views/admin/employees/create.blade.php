<x-layouts.app :title="__('Создать Сотрудника')">
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
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Создание Сотрудника</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="px-5 py-5 rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-5 max-w-5xl md:grid-cols-2">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="first_name" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Имя') }}</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                       placeholder="Введите имя"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('first_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="last_name" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Фамилия') }}</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                       placeholder="Введите фамилию"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('last_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="position" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Должность') }}</label>
                <input type="text" name="position" id="position" value="{{ old('position') }}" required
                       placeholder="Введите должность"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('position')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="salary" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Заработная плата') }}</label>
                <input type="number" step="0.01" name="salary" id="salary" value="{{ old('salary') }}" required
                       placeholder="Введите заработную плату"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('salary')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="hire_date" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Дата найма') }}</label>
                <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date') }}" required
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 transition-all duration-300">
                @error('hire_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="department_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Департамент') }}</label>
                <select name="department_id" id="department_id" required
                        class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 transition-all duration-300">
                    <option value="">Введите департамент</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="passport_number" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Введите паспорт') }}</label>
                <input type="text" name="passport_number" id="passport_number" value="{{ old('passport_number') }}"
                       placeholder="Введите паспорт"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('passport_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="inn" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ИНН') }}</label>
                <input type="text" name="inn" id="inn" value="{{ old('inn') }}"
                       placeholder="Введите ИНН"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('inn')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Фото сотрудника') }}
                </label>

                <div
                        id="dropzone"
                        class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300
               border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700"
                >
                    <input
                            id="avatar_url"
                            name="avatar_url"
                            type="file"
                            accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    >

                    <div id="preview-container" class="flex flex-col items-center justify-center text-center">
                        <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 11C8.10457 11 9 10.1046 9 9C9 7.89543 8.10457 7 7 7C5.89543 7 5 7.89543 5 9C5 10.1046 5.89543 11 7 11Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M5.56055 21C11.1305 11.1 15.7605 9.35991 21.0005 15.7899" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12.28 3H5C3.93913 3 2.92172 3.42136 2.17157 4.17151C1.42142 4.92165 1 5.93913 1 7V17C1 18.0609 1.42142 19.0782 2.17157 19.8284C2.92172 20.5785 3.93913 21 5 21H17C18.0609 21 19.0783 20.5785 19.8284 19.8284C20.5786 19.0782 21 18.0609 21 17V12" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M18.75 8.82996V0.829956" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M15.5508 4.02996L18.7508 0.829956L21.9508 4.02996" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Перетащите фото сюда или нажмите для выбора файла
                        </p>
                    </div>
                </div>

                @error('avatar_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons (span 2 columns) -->
            <div class="flex gap-3 mt-4 md:col-span-2">
                <button type="submit" class="px-6 py-2 bg-gray-600 dark:bg-gray-700 hover:bg-gray-500 dark:hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                    {{ __('Сохранить') }}
                </button>
                <a href="{{ route('admin.employees.index') }}" class="px-6 py-2 border border-gray-400 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                    {{ __('Отмена') }}
                </a>
            </div>
        </form>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropzone = document.getElementById('dropzone');
            const fileInput = document.getElementById('avatar_url');
            const previewContainer = document.getElementById('preview-container');

            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('border-gray-500', 'bg-gray-100', 'dark:bg-gray-700');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('border-gray-500', 'bg-gray-100', 'dark:bg-gray-700');
            });

            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('border-gray-500', 'bg-gray-100', 'dark:bg-gray-700');
                const file = e.dataTransfer.files[0];
                fileInput.files = e.dataTransfer.files;
                previewFile(file);
            });

            fileInput.addEventListener('change', () => {
                const file = fileInput.files[0];
                previewFile(file);
            });

            function previewFile(file) {
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewContainer.innerHTML = `
                <div class="relative">
                    <img src="${e.target.result}" alt="preview" class="w-32 h-32 object-cover rounded-lg shadow">
                    <button type="button" id="removeImage" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700">&times;</button>
                </div>
            `;
                    document.getElementById('removeImage').addEventListener('click', () => {
                        fileInput.value = '';
                        previewContainer.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m10 12V4m1 4H6m6 4v8" />
                    </svg>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Перетащите фото сюда или нажмите для выбора файла
                    </p>
                `;
                    });
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-layouts.app>
