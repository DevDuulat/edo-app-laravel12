<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    @include('partials.head')
</head>

<body class="min-h-screen">
<flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.header class="pb-2">
        <flux:sidebar.brand
                href="{{ route('dashboard') }}"
                logo="{{ config('app.logo_light') }}"
                logo:dark="{{ config('app.logo_dark') }}"
                name="{{ config('app.name') }}"
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

   @canany(['edo-hr-department', 'edo-employee-list'])
    <flux:sidebar.group expandable heading="Менеджмент" class="grid gap-1">
        @can('edo-hr-department')
            <flux:sidebar.item icon="building-office" :href="route('admin.departments.index')" wire:navigate class="py-1">
                Департаменты
            </flux:sidebar.item>
        @endcan
        @can('edo-employee-list')
            <flux:sidebar.item icon="users" :href="route('admin.employees.index')" wire:navigate class="py-1">
                Сотрудники
            </flux:sidebar.item>
        @endcan
    </flux:sidebar.group>
    @endcanany


    <flux:sidebar.group expandable heading="Документы" class="grid gap-1">
        <flux:sidebar.item icon="document-text" :href="route('admin.document-templates.index')" wire:navigate class="py-1">
            Шаблоны
        </flux:sidebar.item>
        {{--Все документы--}}
        {{--Это “база” всех созданных документов — черновики, утверждённые, в процессе и т.д.--}}
        <flux:sidebar.item icon="document-duplicate" :href="route('admin.documents.index')" wire:navigate class="py-1">
            Все документы
        </flux:sidebar.item>

        {{--Входящие рабочие процессы--}}
        <flux:sidebar.item icon="document-arrow-down" badge="12" :href="route('admin.incoming.workflows')" wire:navigate  class="py-1">
            Входящие
        </flux:sidebar.item>

        {{--Исходящие рабочие процессы--}}
        <flux:sidebar.item icon="document-arrow-up" :href="route('admin.outgoing.workflows')" wire:navigate class="py-1">
            Исходящие
        </flux:sidebar.item>

        {{--Завершенные рабочие процессы--}}
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
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/photoswipe@5.4.4/dist/photoswipe.css" />
<link rel="stylesheet" href="https://unpkg.com/photoswipe-dynamic-caption-plugin/photoswipe-dynamic-caption-plugin.css" />
<link rel="stylesheet" href="https://unpkg.com/photoswipe@5.4.4/dist/photoswipe.css" />
<link rel="stylesheet" href="https://unpkg.com/photoswipe-dynamic-caption-plugin/photoswipe-dynamic-caption-plugin.css" />

<script src="{{ asset('flux/flux.js') }}"></script>

</body>
</html>
