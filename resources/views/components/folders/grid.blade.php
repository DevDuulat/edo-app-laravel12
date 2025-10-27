@props(['folders', 'documents'])

<div id="gridView" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
    @foreach($folders as $folder)
        <x-folders.card :folder="$folder" />
    @endforeach

    @foreach($documents as $document)
        <div class="document-card bg-zinc-50 dark:bg-zinc-900 rounded-xl p-4 flex flex-col items-center justify-between border border-zinc-200 dark:border-zinc-700 hover:shadow-lg transition" data-document-id="{{ $document->id }}">
            <span class="text-sm text-gray-900 dark:text-gray-100 truncate max-w-full text-center">{{ $document->title }}</span>
            <div class="flex items-center justify-between w-full mt-2">
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $document->created_at->format('d.m.Y') }}</span>
                <button class="text-blue-600 hover:underline text-xs">Открыть</button>
            </div>
        </div>
    @endforeach
</div>
