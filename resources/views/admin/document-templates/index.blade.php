<x-layouts.app :title="__('Departments')">
    @if(session('alert'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <x-alerts.alert :type="session('alert.type')" :message="session('alert.message')" />
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Шаблоны</h1>

        <flux:modal.trigger name="template-modal">
            <flux:button>Создать шаблон</flux:button>
        </flux:modal.trigger>
    </div>
    <table class="min-w-full rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <thead class="bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100">
        <tr>
            <th scope="col" class="p-4">
                <input
                        type="checkbox"
                        :checked="selectedDocuments.length === {{ $documents->count() }}"
                        @click="selectedDocuments = selectedDocuments.length === {{ $documents->count() }} ? [] : @js($documents->pluck('id'))"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                />
            </th>
            <th class="px-6 py-3 text-left">Название</th>
            <th class="px-6 py-3 text-left">Статус</th>
            <th class="px-6 py-3 text-left">Дата создания</th>
            <th class="px-6 py-3 text-left">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($documents as $template)
            <tr class="border-b dark:border-zinc-700" data-document-id="{{ $template->id }}">
                <td class="w-4 p-4">
                    <input
                            type="checkbox"
                            name="document_ids[]"
                            value="{{ $template->id }}"
                            x-model="selectedDocuments"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                    />
                </td>
                <td class="px-6 py-4 flex items-center gap-2">
                    <x-icon.document-icon />
                    <a href="{{ route('admin.document-templates.show', $template->id) }}"
                       class="text-blue-600 dark:text-blue-400 hover:underline">
                        {{ $template->name }}
                    </a>
                </td>
                <td class="px-6 py-4">
                    {{ $template->active ? 'Активен' : 'Не активен' }}
                </td>
                <td class="px-6 py-4">{{ $template->created_at->format('d.m.Y') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.document-templates.edit', $template->id) }}"
                       class="text-blue-600 hover:underline text-sm">Редактировать</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <x-modals.modal-create-template/>

</x-layouts.app>