<x-layouts.app :title="__('Просмотр Документа')">

    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}

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
                    <flux:label>Файлы документа</flux:label>
                    @if($document->files->isNotEmpty())
                        <table class="w-full text-left border-collapse">
                            <thead>
                            <tr class="bg-gray-100 dark:bg-gray-800">
                                <th class="px-6 py-2">Название</th>
                                <th class="px-6 py-2">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($document->files as $file)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4">
                                        {{ $file->original_name ?? 'Файл ' . $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                                           class="px-3 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">
                                            Открыть
                                        </a>
                                        <a href="{{ Storage::url($file->file_path) }}" download
                                           class="px-3 py-1 bg-green-50 text-green-600 rounded hover:bg-green-100 transition">
                                            Скачать
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-gray-500 mt-2">Файлы отсутствуют</div>
                    @endif
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
