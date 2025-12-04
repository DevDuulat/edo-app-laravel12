@props(['folder'])

<div
        class="group folder-card relative bg-white dark:bg-zinc-800 rounded-xl p-4 flex flex-col justify-between border border-zinc-200 dark:border-zinc-700
           hover:shadow-md hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 ease-in-out cursor-pointer"
        data-folder-id="{{ $folder->id }}"
>
    <a href="{{ route('admin.folders.index', ['parent_id' => $folder->id]) }}"
       class="flex flex-col items-center w-full min-h-[60px]">
        <x-icon.folder-icon class="w-10 h-10 text-blue-600 dark:text-blue-400 group-hover:scale-105 transition-transform"/>
        <span class="text-base font-medium text-gray-900 dark:text-gray-100 mt-2 line-clamp-2 text-center w-full">
            {{ $folder->name }}
        </span>
    </a>

    <div class="flex items-center justify-start w-full mt-4 text-xs text-gray-500 dark:text-gray-400">
        <span>{{ $folder->created_at->format('d.m.Y') }}</span>
    </div>

    <div class="absolute top-1 right-1 z-20">
        <div class="p-1 rounded-full text-gray-500 dark:text-gray-400 ">
            <x-actions.folder-dropdown :folder="$folder" />
        </div>
    </div>
</div>
<x-actions.folder-context-menu :folder="$folder" />
