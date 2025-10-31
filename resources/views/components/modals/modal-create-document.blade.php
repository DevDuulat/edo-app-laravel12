<div id="createDocumentModal" class="hidden fixed inset-0 bg-white/30 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-lg relative border border-gray-200">
        <button id="closeCreateDocumentModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>

        <h2 class="text-xl font-semibold mb-2 text-gray-900">Создать документ</h2>
        <p class="text-gray-600 mb-4">Введите данные для нового документа.</p>

        <form method="POST"
              action="{{ route('admin.documents.store') }}"
              enctype="multipart/form-data"
              class="space-y-4"
              x-data="fileUpload()">
            @csrf
            <input type="hidden" name="folder_id" id="document_folder_id">

            <input type="text" name="title" placeholder="Название документа" required
                   class="w-full px-3 py-2 border rounded-md border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <input type="date" name="due_date" required
                   class="w-full px-3 py-2 border rounded-md border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <textarea name="comment" placeholder="Описание" rows="3"
                      class="w-full px-3 py-2 border rounded-md border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

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
                                <div class="relative flex flex-col items-center w-24 p-2 border border-gray-200 rounded-lg bg-gray-50 shadow-sm">
                                    <template x-if="file.isImage">
                                        <img :src="file.preview" class="w-16 h-16 object-cover rounded-md">
                                    </template>

                                    <template x-if="!file.isImage">
                                        <img :src="file.preview" class="w-10 h-10 mt-2 opacity-80">
                                    </template>

                                    <p class="text-xs text-center text-gray-600 truncate w-full mt-1" x-text="file.name"></p>
                                    <p class="text-[10px] text-gray-400" x-text="file.size"></p>

                                    <button type="button"
                                            @click="removeFile(index)"
                                            class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-700">
                                        &times;
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

            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Создать
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('fileUpload', () => ({
            files: [],
            dragging: false,

            handleFiles(event) {
                const selectedFiles = Array.from(event.target.files);
                this.addFiles(selectedFiles);
            },

            handleDrop(event) {
                const droppedFiles = Array.from(event.dataTransfer.files);
                this.addFiles(droppedFiles);
                this.dragging = false;
            },

            addFiles(newFiles) {
                newFiles.forEach(file => {
                    const reader = new FileReader();

                    reader.onload = e => {
                        const isImage = file.type.startsWith('image/');
                        this.files.push({
                            file,
                            preview: isImage ? e.target.result : this.iconForType(file.type),
                            name: file.name,
                            size: this.formatSize(file.size),
                            isImage
                        });
                        this.updateInput();
                    };

                    if (file.type.startsWith('image/')) {
                        reader.readAsDataURL(file);
                    } else {
                        // Не читаем весь файл для не-изображений, просто добавляем иконку
                        this.files.push({
                            file,
                            preview: this.iconForType(file.type),
                            name: file.name,
                            size: this.formatSize(file.size),
                            isImage: false
                        });
                        this.updateInput();
                    }
                });
            },

            removeFile(index) {
                this.files.splice(index, 1);
                this.updateInput();
            },

            updateInput() {
                const dt = new DataTransfer();
                this.files.forEach(f => dt.items.add(f.file));
                document.getElementById('files').files = dt.files;
            },

            iconForType(type) {
                if (type.includes('pdf')) return '/icons/pdf.svg';
                if (type.includes('word')) return '/icons/doc.svg';
                if (type.includes('excel')) return '/icons/xls.svg';
                if (type.includes('text')) return '/icons/txt.svg';
                return '/icons/file.svg';
            },

            formatSize(bytes) {
                const kb = bytes / 1024;
                if (kb < 1024) return `${kb.toFixed(1)} КБ`;
                return `${(kb / 1024).toFixed(1)} МБ`;
            }
        }));
    });
</script>

