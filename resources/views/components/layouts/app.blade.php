<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <div class="mx-auto lg:px-8">
            {{ $slot }}
        </div>
    </flux:main>

    @include('components.alerts.sweetalert')
</x-layouts.app.sidebar>