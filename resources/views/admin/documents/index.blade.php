<x-layouts.app :title="__('Departments')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="#" icon="home" />
                <flux:breadcrumbs.item>{{ __('Документы') }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <flux:button href="{{ route('admin.documents.create') }}" icon="plus" variant="primary">
                {{ __('Добавить документ') }}
            </flux:button>

        </div>
        <h3 class="mb-2 text-2xl leading-none tracking-tight text-center text-gray-900 md:text-2xl dark:text-white">
            Документы
        </h3>

        <div class="relative overflow-x-auto rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <table class="min-w-full overflow-hidden">
                <thead class="bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left">ID</th>
                    <th scope="col" class="px-6 py-3 text-left">Название</th>
                    <th scope="col" class="px-6 py-3 text-left">Ссылка</th>
                    <th scope="col" class="px-6 py-3 text-left">Комментарий</th>
                    <th scope="col" class="px-6 py-3 text-left">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($documents as $document)
                    <tr class="odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 border-b dark:border-zinc-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $document->id }}</td>
                        <td class="px-6 py-4">{{ $document->title }}</td>
                        <td class="px-6 py-4">{{ $document->slug }}</td>
                        <td class="px-6 py-4">{{ $document->comment ?? 'Нету комментариев' }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <flux:button
                                    href="{{ route('admin.documents.edit', $document) }}"
                                    icon="pencil-square">
                            </flux:button>
                            <flux:button
                                    icon="trash"
                                    icon-only
                                    class="text-red-600 hover:text-red-500"
                                    title="Удалить"
                                    onclick="
                                    if (!confirm('Вы уверены что хотите удалить?')) return;
                                    fetch('{{ route('admin.documents.destroy', $document) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({ _method: 'DELETE' })
                                    }).then(() => location.reload());
                                "
                            />

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $documents->links() }}
        </div>
    </div>
</x-layouts.app>
