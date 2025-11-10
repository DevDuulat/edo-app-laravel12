<flux:header class="bg-zinc-50 h-18 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 flex items-center px-4 justify-between">
    <div class="flex items-center gap-3 max-w-md">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" />
        <flux:input
                kbd="⌘K"
                icon="magnifying-glass"
                placeholder="Поиск..."
                class="w-full"
        />
    </div>

    <div class="flex-1"></div>

    <div class="flex items-center gap-4">
        <flux:modal.trigger name="notifications-modal">
            <button class="relative p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
            </button>
        </flux:modal.trigger>

        <flux:separator vertical />

        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-neutral-200 dark:bg-neutral-700 text-black dark:text-white text-sm font-semibold">
            {{ auth()->user()->initials() }}
        </span>
        <div class="flex flex-col leading-tight">
            <span class="font-semibold text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</span>
        </div>
    </div>
</flux:header>
