<x-layouts.app :title="__('Редактировать департамент')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{route('dashboard')}}" icon="home" />
                <flux:breadcrumbs.item href="{{route('admin.documents.index')}}">Документы</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Редактирование Документа</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <h3 class="mb-2 text-2xl leading-none tracking-tight text-center text-gray-900 md:text-2xl dark:text-white">
            Редактирование документа
        </h3>
        <div class="px-5 py-5 rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <form action="{{ route('admin.departments.update', $document->id) }}" method="POST" class="grid gap-5 max-w-lg">
                @csrf
                @method('PUT')

                <!-- Name Input -->
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Название') }}
                    </label>
                    <input
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title', $document->title) }}"
                            required
                            placeholder="Введите название департамента"
                            class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300"
                    />
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- comment Input -->
                <div class="flex flex-col gap-2">
                    <label for="comment" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Комментарий') }}
                    </label>
                    <input
                            type="text"
                            name="comment"
                            id="comment"
                            value="{{ old('comment', $document->comment) }}"
                            placeholder="Введите локацию"
                            class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300"
                    />
                    @error('comment')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 mt-4">
                    <button type="submit"
                            class="px-6 py-2 bg-gray-600 dark:bg-gray-700 hover:bg-gray-500 dark:hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                        {{ __('Обновить') }}
                    </button>
                    <a href="{{ route('admin.departments.index') }}"
                       class="px-6 py-2 border border-gray-400 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                        {{ __('Отмена') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
