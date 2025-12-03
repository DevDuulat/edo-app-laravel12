<x-layouts.app :title="__('Шаблоны')">
    <style>
        .editor-content .ProseMirror {
            min-height: 300px; /* уменьшено для мобильных */
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
            overflow-x: auto;
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
    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}

    @if(session('alert'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-4 md:mb-6">
            <x-alerts.alert :type="session('alert.type')" :message="session('alert.message')" />
        </div>
    @endif


    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 md:mb-8 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-4 md:px-6 py-3 md:py-4">
            <h2 class="text-lg md:text-xl font-semibold text-gray-900">
                @isset($template)
                    Редактирование шаблона
                @else
                    Создать новый шаблон
                @endisset
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                @isset($template)
                    Измените данные шаблона документа
                @else
                    Заполните форму, чтобы добавить новый шаблон документа
                @endisset
            </p>
        </div>

        <form id="templateForm"
              action="@isset($template) {{ route('admin.document-templates.update', $template) }} @else {{ route('admin.document-templates.store') }} @endisset"
              method="POST"
              class="px-4 md:px-6 py-4 md:py-6 space-y-4 md:space-y-6">
            @csrf
            @isset($template)
                @method('PUT')
            @endisset

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1 md:mb-2">Название шаблона</label>
                    <input
                            type="text"
                            name="name"
                            id="name"
                            placeholder="Введите название шаблона"
                            required
                            class="w-full px-3 py-2 md:px-4 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm md:text-base"
                            value="{{ old('name', $template->name ?? '') }}"
                    >
                    @error('name')
                    <p class="mt-1 text-xs md:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 md:mb-2">Статус</label>
                    <div class="flex gap-2 md:gap-3 flex-wrap">
                        @foreach (\App\Enums\ActiveStatus::cases() as $status)
                            <label class="flex-1 flex items-center justify-center space-x-1 md:space-x-2 rounded-lg border border-gray-200 p-2 md:p-3 bg-white hover:bg-gray-50 transition cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-700 text-xs md:text-sm">
                                <input
                                        type="radio"
                                        name="active"
                                        value="{{ $status->value }}"
                                        class="h-3 w-3 md:h-4 md:w-4 text-blue-600 accent-blue-500 focus:ring-blue-500 cursor-pointer"
                                        @checked(old('active', $template->active->value ?? \App\Enums\ActiveStatus::active->value) == $status->value)
                                >
                                <span>{{ $status->label() }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('active')
                    <p class="mt-1 text-xs md:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 md:mb-2">Содержимое шаблона</label>
                <div class="w-full border border-gray-200 rounded-lg bg-white overflow-hidden">
                    <div class="editor-toolbar px-2 py-2 md:px-3 md:py-2 border-b border-gray-200 overflow-x-auto flex flex-wrap gap-1">
                        <x-editor-toolbar />
                    </div>
                    <div class="px-2 py-2 md:px-4 md:py-3 bg-white">
                        <div id="wysiwyg-example"
                             class="editor-content w-full min-h-[300px] p-2 md:p-4 bg-white rounded-b-lg focus:outline-none">
                        </div>
                        <input type="hidden" name="content" id="contentInput" value="{{ old('content', $template->content ?? '') }}">
                        @error('content')
                        <p class="mt-1 text-xs md:text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-end space-y-2 md:space-y-0 md:space-x-3 pt-4 md:pt-5 border-t border-gray-200">
                <a href="{{ route('admin.document-templates.index') }}" class="px-3 py-2 md:px-4 md:py-2 text-sm md:text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 text-center transition">
                    Отмена
                </a>

                <flux:button
                        type="submit"
                        class="px-3 py-2 md:px-4 md:py-2 text-sm md:text-base font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition text-center"
                >
                    @isset($template)
                        Обновить шаблон
                    @else
                        Сохранить шаблон
                    @endisset
                </flux:button>

            </div>
        </form>
    </div>

    <script>
        window.editorContent = {!! json_encode(old('content', $template->content ?? '<p>Начните вводить текст здесь...</p>')) !!};
    </script>
    @vite('resources/js/document-edit-templates-editor.js')
</x-layouts.app>
