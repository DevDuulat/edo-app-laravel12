<x-layouts.app :title="__('Создать Сотрудника')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <!-- Breadcrumbs -->
        <div class="flex items-center justify-between">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" />
                <flux:breadcrumbs.item href="{{ route('admin.employees.index') }}">Сотрудники</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Создание Сотрудника</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <h3 class="mb-2 text-2xl leading-none tracking-tight text-center text-gray-900 md:text-2xl dark:text-white">
            Создание сотрудника
        </h3>

        <div class="px-5 py-5 rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-5 max-w-5xl md:grid-cols-2" x-data="employeeForm()">
                @csrf

                <!-- Имя -->
                <div class="flex flex-col gap-2">
                    <label for="first_name" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Имя') }}</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                           placeholder="Введите имя"
                           class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                    @error('first_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Фамилия -->
                <div class="flex flex-col gap-2">
                    <label for="last_name" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Фамилия') }}</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                           placeholder="Введите фамилию"
                           class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                    @error('last_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Должность -->
                <div class="flex flex-col gap-2">
                    <label for="position" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Должность') }}</label>
                    <input type="text" name="position" id="position" value="{{ old('position') }}" required
                           placeholder="Введите должность"
                           class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                    @error('position')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Заработная плата -->
                <div class="flex flex-col gap-2">
                    <label for="salary" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Заработная плата') }}</label>
                    <input type="number" step="0.01" name="salary" id="salary" value="{{ old('salary') }}" required
                           placeholder="Введите заработную плату"
                           class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                    @error('salary')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Дата найма -->
                <div class="flex flex-col gap-2">
                    <label for="hire_date" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Дата найма') }}</label>
                    <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date') }}" required
                           class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 transition-all duration-300">
                    @error('hire_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Департамент -->
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

                <!-- Паспорт -->
                <div class="flex flex-col gap-2">
                    <label for="passport_number" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Номер паспорта') }}</label>
                    <input type="text" name="passport_number" id="passport_number" value="{{ old('passport_number') }}"
                           placeholder="Введите номер паспорта"
                           class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                    @error('passport_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- ИНН -->
                <div class="flex flex-col gap-2">
                    <label for="inn" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ИНН') }}</label>
                    <input type="text" name="inn" id="inn" value="{{ old('inn') }}"
                           placeholder="Введите ИНН"
                           class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300">
                    @error('inn')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Аватар -->
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Фото сотрудника') }}</label>
                    <div class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300
                                border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700"
                         @dragover.prevent="dragging=true"
                         @dragleave.prevent="dragging=false"
                         @drop.prevent="handleAvatarDrop($event)"
                         :class="{'border-gray-500 bg-gray-100 dark:bg-gray-700': dragging}">
                        <input type="file" id="avatar_url" name="avatar_url" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="previewAvatar($event)">
                        <div class="flex flex-col items-center justify-center text-center" x-show="!avatar">
                            <x-icon.file-upload-icon/>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Перетащите фото сюда или нажмите для выбора файла</p>
                        </div>
                        <template x-if="avatar">
                            <div class="relative">
                                <img :src="avatar" class="w-32 h-32 object-cover rounded-lg shadow">
                                <button type="button" @click="removeAvatar">&times;</button>
                            </div>
                        </template>
                    </div>
                    @error('avatar_url')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Копия паспорта -->
                <div class="flex flex-col gap-2">
                    <label for="passport_copy" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Копия паспорта') }}</label>
                    <input type="file" name="passport_copy" id="passport_copy"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    @error('passport_copy')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Множественные файлы -->
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label for="files" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Загрузить файлы') }}</label>
                    <input type="file" name="files[]" id="files" multiple class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" @change="previewFiles($event)">
                    <div class="flex flex-wrap gap-2 mt-2">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="relative w-24 h-24 border border-gray-300 rounded-lg overflow-hidden">
                                <img :src="file.preview" class="w-full h-full object-cover">
                                <button type="button" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-700" @click="removeFile(index)">&times;</button>
                            </div>
                        </template>
                    </div>
                    @error('files.*')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>


                <!-- Buttons -->
                <div class="flex gap-3 mt-4 md:col-span-2">
                    <button type="submit" class="px-6 py-2 bg-gray-600 dark:bg-gray-700 hover:bg-gray-500 dark:hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition-all duration-200">{{ __('Сохранить') }}</button>
                    <a href="{{ route('admin.employees.index') }}" class="px-6 py-2 border border-gray-400 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">{{ __('Отмена') }}</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function employeeForm() {
            return {
                avatar: null,
                dragging: false,
                files: [],

                // Превью аватара
                previewAvatar(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = e => { this.avatar = e.target.result; };
                    reader.readAsDataURL(file);
                },

                // Удалить аватар
                removeAvatar() {
                    this.avatar = null;
                    document.getElementById('avatar_url').value = '';
                },

                // Drag & Drop аватара
                handleAvatarDrop(event) {
                    const file = event.dataTransfer.files[0];
                    document.getElementById('avatar_url').files = event.dataTransfer.files;
                    this.previewAvatar({ target: { files: [file] } });
                    this.dragging = false;
                },

                // Превью и добавление множественных файлов
                previewFiles(event) {
                    const selectedFiles = Array.from(event.target.files);

                    selectedFiles.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = e => {
                            this.files.push({ file, preview: e.target.result });
                            this.updateInputFiles();
                        };
                        reader.readAsDataURL(file);
                    });
                },

                // Удаление файла
                removeFile(index) {
                    this.files.splice(index, 1);
                    this.updateInputFiles();
                },

                // Синхронизация input.files с массивом this.files
                updateInputFiles() {
                    const dt = new DataTransfer();
                    this.files.forEach(f => dt.items.add(f.file));
                    document.getElementById('files').files = dt.files;
                }
            }
        }
    </script>
</x-layouts.app>
