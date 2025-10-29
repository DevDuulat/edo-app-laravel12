<flux:header class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" />

    <flux:navbar class="flex-1">
        <flux:navbar.item icon="home" href="{{route('dashboard')}}">Главная</flux:navbar.item>
        <flux:navbar.item icon="folder" href="{{route('admin.folders.index')}}">Папки</flux:navbar.item>
        <flux:modal.trigger name="workflow-modal">
            <flux:navbar.item icon="arrow-path-rounded-square" href="#">Рабочий процесс</flux:navbar.item>
        </flux:modal.trigger>
        <flux:navbar.item icon="document-text" href="#">Аудит лог</flux:navbar.item>
{{--        <flux:navbar.item icon="share" href="#">Поделиться</flux:navbar.item>--}}
{{--        <flux:navbar.item icon="inbox-arrow-down" href="#">Скачать</flux:navbar.item>--}}
{{--        <flux:navbar.item icon="trash" href="#">Удалить</flux:navbar.item>--}}
{{--        <flux:navbar.item icon="document-duplicate" href="#">Дублировать</flux:navbar.item>--}}

        <flux:separator vertical variant="subtle" class="my-2"/>

    </flux:navbar>

    <flux:spacer />


    <flux:navbar class="items-center">
        <flux:dropdown class="max-lg:hidden">
            <flux:navbar.item icon:trailing="chevron-down">Загрузить</flux:navbar.item>
            <flux:navmenu>
                <flux:navmenu.item href="#">Загрузить документ</flux:navmenu.item>
                <flux:navmenu.item href="#">Android app</flux:navmenu.item>
                <flux:navmenu.item href="#">Brand guidelines</flux:navmenu.item>
            </flux:navmenu>
        </flux:dropdown>
        <flux:navbar.item class="max-lg:hidden" icon="cog-6-tooth" href="#" label="Settings" />
        <flux:navbar.item class="max-lg:hidden" icon="information-circle" href="#" label="Help" />
    </flux:navbar>

    <flux:dropdown position="top" align="end">
        <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />
        <flux:menu>
            <div class="p-0 text-sm">
                <div class="flex items-center gap-2 px-1 py-1.5 text-start">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-200 dark:bg-neutral-700 text-black dark:text-white">
                        {{ auth()->user()->initials() }}
                    </span>
                    <div class="grid flex-1 text-start leading-tight">
                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>

            <flux:menu.separator />

            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Настройки') }}</flux:menu.item>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Выйти') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>


</flux:header>
