@props(['folders', 'documents'])

<div id="gridView" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">

    @foreach($folders as $folder)
        <x-folders.card :folder="$folder" />
    @endforeach

    @foreach($documents as $document)
        @php
            $hasWorkflow = $document->workflows->isNotEmpty();
            $link = $hasWorkflow
                ? route('admin.workflows.show', $document->workflows->first()->id)
                : route('admin.documents.show', $document->id);
        @endphp

        <a href="{{ $link }}"
           class="group document-card relative bg-white dark:bg-zinc-800 rounded-xl p-4 flex flex-col justify-between border border-zinc-200 dark:border-zinc-700
                  hover:shadow-md hover:border-green-500 dark:hover:border-green-500 transition-all duration-200 ease-in-out cursor-pointer"
           data-document-id="{{ $document->id }}"
        >
            <div class="flex flex-col items-center w-full min-h-[60px]">
                @if($hasWorkflow)
                    <x-icon.workflow-document-icon class="w-10 h-10 text-amber-600 dark:text-amber-400 group-hover:scale-105 transition-transform"/>
                @else
                    <x-icon.document-icon class="w-10 h-10 text-green-600 dark:text-green-400 group-hover:scale-105 transition-transform"/>
                @endif
                <span class="text-base font-medium text-gray-900 dark:text-gray-100 mt-2 line-clamp-2 text-center w-full">
                    {{ $document->title }}
                </span>
            </div>

            <div class="flex items-center justify-between w-full mt-4 text-xs text-gray-500 dark:text-gray-400">
                <span>{{ $document->created_at->format('d.m.Y') }}</span>
                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                </div>
            </div>
        </a>
    @endforeach

</div>