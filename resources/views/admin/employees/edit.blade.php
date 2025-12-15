<x-layouts.app :title="__('Редактировать Сотрудника')">
    {{ Breadcrumbs::render(
       Route::currentRouteName(),
       ...array_values(Route::current()->parameters())
   ) }}
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">

        <div class="max-w-5xl mx-auto w-full">
            <div class="flex items-center justify-between">
                <h3 class="mb-2 text-2xl leading-none tracking-tight text-center text-gray-900 md:text-2xl">
                    Редактирование сотрудника
                </h3>
            </div>
        </div>

        <div class="px-5 py-5 rounded-xl border border-gray-200 bg-white max-w-5xl mx-auto w-full shadow-lg">
                <form method="POST" action="{{ route('admin.employees.update', $employee) }}" enctype="multipart/form-data" class="grid gap-5 md:grid-cols-2" x-data="employeeForm()">

                @csrf
                @method('PUT')

                <div class="flex flex-col gap-2">
                    <label for="first_name" class="text-sm font-medium text-gray-900">Имя</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $employee->first_name) }}" required
                           placeholder="Введите имя"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('first_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="last_name" class="text-sm font-medium text-gray-900">Фамилия</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $employee->last_name) }}" required
                           placeholder="Введите фамилию"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('last_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="position" class="text-sm font-medium text-gray-900">Должность</label>
                    <input type="text" name="position" id="position" value="{{ old('position', $employee->position) }}" required
                           placeholder="Введите должность"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('position')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="salary" class="text-sm font-medium text-gray-900">Заработная плата</label>
                    <input type="number" step="0.01" name="salary" id="salary" value="{{ old('salary', $employee->salary) }}" required
                           placeholder="Введите заработную плату"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('salary')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="hire_date" class="text-sm font-medium text-gray-900">Дата найма</label>
                    <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date', $employee->hire_date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-300">
                    @error('hire_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="department_id" class="text-sm font-medium text-gray-900">Департамент</label>
                    <select name="department_id" id="department_id" required
                            class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-300">
                        <option value="">Выберите департамент</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="passport_number" class="text-sm font-medium text-gray-900">Номер паспорта</label>
                    <input type="text" name="passport_number" id="passport_number" value="{{ old('passport_number', $employee->passport_number) }}"
                           placeholder="Введите номер паспорта"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('passport_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="inn" class="text-sm font-medium text-gray-900">ИНН</label>
                    <input type="text" name="inn" id="inn" value="{{ old('inn', $employee->inn) }}"
                           placeholder="Введите ИНН"
                           class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300">
                    @error('inn')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2 md:col-span-2" x-data="avatarPreview('{{ asset('storage/' . $employee->avatar_url) }}')">
                    <label>Фото сотрудника</label>
                    <div @dragover.prevent="dragOver=true" @dragleave.prevent="dragOver=false"
                         @drop.prevent="handleDrop($event)"
                         :class="dragOver ? 'border-gray-600 bg-gray-100' : 'border-gray-400 bg-gray-50'"
                         class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300 bg-white hover:bg-gray-100">
                        <input type="file" name="avatar_url" accept="image/*" @change="previewFile($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <template x-if="preview">
                            <div class="relative">
                                <img :src="preview" class="w-32 h-32 object-cover rounded-lg shadow">
                                <button type="button" @click="clear" class="absolute -top-2 -right-2 bg-black text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-gray-800">&times;</button>
                            </div>
                        </template>
                        <template x-if="!preview && existing">
                            <img :src="existing" class="w-32 h-32 object-cover rounded-lg shadow">
                        </template>
                        <template x-if="!preview && !existing">
                            <p class="text-sm text-gray-500 mt-2">Перетащите фото сюда или нажмите для выбора файла</p>
                        </template>
                        @if($employee->avatar_url)
                            <img src="{{ asset('storage/' . $employee->avatar_url) }}" alt="preview" class="w-32 h-32 object-cover rounded-lg shadow" x-data="{ existing: true }">
                        @endif
                    </div>
                    @error('avatar_url')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-2 md:col-span-2" x-data="passportFilesPreview({{ $passportFilesJson ?? '[]' }})">
                    <label for="passport_copy" class="text-sm font-medium text-gray-900">Копия паспорта</label>
                    <input type="file" name="passport_copy[]" id="passport_copy" accept="image/*" multiple @change="previewFiles($event)"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900">

                    <div class="flex flex-wrap gap-2 mt-2">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="relative w-32 h-32 border border-gray-300 rounded-lg overflow-hidden flex items-center justify-center text-xs text-center p-1">
                                <img :src="file.preview" class="w-full h-full object-cover">
                                <button type="button" @click="removeFile(index)" class="absolute -top-2 -right-2 bg-black text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-gray-800">&times;</button>
                            </div>
                        </template>
                        <div id="passport-gallery" class="pswp-gallery flex flex-wrap gap-2 mt-2">
                            @foreach($passportFiles as $file)
                                <x-file-preview :file="$file" :can-delete="true" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 md:col-span-2" x-data="multiFilesPreview()">
                    <label for="files" class="text-sm font-medium text-gray-900">Загрузить файлы</label>
                    <input type="file" name="files[]" id="files" multiple @change="previewFiles($event)"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900">
                    <div class="flex flex-wrap gap-2 mt-2">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="relative w-24 h-24 border border-gray-300 rounded-lg overflow-hidden flex items-center justify-center text-xs text-center p-1">
                                <img :src="file.preview" class="w-full h-full object-cover">
                                <button type="button" @click="removeFile(index)" class="absolute -top-2 -right-2 bg-black text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-gray-800">&times;</button>
                            </div>
                        </template>
                        <div id="passport-gallery" class="pswp-gallery flex flex-wrap gap-2 mt-2">
                            @foreach($otherFiles as $file)
                                <x-file-preview :file="$file" :can-delete="true" />
                            @endforeach
                        </div>
                    </div>
                    @error('files.*')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex gap-3 mt-4 md:col-span-2">
                    <button type="submit" class="px-6 py-2 bg-black hover:bg-gray-800 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                        Сохранить
                    </button>
                    <a href="{{ route('admin.employees.index') }}" class="px-6 py-2 border border-gray-400 text-gray-900 rounded-lg hover:bg-gray-100 transition-all duration-200">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function employeeForm() {
            return {
                files: [],
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
                removeFile(index) {
                    this.files.splice(index, 1);
                    this.updateInputFiles();
                },
                updateInputFiles() {
                    const dt = new DataTransfer();
                    this.files.forEach(f => dt.items.add(f.file));
                    document.getElementById('files').files = dt.files;
                }
            }
        }
    </script>
    <script>
        function passportFilesPreview(existingFiles = []) {
            return {
                files: existingFiles.map(url => ({ preview: url, file: null })),
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
                removeFile(index) {
                    this.files.splice(index, 1);
                    this.updateInputFiles();
                },
                updateInputFiles() {
                    const dt = new DataTransfer();
                    this.files.forEach(f => {
                        if (f.file) dt.items.add(f.file);
                    });
                    document.getElementById('passport_copy').files = dt.files;
                }
            }
        }
    </script>

    <script>

        function avatarPreview(existingUrl = null) {
            return {
                preview: null,
                existing: existingUrl,
                dragOver: false,
                previewFile(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = e => this.preview = e.target.result;
                    reader.readAsDataURL(file);
                },
                handleDrop(event) {
                    const file = event.dataTransfer.files[0];
                    this.previewFile({ target: { files: [file] } });
                },
                clear() {
                    this.preview = null;
                    this.existing = null;
                    document.querySelector('input[name="avatar_url"]').value = '';
                }
            }
        }

        function multiFilesPreview() {
            return {
                files: [],
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
                removeFile(index) {
                    this.files.splice(index, 1);
                    const input = document.getElementById('files');
                    const dt = new DataTransfer();
                    this.files.forEach(f => dt.items.add(f));
                    input.files = dt.files;
                },
                updateInputFiles() {
                    const dt = new DataTransfer();
                    this.files.forEach(f => dt.items.add(f.file));
                    document.getElementById('files').files = dt.files;
                }
            }
        }

        function filePreview(existing = null) {
            return {
                preview: existing,
                previewFile(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = e => this.preview = e.target.result;
                    reader.readAsDataURL(file);
                },
                clear() {
                    this.preview = null;
                    document.querySelector('input[name="passport_copy"]').value = '';
                }
            }
        }

    </script>

</x-layouts.app>