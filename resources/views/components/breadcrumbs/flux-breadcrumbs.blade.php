@props(['breadcrumbs'])

<flux:breadcrumbs class="mb-4">
    @foreach ($breadcrumbs as $breadcrumb)

        @if ($breadcrumb->url && !$loop->last)
            <flux:breadcrumbs.item href="{{ $breadcrumb->url }}">
                {{ $breadcrumb->title }}
            </flux:breadcrumbs.item>
        @else
            <flux:breadcrumbs.item>
                {{ $breadcrumb->title }}
            </flux:breadcrumbs.item>
        @endif

    @endforeach
</flux:breadcrumbs>
