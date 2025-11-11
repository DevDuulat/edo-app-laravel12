<x-layouts.app :title="__('Шаблоны')">
    @if(session('alert'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <x-alerts.alert :type="session('alert.type')" :message="session('alert.message')" />
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Шаблоны</h1>

        <flux:button href="{{ route('admin.document-templates.create') }}" icon="plus" variant="primary">
            Создать шаблон
        </flux:button>
    </div>
        <div class="border rounded-xl border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="p-4">
                        <input
                                type="checkbox"
                                :checked="selectedDocuments.length === {{ $documents->count() }}"
                                @click="selectedDocuments = selectedDocuments.length === {{ $documents->count() }} ? [] : @js($documents->pluck('id'))"
                                class="w-4 h-4"
                        />
                    </th>
                    <th class="px-6 py-3 text-left">Название</th>
                    <th class="px-6 py-3 text-left">Статус</th>
                    <th class="px-6 py-3 text-left">Дата создания</th>
                    <th class="px-6 py-3 text-left">Действия</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($documents as $template)
                    <tr class="hover:bg-gray-50" data-document-id="{{ $template->id }}">
                        <td class="w-4 p-4">
                            <label class="flex items-center justify-center w-6 h-6 border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition cursor-pointer">
                                <input
                                        type="checkbox"
                                        name="document_ids[]"
                                        value="{{ $template->id }}"
                                        x-model="selectedDocuments"
                                        class="accent-blue-500 w-4 h-4 rounded cursor-pointer"
                                />
                            </label>
                        </td>

                        <td class="px-6 py-4 flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8">
                                <x-icon.template-icon />
                            </span>
                            <a href="{{ route('admin.document-templates.show', $template->id) }}" class="font-medium text-gray-900 hover:text-gray-700 transition">
                                {{ $template->name }}
                            </a>
                        </td>

                        <td class="px-6 py-4">
                            @if($template->active)
                                <flux:badge color="lime">Активен</flux:badge>
                            @else
                                <flux:badge color="zinc">Не активен</flux:badge>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $template->created_at->format('d.m.Y') }}</td>
                        <td class="px-6 py-4 text-left">
                            <div class="flex items-center gap-2">
                                <flux:button
                                        icon="eye"
                                        href="{{ route('admin.document-templates.show', $template->id) }}"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition shadow-sm"
                                />

                                <flux:button
                                        icon="pencil"
                                        href="{{ route('admin.document-templates.edit', $template->id) }}"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition shadow-sm"
                                />

                                <flux:button
                                        icon="trash"
                                        icon-only
                                        class="text-red-600 hover:text-red-500"
                                        title="Удалить"
                                        onclick="
                                    if (!confirm('Вы уверены что хотите удалить?')) return;
                                    fetch('{{ route('admin.document-templates.destroy', $template->id) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({ _method: 'DELETE' })
                                    }).then(() => location.reload());
                                "
                                />
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $documents->links() }}
        </div>

</x-layouts.app>
