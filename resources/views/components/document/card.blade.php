@props(['document'])
@php
    $hasWorkflow = $document->workflows->isNotEmpty()
@endphp

@php
    $link = $hasWorkflow
       ? route('admin.workflows.show', $document->workflows->first()->slug)
       : route('admin.documents.show', $document->id);
@endphp

<div
        class="group document-card relative bg-white dark:bg-zinc-800 rounded-xl p-4 flex flex-col justify-between border border-zinc-200 dark:border-zinc-700
               hover:shadow-md hover:border-green-500 dark:hover:border-green-500 transition-all duration-200 ease-in-out cursor-pointer"
        data-document-id="{{ $document->id }}"
>
    <input
            type="checkbox"
            class="absolute top-1 left-1 w-4 h-4 accent-green-600 rounded cursor-pointer z-30"
            @click.stop="selectedDocuments.includes({{ $document->id }}) ? selectedDocuments = selectedDocuments.filter(id => id !== {{ $document->id }}) : selectedDocuments.push({{ $document->id }})"
            :checked="selectedDocuments.includes({{ $document->id }})"
    />

    <a href="{{ $link }}" class="flex flex-col items-center w-full min-h-[60px]">
        @if($hasWorkflow)
            <x-icon.workflow-document-icon class="w-10 h-10 text-amber-600 dark:text-amber-400 group-hover:scale-105 transition-transform"/>
        @else
            <x-icon.document-icon class="w-10 h-10 text-green-600 dark:text-green-400 group-hover:scale-105 transition-transform"/>
        @endif
        <span class="text-base font-medium text-gray-900 dark:text-gray-100 mt-2 line-clamp-2 text-center w-full">
            {{ $document->title }}
        </span>
    </a>

    <div class="flex items-center justify-start w-full mt-4 text-xs text-gray-500 dark:text-gray-400">
        <span>{{ $document->created_at->format('d.m.Y') }}</span>
    </div>

    <div class="absolute top-1 right-1 z-20">
        <div class="p-1 rounded-full text-gray-500 dark:text-gray-400">
            <x-actions.document-dropdown :document="$document" />
        </div>
    </div>
</div>