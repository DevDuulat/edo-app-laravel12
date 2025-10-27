@props(['folders', 'documents'])

<div id="listView">
    <div x-data="{ selected: [] }">
        <table class="min-w-full rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <thead class="bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100">
            <tr>
                <th scope="col" class="p-4">
                    <input
                            type="checkbox"
                            x-model="selectAll"
                            @click="selected = selected.length === {{ count($folders) }} ? [] : @js($folders->pluck('id'))"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                    />
                </th>
                <th class="px-6 py-3 text-left">Название</th>
                <th class="px-6 py-3 text-left">Дата создания</th>
                <th class="px-6 py-3 text-left">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($folders as $folder)
                <tr class="border-b dark:border-zinc-700" data-folder-id="{{ $folder->id }}">
                    <td class="w-4 p-4">
                        <input
                                type="checkbox"
                                name="folder_ids[]"
                                value="{{ $folder->id }}"
                                x-model="selected"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                        />
                    </td>
                    <td class="px-6 py-4 flex items-center gap-2">
                        <x-icon.folder-icon />
                        <a href="{{ route('admin.folders.index', ['parent_id' => $folder->id]) }}"
                           class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $folder->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4">{{ $folder->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4">
                        <x-actions.folder-dropdown :folder="$folder" />
                    </td>
                </tr>
                <x-actions.folder-context-menu :folder="$folder" />
            @endforeach

            @foreach($documents as $document)
                <tr class="border-b dark:border-zinc-700" data-document-id="{{ $document->id }}">
                    <td class="w-4 p-4">
                        <input
                                type="checkbox"
                                name="document_ids[]"
                                value="{{ $document->id }}"
                                x-model="selected"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                        />
                    </td>
                    <td class="px-6 py-4 flex items-center gap-2">
                        <x-icon.document-icon />
                        <a href="{{ route('admin.documents.show', $document->id) }}"
                           class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $document->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4">{{ $document->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4">
                        <button class="text-blue-600 hover:underline text-sm">Открыть</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
