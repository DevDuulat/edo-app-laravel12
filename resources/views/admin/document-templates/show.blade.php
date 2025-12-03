<x-layouts.app :title="$documentTemplate->name">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-6 gap-2 md:gap-0">
            {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}

            <span class="px-3 py-1 text-sm rounded-full mt-2 md:mt-0
                {{ $documentTemplate->active
                    ? 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-100'
                    : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                {{ $documentTemplate->active ? 'Активен' : 'Не активен' }}
            </span>
        </div>

        <div class="flowbite-typography border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 md:p-6 bg-white dark:bg-zinc-900 shadow-sm overflow-x-auto">
            @if($documentTemplate->content)
                {!! $documentTemplate->content !!}
            @else
                <p class="text-gray-500 italic">Контент шаблона пока не добавлен.</p>
            @endif
        </div>
    </div>
</x-layouts.app>
