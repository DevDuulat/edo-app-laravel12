<x-layouts.app :title="__('Шаблоны')">
    @once
        @vite('resources/css/editor.css')
    @endonce
    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}

    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">

        @if(session('alert'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-4">
                <x-alerts.alert :type="session('alert.type')" :message="session('alert.message')" />
            </div>
        @endif

        <h3 class="mb-2 text-2xl leading-none tracking-tight text-center text-gray-900">
            {{ __('Создание шаблона документа') }}
        </h3>

        <div class="px-5 py-5 rounded-xl border border-gray-200 bg-white max-w-5xl mx-auto w-full shadow-lg">
            <form id="templateForm" action="{{ route('admin.document-templates.store') }}" method="POST" class="grid gap-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    {{-- Название шаблона --}}
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="name" class="text-sm font-medium text-gray-900">{{ __('Название шаблона') }}</label>
                        <input
                                type="text"
                                name="name"
                                id="name"
                                placeholder="Введите название шаблона"
                                required
                                class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300"
                                value="{{ old('name') }}"
                        >
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-gray-900">{{ __('Статус') }}</label>
                        <div class="flex gap-2 flex-wrap h-full">
                            @foreach (\App\Enums\ActiveStatus::cases() as $status)
                                <label class="flex-1 flex items-center justify-center space-x-1 rounded-lg border border-gray-300 p-2 bg-white hover:bg-gray-50 transition cursor-pointer has-[:checked]:border-gray-900 has-[:checked]:bg-gray-50 text-sm h-full">
                                    <input
                                            type="radio"
                                            name="active"
                                            value="{{ $status->value }}"
                                            class="h-4 w-4 text-black accent-gray-900 focus:ring-gray-900 cursor-pointer"
                                            @checked(old('active', \App\Enums\ActiveStatus::active->value) == $status->value)
                                    >
                                    <span class="text-gray-900">{{ $status->label() }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('active')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-2">
                    <label class="text-sm font-medium text-gray-900">{{ __('Содержимое шаблона') }}</label>
                    <div class="w-full border border-gray-300 rounded-lg bg-white shadow-sm overflow-hidden">
                        <x-editor-toolbar />
                        <div class="px-4 py-2 bg-white">
                            <div id="wysiwyg-example"
                                 class="editor-content w-full min-h-[300px] bg-white focus:outline-none">
                            </div>
                            <input type="hidden" name="content" id="contentInput" value="{{ old('content') }}">
                            @error('content')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-4">
                    <button type="submit" class="px-6 py-2 bg-black hover:bg-gray-800 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                        {{ __('Сохранить шаблон') }}
                    </button>
                    <a href="{{ route('admin.document-templates.index') }}" class="px-6 py-2 border border-gray-400 text-gray-900 rounded-lg hover:bg-gray-100 transition-all duration-200">
                        {{ __('Отмена') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

        <script>
            window.editorContent = {!! json_encode(old('content', $template->content ?? '<p>Начните вводить текст здесь...</p>')) !!};
        </script>
        @vite('resources/js/editor.js')
</x-layouts.app>