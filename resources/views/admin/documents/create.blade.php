<x-layouts.app :title="__('Создать Документ')">
    <style>
        .editor-content .ProseMirror {
            min-height: 400px;
            outline: none;
            padding: 0.5rem;
        }

        .editor-content .ProseMirror:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
        }

        .editor-content .ProseMirror p {
            margin-bottom: 0.75rem;
            line-height: 1.6;
        }

        .editor-content .ProseMirror img {
            max-width: 100%;
            border-radius: 0.5rem;
        }

        .editor-content .ProseMirror blockquote {
            border-left: 4px solid #d1d5db;
            padding-left: 1rem;
            color: #4b5563;
            font-style: italic;
            margin: 1rem 0;
        }

        .editor-content .ProseMirror pre {
            background: #f9fafb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-family: monospace;
            font-size: 0.875rem;
        }

        .editor-toolbar {
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
            border-bottom: 1px solid #e5e7eb;
        }
    </style>

    <div x-data="documentForm({{ $templates->toJson() }})">
        <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" />
            <flux:breadcrumbs.item href="{{ route('admin.documents.index') }}">Документы</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Создание Документа</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <form method="POST" action="{{ route('admin.documents.store') }}">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="col-span-1 lg:col-span-8 space-y-6">
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-5">

                        <flux:field>
                            <flux:label>Название документа</flux:label>
                            <flux:description>Введите название документа</flux:description>
                            <flux:input name="title" placeholder="Введите название документа" required />
                            <flux:error name="title" class="mt-1 text-sm text-red-600" />
                        </flux:field>

                        <flux:separator class="my-5" />

                        <flux:field>
                            <flux:label>URL (slug)</flux:label>
                            <flux:description>Введите уникальный slug</flux:description>
                            <flux:input name="slug" placeholder="Введите уникальный slug" class="w-full" />
                            <flux:error name="slug" class="mt-1 text-sm text-red-600" />
                        </flux:field>

                        <flux:separator class="my-5" />

                        <!-- WYSIWYG редактор -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Содержимое шаблона</label>
                            <div class="w-full border border-gray-200 rounded-lg bg-white overflow-hidden">
                                <div class="editor-toolbar px-3 py-2 border-b border-gray-200">
                                    <div class="flex flex-wrap items-center gap-1">
                                        <div class="flex items-center space-x-1 rtl:space-x-reverse flex-wrap">
                                            <button id="toggleBoldButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Жирный">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5h4.5a3.5 3.5 0 1 1 0 7H8m0-7v7m0-7H6m2 7h6.5a3.5 3.5 0 1 1 0 7H8m0-7v7m0 0H6"/>
                                                </svg>
                                            </button>
                                            <button id="toggleItalicButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Курсив">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.874 19 6.143-14M6 19h6.33m-.66-14H18"/>
                                                </svg>
                                            </button>
                                            <button id="toggleUnderlineButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Подчеркивание">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 19h12M8 5v9a4 4 0 0 0 8 0V5M6 5h4m4 0h4"/>
                                                </svg>
                                            </button>
                                            <button id="toggleStrikeButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Зачеркивание">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 6.2V5h12v1.2M7 19h6m.2-14-1.677 6.523M9.6 19l1.029-4M5 5l6.523 6.523M19 19l-7.477-7.477"/>
                                                </svg>
                                            </button>

                                            <div class="w-px h-4 bg-gray-300 mx-1"></div>

                                            <button id="toggleLeftAlignButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Выравнивание по левому краю">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6h8m-8 4h12M6 14h8m-8 4h12"/>
                                                </svg>
                                            </button>
                                            <button id="toggleCenterAlignButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Выравнивание по центру">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h8M6 10h12M8 14h8M6 18h12"/>
                                                </svg>
                                            </button>
                                            <button id="toggleRightAlignButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Выравнивание по правому краю">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6h-8m8 4H6m12 4h-8m8 4H6"/>
                                                </svg>
                                            </button>

                                            <div class="w-px h-4 bg-gray-300 mx-1"></div>

                                            <button id="toggleListButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Маркированный список">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
                                                </svg>
                                            </button>
                                            <button id="toggleOrderedListButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Нумерованный список">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h8m-8 6h8m-8 6h8M4 16a2 2 0 1 1 3.321 1.5L4 20h5M4 5l2-1v6m-2 0h4"/>
                                                </svg>
                                            </button>

                                            <div class="w-px h-4 bg-gray-300 mx-1"></div>

                                            <button id="addImageButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Добавить изображение">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M13 10a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H14a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12c0 .556-.227 1.06-.593 1.422A.999.999 0 0 1 20.5 20H4a2.002 2.002 0 0 1-2-2V6Zm6.892 12 3.833-5.356-3.99-4.322a1 1 0 0 0-1.549.097L4 12.879V6h16v9.95l-3.257-3.619a1 1 0 0 0-1.557.088L11.2 18H8.892Z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>

                                            <button id="toggleLinkButton" type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 transition" title="Добавить ссылку">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-2 bg-white">
                                    <div id="wysiwyg-example"
                                         class="editor-content w-full min-h-[400px] p-4 bg-white rounded-b-lg focus:outline-none"
                                         contenteditable="true"
                                         @input="editorContent = $event.target.innerHTML">
                                    </div>
                                    <input type="hidden" name="content" x-model="editorContent">
                                    @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <flux:separator class="my-5" />

                        <flux:field>
                            <flux:label>Описание</flux:label>
                            <flux:description>Краткое описание документа</flux:description>
                            <flux:textarea name="comment" placeholder="Введите описание" rows="3"
                                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring focus:ring-blue-100 resize-none" />
                            <flux:error name="comment" class="mt-1 text-sm text-red-600" />
                        </flux:field>
                    </div>
                </div>

                <div class="col-span-1 lg:col-span-4 space-y-6">
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Статус</h3>
                        <select name="status" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="draft">Черновик</option>
                            <option value="published">Опубликован</option>
                        </select>
                        <flux:button type="submit" variant="primary" class="w-full mt-4">Сохранить документ</flux:button>
                    </div>

                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Шаблон документа</h3>
                        <select id="template" x-model="selectedTemplate" @change="applyTemplateContent"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">— Не выбран —</option>
                            <template x-for="template in templates" :key="template.id">
                                <option :value="template.id" x-text="template.name"></option>
                            </template>
                        </select>
                    </div>

                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-4">
                        <flux:input type="date" name="due_date" label="Срок выполнения" required />
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function documentForm(templates = []) {
            return {
                templates,
                selectedTemplate: '',
                editorContent: '',

                applyTemplateContent() {
                    const selected = this.templates.find(t => t.id == this.selectedTemplate);
                    if (selected) {
                        this.editorContent = selected.content || '';
                        const editor = document.getElementById('wysiwyg-example');
                        if (editor) editor.innerHTML = this.editorContent;
                    }
                }
            };
        }

        document.addEventListener('DOMContentLoaded', function () {
            const editor = document.getElementById('wysiwyg-example');

            const commands = {
                toggleBoldButton: 'bold',
                toggleItalicButton: 'italic',
                toggleUnderlineButton: 'underline',
                toggleStrikeButton: 'strikeThrough',
                toggleLeftAlignButton: 'justifyLeft',
                toggleCenterAlignButton: 'justifyCenter',
                toggleRightAlignButton: 'justifyRight',
                toggleListButton: 'insertUnorderedList',
                toggleOrderedListButton: 'insertOrderedList'
            };

            Object.keys(commands).forEach(id => {
                const btn = document.getElementById(id);
                if (btn) {
                    btn.addEventListener('click', () => {
                        document.execCommand(commands[id], false, null);
                        editor.focus();
                    });
                }
            });

            editor.addEventListener('input', () => {
                document.querySelector('input[name="content"]').value = editor.innerHTML;
            });
        });

    </script>

    @vite('resources/js/document-create-templates-editor.js')
</x-layouts.app>
