<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <div class="mx-auto lg:px-8">
            {{ $slot }}
        </div>
    </flux:main>
</x-layouts.app.sidebar>
