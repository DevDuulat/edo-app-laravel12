@props(['folder'])

<div
        class="group folder-card bg-zinc-50 dark:bg-zinc-900 rounded-xl p-4 flex flex-col items-center justify-between
           border border-zinc-200 dark:border-zinc-700 hover:shadow-lg transition"
        data-folder-id="{{ $folder->id }}"
>
    <a href="{{ route('admin.folders.index', ['parent_id' => $folder->id]) }}" class="flex flex-col items-center folder-link">
        <x-icon.folder-icon/>
        <span class="text-sm text-gray-900 dark:text-gray-100 truncate max-w-full text-center">
            {{ $folder->name }}
        </span>
    </a>
    <div class="flex items-center justify-between w-full mt-2">
        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $folder->created_at->format('d.m.Y') }}</span>
        <x-actions.folder-dropdown :folder="$folder" />
    </div>
</div>

<x-actions.folder-context-menu :folder="$folder" />
