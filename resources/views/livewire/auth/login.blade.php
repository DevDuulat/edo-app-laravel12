<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Войдите в свою учетную запись')" :description="__('Введите свой адрес электронной почты и пароль ниже, чтобы войти в систему.')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Адрес электронной почты')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Пароль')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Введите пароль')"
                viewable
            />

        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Запомни меня')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                {{ __('Войти') }}
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Don\'t have an account?') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>
