<x-layouts.app.sidebar :title="$title ?? null">
{{--    <x-layouts.app.header/>--}}

    <flux:main class="!p-0">
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
