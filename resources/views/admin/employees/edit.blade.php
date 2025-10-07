<x-layouts.app :title="__('Редактировать Сотрудника')">

    <div class="flex flex-col flex-1 w-full h-full gap-6 p-6 bg-gray-50 dark:bg-gray-900 rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
            {{ __('Редактировать Сотрудника') }}
        </h1>

        <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data" class="grid gap-5 max-w-5xl md:grid-cols-2">
            @csrf
            @method('PUT')

            <!-- Имя -->
            <div class="flex flex-col gap-2">
                <label for="first_name" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Имя') }}</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $employee->first_name) }}" required
                       placeholder="Введите имя"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('first_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Фамилия -->
            <div class="flex flex-col gap-2">
                <label for="last_name" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Фамилия') }}</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $employee->last_name) }}" required
                       placeholder="Введите фамилию"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('last_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Должность -->
            <div class="flex flex-col gap-2">
                <label for="position" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Должность') }}</label>
                <input type="text" name="position" id="position" value="{{ old('position', $employee->position) }}" required
                       placeholder="Введите должность"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('position')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Заработная плата -->
            <div class="flex flex-col gap-2">
                <label for="salary" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Заработная плата') }}</label>
                <input type="number" step="0.01" name="salary" id="salary" value="{{ old('salary', $employee->salary) }}" required
                       placeholder="Введите заработную плату"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('salary')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Дата найма -->
            <div class="flex flex-col gap-2">
                <label for="hire_date" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Дата найма') }}</label>
                <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date', $employee->hire_date->format('Y-m-d')) }}" required
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 transition-all duration-300">
                @error('hire_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Департамент -->
            <div class="flex flex-col gap-2">
                <label for="department_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Департамент') }}</label>
                <select name="department_id" id="department_id" required
                        class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 transition-all duration-300">
                    <option value="">Выберите департамент</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Паспорт -->
            <div class="flex flex-col gap-2">
                <label for="passport_number" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Введите паспорт') }}</label>
                <input type="text" name="passport_number" id="passport_number" value="{{ old('passport_number', $employee->passport_number) }}"
                       placeholder="Введите паспорт"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('passport_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- ИНН -->
            <div class="flex flex-col gap-2">
                <label for="inn" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ИНН') }}</label>
                <input type="text" name="inn" id="inn" value="{{ old('inn', $employee->inn) }}"
                       placeholder="Введите ИНН"
                       class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                @error('inn')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Фото сотрудника -->
            <div class="flex flex-col gap-2 md:col-span-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Фото сотрудника') }}</label>

                <div id="dropzone" class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300
                     border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <input id="avatar_url" name="avatar_url" type="file" accept="image/*"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                    <div id="preview-container" class="flex flex-col items-center justify-center text-center">
                        @if($employee->avatar_url)
                            <img src="{{ asset('storage/' . $employee->avatar_url) }}" alt="preview" class="w-32 h-32 object-cover rounded-lg shadow">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m10 12V4m1 4H6m6 4v8" />
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Перетащите фото сюда или нажмите для выбора файла</p>
                        @endif
                    </div>
                </div>

                @error('avatar_url')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Buttons -->
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

    <!-- Скрипт превью аватара -->
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
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Перетащите фото сюда или нажмите для выбора файла</p>
                        `;
                    });
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

</x-layouts.app>
