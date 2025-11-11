<flux:header class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 flex items-center justify-between">
    <div class="flex items-center gap-3 max-w-md w-full">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:input
                kbd="⌘K"
                icon="magnifying-glass"
                placeholder="Поиск..."
                class="w-full"
        />
    </div>

    <div class="flex items-center gap-2">
        <flux:navbar class="hidden lg:flex gap-2">
            <flux:navbar.item icon="bell" href="#" label="Notification" />
            <flux:navbar.item icon="cog-6-tooth" href="{{route('settings.profile')}}" label="Settings" />
            <flux:navbar.item icon="information-circle" href="#" label="Help" />
        </flux:navbar>

        <flux:dropdown position="top" align="end">
            <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />
            <flux:menu class="min-w-[220px]">
                <div class="p-2 text-sm">
                    <div class="flex items-center gap-2">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-neutral-200 dark:bg-neutral-700 text-black dark:text-white text-lg font-semibold">
                        {{ auth()->user()->initials() }}
                    </span>
                        <div class="leading-tight">
                            <div class="font-semibold truncate">{{ auth()->user()->name }}</div>
                            <div class="text-gray-500 text-xs truncate">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>

                <flux:menu.separator />

                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate class="hover:bg-gray-100 dark:hover:bg-gray-700">
                    {{ __('Настройки') }}
                </flux:menu.item>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('Выйти') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </div>

</flux:header>
