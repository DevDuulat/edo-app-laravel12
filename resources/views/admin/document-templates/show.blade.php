<x-layouts.app :title="$documentTemplate->name">
    <div class="max-w-5xl mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center justify-between">
                <!-- Breadcrumb -->

                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{route('dashboard')}}" icon="home" />
                    <flux:breadcrumbs.item href="{{route('admin.document-templates.index')}}">Шаблоны</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>   {{ $documentTemplate->name }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>



            </div>


            <div class="flex items-center gap-2">
                <span class="px-3 py-1 text-sm rounded-full
                    {{ $documentTemplate->active ? 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-100' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                    {{ $documentTemplate->active ? 'Активен' : 'Не активен' }}
                </span>
            </div>
        </div>

        <!-- Контент шаблона -->
        <div class="flowbite-typography border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-900 shadow-sm">
            @if($documentTemplate->content)
                {!! $documentTemplate->content !!}
            @else
                <p class="text-gray-500 italic">Контент шаблона пока не добавлен.</p>
            @endif
        </div>

    </div>
</x-layouts.app>
