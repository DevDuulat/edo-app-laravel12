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
                        <div x-data="{
    title: '',
    slug: '',
    cyrillicMap: {
        'а':'a','б':'b','в':'v','г':'g','д':'d','е':'e','ё':'e','ж':'zh','з':'z','и':'i','й':'y',
        'к':'k','л':'l','м':'m','н':'n','о':'o','п':'p','р':'r','с':'s','т':'t','у':'u','ф':'f',
        'х':'h','ц':'ts','ч':'ch','ш':'sh','щ':'sch','ъ':'','ы':'y','ь':'','э':'e','ю':'yu','я':'ya'
    },
    generateSlug() {
        let text = this.title.toLowerCase();

        // Транслитерация
        text = text.split('').map(char => this.cyrillicMap[char] ?? char).join('');

        // Удаляем недопустимые символы, заменяем пробелы на дефисы
        this.slug = text
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, ''); // удаляем дефисы в начале и конце
    }
}">
                        <flux:field>
                            <flux:label>Название документа</flux:label>
                            <flux:description>Введите название документа</flux:description>
                            <flux:input  x-model="title" @input="generateSlug()"  name="title" placeholder="Введите название документа" required />
                            <flux:error name="title" class="mt-1 text-sm text-red-600" />
                        </flux:field>

                        <flux:separator class="my-5" />

                        <flux:field>
                            <flux:label>Ссылка документа</flux:label>
                            <flux:input  x-model="slug"  name="slug" placeholder="Введите уникальный slug" class="w-full" />
                            <flux:error name="slug" class="mt-1 text-sm text-red-600" />
                        </flux:field>
                        </div>

                        <flux:separator class="my-5" />

                        <!-- WYSIWYG редактор -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Содержимое шаблона</label>
                            <div class="w-full border border-gray-200 rounded-lg bg-white overflow-hidden">
                                <x-editor-toolbar />

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
                        <flux:select wire:model="status" placeholder="Выберите статус...">
                            @foreach(\App\Enums\Status::cases() as $status)
                                <flux:select.option value="{{ $status->slug() }}">
                                    {{ $status->label() }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>


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
