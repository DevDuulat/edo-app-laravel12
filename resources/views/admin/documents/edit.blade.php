<x-layouts.app :title="__('Редактировать Документ')">
    <div x-data="documentForm({{ $templates->toJson() }}, {{ $document->template_id ?? 'null' }})">

        {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}

        <form method="POST" action="{{ route('admin.documents.update', $document->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="col-span-1 lg:col-span-8 space-y-6">
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-5">
                        <flux:field>
                            <flux:label>Название документа</flux:label>
                            <flux:input name="title" value="{{ old('title', $document->title) }}" required />
                            <flux:error name="title" class="mt-1 text-sm text-red-600" />
                        </flux:field>

                        <flux:separator class="my-5" />

                        <flux:field>
                            <flux:label>URL (slug)</flux:label>
                            <flux:input name="slug" value="{{ old('slug', $document->slug) }}" />
                            <flux:error name="slug" class="mt-1 text-sm text-red-600" />
                        </flux:field>

                        <flux:separator class="my-5" />

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Содержимое шаблона</label>
                            <div class="w-full border border-gray-200 rounded-lg bg-white overflow-hidden">
                                <x-editor-toolbar />

                                <div id="wysiwyg-example"
                                     class="editor-content w-full min-h-[400px] p-4 bg-white rounded-b-lg focus:outline-none"
                                     contenteditable="true"
                                     @input="editorContent = $event.target.innerHTML">{!! old('content', $document->content) !!}</div>
                                <input type="hidden" name="content" x-model="editorContent">
                                @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <flux:separator class="my-5" />

                        <flux:field>
                            <flux:label>Описание</flux:label>
                            <flux:textarea name="comment" rows="3">{{ old('comment', $document->comment) }}</flux:textarea>
                            <flux:error name="comment" class="mt-1 text-sm text-red-600" />
                        </flux:field>
                    </div>
                </div>

                <div class="col-span-1 lg:col-span-4 space-y-6">
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Статус</h3>
                        <select name="status" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="draft" {{ $document->status === 'draft' ? 'selected' : '' }}>Черновик</option>
                            <option value="published" {{ $document->status === 'published' ? 'selected' : '' }}>Опубликован</option>
                        </select>
                        <flux:button type="submit" variant="primary" class="w-full mt-4">Обновить документ</flux:button>
                    </div>

                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Шаблон документа</h3>
                        <select id="template"
                                x-model="selectedTemplate"
                                @change="applyTemplateContent"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                name="template_id">
                            <option value="">— Не выбран —</option>
                            <template x-for="template in templates" :key="template.id">
                                <option :value="template.id" x-text="template.name"></option>
                            </template>
                        </select>

                    </div>

                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-4">
                        <flux:input
                                type="date"
                                name="due_date"
                                value="{{ old('due_date', optional($document->due_date ? \Illuminate\Support\Carbon::parse($document->due_date) : null)->format('Y-m-d')) }}"
                                label="Срок выполнения"
                                required
                        />

                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function documentForm(templates = [], selectedId = null) {
            return {
                templates,
                selectedTemplate: selectedId,
                editorContent: '',

                applyTemplateContent() {
                    const editor = document.getElementById('wysiwyg-example');

                    if (!this.selectedTemplate) {
                        this.editorContent = '';
                        if (editor) editor.innerHTML = '';
                        return;
                    }

                    const selected = this.templates.find(t => t.id == this.selectedTemplate);
                    if (selected) {
                        this.editorContent = selected.content || '';
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


</x-layouts.app>
