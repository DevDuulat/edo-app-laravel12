<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <script defer src="https://unpkg.com/alpinejs-slug@latest/dist/slug.min.js"></script>


    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <flux:sidebar.brand
                        href="#"
                        logo="https://kutstroy.kg/img/logo_black.png"
                        logo:dark="https://kutstroy.kg/img/logo_black.png"
                        name="ЭДО"
                />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
{{--                <x-app-logo />--}}
            </a>
                <flux:sidebar.item icon="home" :href="route('dashboard')" wire:navigate>
                    Панель управления
                </flux:sidebar.item>
            <flux:sidebar.group expandable heading="Менеджмент" class="grid">


                <flux:sidebar.item icon="building-office" :href="route('admin.departments.index')" wire:navigate>
                    Департаменты
                </flux:sidebar.item>

                <flux:sidebar.item icon="users" :href="route('admin.employees.index')" wire:navigate>
                    Сотрудники
                </flux:sidebar.item>
            </flux:sidebar.group>
            <flux:sidebar.group expandable heading="Документы" class="grid">

                <flux:sidebar.item icon="document" :href="route('dashboard')" wire:navigate>
                    Все документы
                </flux:sidebar.item>

                <flux:sidebar.item icon="document-plus" :href="route('admin.documents.create')" wire:navigate>
                    Создать документ
                </flux:sidebar.item>

                <flux:sidebar.item icon="document-arrow-down" :href="route('dashboard')" wire:navigate>
                    Входящие
                </flux:sidebar.item>

                <flux:sidebar.item icon="document-arrow-up" :href="route('dashboard')" wire:navigate>
                    Исходящие
                </flux:sidebar.item>

                <flux:sidebar.item icon="archive-box" :href="route('dashboard')" wire:navigate>
                    Архив
                </flux:sidebar.item>

            </flux:sidebar.group>
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
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
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
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Настройки') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
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
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
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
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Настройки') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Выйти') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}
        @fluxScripts
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    </body>
</html>
