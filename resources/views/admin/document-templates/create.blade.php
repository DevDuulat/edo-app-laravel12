<x-layouts.app :title="__('Шаблоны')">
    <style>
        .editor-content .ProseMirror {
            min-height: 400px;
            outline: none;
            padding: 1rem;
        }

        .editor-content .ProseMirror:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px #3b82f6;
        }

        .editor-content .ProseMirror p {
            margin-bottom: 1rem;
            line-height: 1.75;
        }

        .editor-content .ProseMirror img {
            max-width: 100%;
            border-radius: 0.5rem;
        }

        .editor-content .ProseMirror blockquote {
            border-left: 4px solid #d1d5db;
            padding-left: 1.25rem;
            color: #4b5563;
            font-style: italic;
            margin: 1.25rem 0;
        }

        .editor-content .ProseMirror pre {
            background: #f9fafb;
            border-radius: 0.5rem;
            padding: 1rem;
            font-family: monospace;
            font-size: 0.875rem;
            overflow-x: auto;
        }

        /* Панель инструментов */
        .editor-toolbar {
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.5rem 1rem;
        }

        /* Глобальные отступы */
        .content-wrapper {
            padding: 2rem 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .content-wrapper {
                padding: 2rem 2rem;
            }
        }

        /* Кнопки формы */
        .form-actions button,
        .form-actions a {
            min-width: 120px;
        }
    </style>

    <div class="content-wrapper">
        @if(session('alert'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6">
                <x-alerts.alert :type="session('alert.type')" :message="session('alert.message')" />
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Шаблоны документов</h1>
                <p class="text-gray-600 mt-2 text-base md:text-lg">Создавайте и управляйте шаблонами документов для быстрого создания контента</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-900">Создать новый шаблон</h2>
                <p class="text-sm text-gray-600 mt-1">Заполните форму, чтобы добавить новый шаблон документа</p>
            </div>

            <form id="templateForm" action="{{ route('admin.document-templates.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Название шаблона</label>
                        <input
                                type="text"
                                name="name"
                                id="name"
                                placeholder="Введите название шаблона"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                value="{{ old('name') }}"
                        >
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Статус</label>
                        <div class="flex gap-3 flex-wrap">
                            @foreach (\App\Enums\ActiveStatus::cases() as $status)
                                <label class="flex-1 flex items-center justify-center space-x-2 rounded-lg border border-gray-200 p-3 bg-white hover:bg-gray-50 transition cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-700">
                                    <input
                                            type="radio"
                                            name="active"
                                            value="{{ $status->value }}"
                                            class="h-4 w-4 text-blue-600 accent-blue-500 focus:ring-blue-500 cursor-pointer"
                                            @checked(old('active', \App\Enums\ActiveStatus::active->value) == $status->value)
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
                        <x-editor-toolbar />
                        <div class="px-4 py-3 bg-white">
                            <div id="wysiwyg-example"
                                 class="editor-content w-full min-h-[400px] bg-white rounded-b-lg focus:outline-none">
                            </div>
                            <input type="hidden" name="content" id="contentInput" value="{{ old('content') }}">
                            @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200 form-actions">
                    <a href="{{ route('admin.document-templates.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Отмена
                    </a>
                    <flux:button
                            type="submit"
                            wire:click="save"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
                    >
                        Сохранить шаблон
                    </flux:button>
                </div>
            </form>
        </div>
    </div>

    @vite('resources/js/document-create-templates-editor.js')
</x-layouts.app>
