<x-layouts.app :title="__('Шаблоны')">
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

    @if(session('alert'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6">
            <x-alerts.alert :type="session('alert.type')" :message="session('alert.message')" />
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                @isset($template)
                    Редактирование шаблона
                @else
                    Создание шаблона
                @endisset
            </h1>
            <p class="text-gray-600 mt-1">
                @isset($template)
                    Измените данные шаблона документа
                @else
                    Создавайте и управляйте шаблонами документов для быстрого создания контента
                @endisset
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">
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
              class="p-6 space-y-6">
            @csrf
            @isset($template)
                @method('PUT')
            @endisset

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Название шаблона</label>
                    <input
                            type="text"
                            name="name"
                            id="name"
                            placeholder="Введите название шаблона"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            value="{{ old('name', $template->name ?? '') }}"
                    >
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Статус</label>
                    <div class="flex gap-3">
                        @foreach (\App\Enums\ActiveStatus::cases() as $status)
                            <label class="flex-1 flex items-center justify-center space-x-2 rounded-lg border border-gray-200 p-3 bg-white hover:bg-gray-50 transition cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-700">
                                <input
                                        type="radio"
                                        name="active"
                                        value="{{ $status->value }}"
                                        class="h-4 w-4 text-blue-600 accent-blue-500 focus:ring-blue-500 cursor-pointer"
                                        @checked(old('active', $template->active->value ?? \App\Enums\ActiveStatus::active->value) == $status->value)
                                >
                                <span class="text-sm font-medium">{{ $status->label() }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('active')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
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
                             class="editor-content w-full min-h-[400px] p-4 bg-white rounded-b-lg focus:outline-none">
                        </div>
                        <input type="hidden" name="content" id="contentInput" value="{{ old('content', $template->content ?? '') }}">
                        @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200">
                <a href="{{ route('admin.document-templates.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Отмена
                </a>
                <button
                        type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
                >
                    @isset($template)
                        Обновить шаблон
                    @else
                        Сохранить шаблон
                    @endisset
                </button>
            </div>
        </form>
    </div>

    <script>
        window.editorContent = {!! json_encode(old('content', $template->content ?? '<p>Начните вводить текст здесь...</p>')) !!};
    </script>
    @vite('resources/js/document-edit-templates-editor.js')
</x-layouts.app>