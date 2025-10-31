@props([
    'type' => 'success', // info, success, danger, warning, dark
    'message' => '',
    'show' => true
])

@php
    $colors = [
        'info' => ['text' => 'text-blue-800', 'bg' => 'bg-blue-50', 'border' => 'border-blue-300', 'btn' => 'bg-blue-800', 'btn-hover' => 'hover:bg-blue-900', 'btn-focus' => 'focus:ring-blue-200', 'btn-text' => 'text-white'],
        'success' => ['text' => 'text-green-800', 'bg' => 'bg-green-50', 'border' => 'border-green-300', 'btn' => 'bg-green-800', 'btn-hover' => 'hover:bg-green-900', 'btn-focus' => 'focus:ring-green-300', 'btn-text' => 'text-white'],
        'danger' => ['text' => 'text-red-800', 'bg' => 'bg-red-50', 'border' => 'border-red-300', 'btn' => 'bg-red-800', 'btn-hover' => 'hover:bg-red-900', 'btn-focus' => 'focus:ring-red-300', 'btn-text' => 'text-white'],
        'warning' => ['text' => 'text-yellow-800', 'bg' => 'bg-yellow-50', 'border' => 'border-yellow-300', 'btn' => 'bg-yellow-800', 'btn-hover' => 'hover:bg-yellow-900', 'btn-focus' => 'focus:ring-yellow-300', 'btn-text' => 'text-white'],
        'dark' => ['text' => 'text-gray-800', 'bg' => 'bg-gray-50', 'border' => 'border-gray-300', 'btn' => 'bg-gray-700', 'btn-hover' => 'hover:bg-gray-800', 'btn-focus' => 'focus:ring-gray-300', 'btn-text' => 'text-white'],
    ];

    $color = $colors[$type] ?? $colors['info'];
@endphp

@if($show)
    <div class="p-4 m-4 {{ $color['text'] }} border {{ $color['border'] }} rounded-lg {{ $color['bg'] }}" role="alert">
        <div class="flex items-center">
            <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <h3 class="text-lg font-medium">{{ ucfirst($type) }}</h3>
        </div>
        <div class="mt-2 mb-4 text-sm">
            {{ $message }}
        </div>
        <div class="flex">
            <button type="button" class="{{ $color['btn-text'] }} {{ $color['btn'] }} {{ $color['btn-hover'] }} {{ $color['btn-focus'] }} font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center">
                Посмотреть
            </button>
            <button type="button" class="{{ $color['text'] }} bg-transparent border {{ $color['border'] }} hover:{{ $color['btn-hover'] }} hover:text-white focus:ring-4 focus:outline-none {{ $color['btn-focus'] }} font-medium rounded-lg text-xs px-3 py-1.5 text-center" data-dismiss-target="#alert" aria-label="Close">
                Скрыть
            </button>
        </div>
    </div>
@endif
