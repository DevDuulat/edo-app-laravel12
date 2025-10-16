<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.header class="pb-2">
        <flux:sidebar.brand
                href="{{route('dashboard')}}"
                logo="https://kutstroy.kg/img/logo_black.png"
                logo:dark="https://kutstroy.kg/img/logo_black.png"
                name="ЭДО"
        />
        <flux:sidebar.collapse class="lg:hidden" />
    </flux:sidebar.header>
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-1 rtl:space-x-reverse" wire:navigate>
        {{--                <x-app-logo />--}}
    </a>
    <flux:sidebar.nav>
    <flux:sidebar.item icon="link" :href="route('sso.base')" target="_blank" class="py-1">
        Перейти в Кут База
    </flux:sidebar.item>

    <flux:sidebar.group expandable heading="Менеджмент" class="grid gap-1">
        <flux:sidebar.item icon="building-office" :href="route('admin.departments.index')" wire:navigate class="py-1">
            Департаменты
        </flux:sidebar.item>

        <flux:sidebar.item icon="users" :href="route('admin.employees.index')" wire:navigate class="py-1">
            Сотрудники
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group expandable heading="Документы" class="grid gap-1">
        <flux:sidebar.item icon="document" :href="route('admin.documents.index')" wire:navigate class="py-1">
            Все документы
        </flux:sidebar.item>

        <flux:sidebar.item icon="document-plus" :href="route('admin.documents.create')" wire:navigate class="py-1">
            Создать документ
        </flux:sidebar.item>

        <flux:sidebar.item icon="document-arrow-down" wire:navigate class="py-1">
            Входящие
        </flux:sidebar.item>

        <flux:sidebar.item icon="document-arrow-up" wire:navigate class="py-1">
            Исходящие
        </flux:sidebar.item>

        <flux:sidebar.item icon="archive-box" wire:navigate class="py-1">
            Архив
        </flux:sidebar.item>
    </flux:sidebar.group>
    </flux:sidebar.nav>
    <flux:spacer />

    <!-- Desktop User Menu -->
    <flux:dropdown class="hidden lg:block" position="bottom" align="start">
        <flux:profile
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down"
        />

        <flux:menu class="w-[220px]">
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-1 px-1 py-1 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate class="py-1">
                    {{ __('Настройки') }}
                </flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full py-1">
                    {{ __('Выйти') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>

<!-- Mobile User Menu -->
<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
    <flux:spacer />
    <flux:dropdown position="top" align="end">
        <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down"
        />

        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-1 px-1 py-1 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate class="py-1">
                    {{ __('Настройки') }}
                </flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full py-1">
                    {{ __('Выйти') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

{{ $slot }}
@fluxScripts
<script src="{{ asset('flux/flux.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/photoswipe@5.4.4/dist/photoswipe.css" />
<link rel="stylesheet" href="https://unpkg.com/photoswipe-dynamic-caption-plugin/photoswipe-dynamic-caption-plugin.css" />
<link rel="stylesheet" href="https://unpkg.com/photoswipe@5.4.4/dist/photoswipe.css" />
<link rel="stylesheet" href="https://unpkg.com/photoswipe-dynamic-caption-plugin/photoswipe-dynamic-caption-plugin.css" />

<script type="module">
    import PhotoSwipeLightbox from 'https://unpkg.com/photoswipe@5.4.4/dist/photoswipe-lightbox.esm.js';
    import PhotoSwipeDynamicCaption from 'https://unpkg.com/photoswipe-dynamic-caption-plugin/photoswipe-dynamic-caption-plugin.esm.js';

    // Поддержка всех галерей на странице
    const galleries = document.querySelectorAll('.pswp-gallery');

    if (galleries.length > 0) {
        galleries.forEach(gallery => {
            const lightbox = new PhotoSwipeLightbox({
                gallery: gallery,
                children: 'a[data-pswp-width]',
                pswpModule: () => import('https://unpkg.com/photoswipe@5.4.4/dist/photoswipe.esm.js'),
            });

            new PhotoSwipeDynamicCaption(lightbox, { type: 'auto' });
            lightbox.init();
        });
    }
</script>

</body>
</html>
