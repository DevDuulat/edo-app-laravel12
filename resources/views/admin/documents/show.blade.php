<x-layouts.app :title="__('Просмотр Документа')">

    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" />
        <flux:breadcrumbs.item href="{{ route('admin.documents.index') }}">Документы</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Просмотр документа</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <div class="col-span-1 lg:col-span-8 space-y-6">
            <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-5">

                <flux:field>
                    <flux:label>Название документа</flux:label>
                    <div class="text-gray-700">{{ $document->title }}</div>
                </flux:field>

                <flux:separator class="my-5" />

                <flux:field>
                    <flux:label>URL (slug)</flux:label>
                    <div class="text-gray-700">{{ $document->slug }}</div>
                </flux:field>

                <flux:separator class="my-5" />

                <flux:field>
                    <flux:label>Содержимое шаблона</flux:label>
                    <div class="w-full border border-gray-200 rounded-lg bg-white p-4 min-h-[400px] overflow-auto">
                        {!! $document->content !!}
                    </div>
                </flux:field>

                <flux:separator class="my-5" />

                <flux:field>
                    <flux:label>Описание</flux:label>
                    <div class="text-gray-700">{{ $document->comment }}</div>
                </flux:field>

            </div>
        </div>

        <div class="col-span-1 lg:col-span-4 space-y-6">

            <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-4">
                <flux:field>
                    <flux:label>Статус</flux:label>
                    <div class="text-gray-700">{{ ucfirst($document->status) }}</div>
                </flux:field>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-4">
                <flux:field>
                    <flux:label>Шаблон документа</flux:label>
                    <div class="text-gray-700">{{ $document->template?->name ?? '— Не выбран —' }}</div>
                </flux:field>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 p-4">
                <flux:field>
                    <flux:label>Срок выполнения</flux:label>
                    <div class="text-gray-700">
                        {{ $document->due_date ? \Illuminate\Support\Carbon::parse($document->due_date)->format('Y-m-d') : '— Не указан —' }}
                    </div>
                </flux:field>
            </div>

        </div>
    </div>

</x-layouts.app>
