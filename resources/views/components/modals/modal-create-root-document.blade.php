<flux:modal name="create-root-document" class="md:w-96">
    <form action="{{ route('admin.documents.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6"
          x-data="documentForm()">
        @csrf
        <div>
            <flux:heading size="lg">Создать документ</flux:heading>
        </div>

        <flux:input
                name="title"
                label="Название документа"
                placeholder="Введите название документа"
                required
        />

        <flux:input
                type="date"
                name="due_date"
                label="Срок выполнения"
                required
        />

        <flux:textarea
                name="comment"
                label="Описание"
                placeholder="Введите описание"
                rows="3"
        />

        <input type="hidden" name="folder_id" value="{{ $currentFolder->id ?? '' }}">

        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Загрузить файлы
            </label>

            <div class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300
                border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700"
                 @dragover.prevent="dragging=true"
                 @dragleave.prevent="dragging=false"
                 @drop.prevent="handleDrop($event)"
                 :class="{'border-gray-500 bg-gray-100 dark:bg-gray-700': dragging}">

                <input type="file" name="files[]" id="files" multiple
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                       @change="handleFiles($event)">

                <div class="flex flex-col items-center justify-center text-center" x-show="!files.length">
                    <x-icon.file-upload-icon/>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Перетащите файлы сюда или нажмите для выбора
                    </p>
                </div>

                <template x-if="files.length">
                    <div class="flex flex-wrap gap-2 mt-2 justify-center">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="relative w-20 h-20 border border-gray-300 rounded-lg overflow-hidden">
                                <img :src="file.preview" class="w-full h-full object-cover">
                                <button type="button"
                                        @click="removeFile(index)"
                                        class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-700">&times;
                                </button>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            @error('files.*')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <flux:button type="button" modal:close variant="ghost">Отмена</flux:button>
            <flux:button type="submit" variant="primary">Создать</flux:button>
        </div>
    </form>
</flux:modal>

<script>
    function documentForm() {
        return {
            files: [],
            dragging: false,

            handleFiles(event) {
                const selected = Array.from(event.target.files);
                selected.forEach(file => this.previewFile(file));
            },

            handleDrop(event) {
                const dropped = Array.from(event.dataTransfer.files);
                dropped.forEach(file => this.previewFile(file));
                this.dragging = false;
                this.updateFilesInput();
            },

            previewFile(file) {
                const reader = new FileReader();
                reader.onload = e => {
                    this.files.push({ file, preview: e.target.result });
                    this.updateFilesInput();
                };
                reader.readAsDataURL(file);
            },

            removeFile(index) {
                this.files.splice(index, 1);
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
