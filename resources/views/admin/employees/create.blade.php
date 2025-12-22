<x-layouts.app :title="__('Создать Сотрудника')">
    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        </div>

        <h3 class="mb-2 text-2xl leading-none tracking-tight text-center text-gray-900">
            Создание сотрудника
        </h3>

        <div class="px-5 py-5 rounded-xl border border-gray-200 bg-white max-w-5xl mx-auto w-full shadow-lg">
            <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data"
                  class="grid gap-5 md:grid-cols-2"
                  x-data="employeeForm()">
                @csrf

                <div class="flex flex-col gap-2">
                    <label for="first_name" class="text-sm font-medium text-gray-900">{{ __('Имя') }}</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                           placeholder="Введите имя"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('first_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="last_name" class="text-sm font-medium text-gray-900">{{ __('Фамилия') }}</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                           placeholder="Введите фамилию"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('last_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="position_id" class="text-sm font-medium text-gray-900">{{ __('Должность') }}</label>

                    <select name="position_id" id="position_id" required
                            class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-300">
                        <option value="" disabled {{ old('position_id') ? '' : 'selected' }}>{{ __('Выберите должность') }}</option>

                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('position_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="salary" class="text-sm font-medium text-gray-900">{{ __('Заработная плата') }}</label>
                    <input type="number" step="0.01" name="salary" id="salary" value="{{ old('salary') }}" required
                           placeholder="Введите заработную плату"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('salary')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="hire_date" class="text-sm font-medium text-gray-900">{{ __('Дата найма') }}</label>
                    <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date') }}" required
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-300">
                    @error('hire_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="department_id" class="text-sm font-medium text-gray-900">{{ __('Департамент') }}</label>
                    <select name="department_id" id="department_id" required
                            class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-300">
                        <option value="">Выберите департамент</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="passport_number" class="text-sm font-medium text-gray-900">{{ __('Номер паспорта') }}</label>
                    <input type="text" name="passport_number" id="passport_number" value="{{ old('passport_number') }}"
                           placeholder="Введите номер паспорта"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('passport_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="inn" class="text-sm font-medium text-gray-900">{{ __('ИНН') }}</label>
                    <input type="text" name="inn" id="inn" value="{{ old('inn') }}"
                           placeholder="Введите ИНН"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('inn')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-sm font-medium text-gray-900">{{ __('Фото сотрудника') }}</label>
                    <div class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300
                    border-gray-400 bg-gray-50 hover:bg-gray-100"
                         @dragover.prevent="dragging=true"
                         @dragleave.prevent="dragging=false"
                         @drop.prevent="handleAvatarDrop($event)"
                         :class="{'border-gray-600 bg-gray-100': dragging}">
                        <input type="file" id="avatar_url" name="avatar_url" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="previewAvatar($event)">
                        <div class="flex flex-col items-center justify-center text-center" x-show="!avatar">
                            <x-icon.file-upload-icon class="w-8 h-8 text-gray-500" />
                            <p class="text-sm text-gray-500 mt-2">Перетащите фото сюда или нажмите для выбора файла</p>
                        </div>
                        <template x-if="avatar">
                            <div class="relative">
                                <img :src="avatar" class="w-32 h-32 object-cover rounded-lg shadow">
                                <button type="button" @click="removeAvatar" class="absolute -top-2 -right-2 bg-black text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-gray-800">&times;</button>
                            </div>
                        </template>
                    </div>
                    @error('avatar_url')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2 md:col-span-2">
                    <label for="passport_copy" class="text-sm font-medium text-gray-900">{{ __('Копия паспорта') }}</label>
                    <input type="file" name="passport_copy[]" multiple id="passport_copy" accept="image/*"
                           @change="handlePassportFiles($event)"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900">
                    @error('passport_copy.*')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror

                    <p id="ocrStatus" class="text-sm text-gray-600 mt-1" x-text="ocrStatus"></p>

                    <div class="flex flex-wrap gap-2 mt-2">
                        <template x-for="(file, index) in passportFiles" :key="index">
                            <div class="relative w-32 h-32 border border-gray-300 rounded-lg overflow-hidden flex items-center justify-center">
                                <img :src="file.preview" class="w-full h-full object-cover">
                                <button type="button" @click="removePassportFile(index)" class="absolute -top-2 -right-2 bg-black text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-gray-800">&times;</button>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex flex-col gap-2 md:col-span-2">
                    <label for="files" class="text-sm font-medium text-gray-900">{{ __('Загрузить файлы') }}</label>
                    <input type="file" name="files[]" id="files" multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900" @change="previewFiles($event)">
                    <div class="flex flex-wrap gap-2 mt-2">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="relative w-24 h-24 border border-gray-300 rounded-lg overflow-hidden">
                                <img :src="file.preview" class="w-full h-full object-cover">
                                <button type="button" class="absolute -top-2 -right-2 bg-black text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-gray-800" @click="removeFile(index)">&times;</button>
                            </div>
                        </template>
                    </div>
                    @error('files.*')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex gap-3 mt-4 md:col-span-2">
                    <button type="submit" class="px-6 py-2 bg-black hover:bg-gray-800 text-white font-semibold rounded-lg shadow-md transition-all duration-200">{{ __('Сохранить') }}</button>
                    <a href="{{ route('admin.employees.index') }}" class="px-6 py-2 border border-gray-400 text-gray-900 rounded-lg hover:bg-gray-100 transition-all duration-200">{{ __('Отмена') }}</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5.0.2/dist/tesseract.min.js"></script>
    <script>
        function employeeForm() {
            return {
                avatar: null,
                dragging: false,
                files: [],
                passportFiles: [],
                ocrStatus: 'Выберите файл(ы) для распознавания',

                previewAvatar(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = e => this.avatar = e.target.result;
                    reader.readAsDataURL(file);
                },

                removeAvatar() {
                    this.avatar = null;
                    document.getElementById('avatar_url').value = '';
                },

                handleAvatarDrop(event) {
                    const file = event.dataTransfer.files[0];
                    document.getElementById('avatar_url').files = event.dataTransfer.files;
                    this.previewAvatar({ target: { files: [file] } });
                    this.dragging = false;
                },

                handlePassportFiles(event) {
                    const selected = Array.from(event.target.files);
                    const passportEl = document.getElementById('passport_number');
                    const innEl = document.getElementById('inn');
                    this.ocrStatus = 'Распознавание...';

                    selected.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = e => {
                            this.passportFiles.push({ file, preview: e.target.result });

                            Tesseract.recognize(file, 'rus+eng+kir')
                                .then(({ data: { text } }) => {
                                    const innMatch = text.match(/\d{14}/);
                                    if (innMatch && !innEl.value) innEl.value = innMatch[0];

                                    const docIdMatch = text.match(/[A-ZА-Я]{2}\d{7}/i);
                                    if (docIdMatch && !passportEl.value) passportEl.value = docIdMatch[0];

                                    this.ocrStatus = 'Распознавание завершено';
                                })
                                .catch(err => {
                                    console.error(err);
                                    this.ocrStatus = 'Ошибка распознавания';
                                });
                        };
                        reader.readAsDataURL(file);
                    });
                },

                removePassportFile(i) {
                    this.passportFiles.splice(i, 1);
                },


                previewFiles(event) {
                    const selected = Array.from(event.target.files);
                    selected.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = e => {
                            this.files.push({ file, preview: e.target.result });
                            this.updateFilesInput();
                        };
                        reader.readAsDataURL(file);
                    });
                },

                removeFile(i) {
                    this.files.splice(i, 1);
                    this.updateFilesInput();
                },

                updateFilesInput() {
                    const dt = new DataTransfer();
                    this.files.forEach(f => dt.items.add(f.file));
                    document.getElementById('files').files = dt.files;
                }
            }
        }
    </script>

</x-layouts.app>