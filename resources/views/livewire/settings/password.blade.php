<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Обновить пароль')" :subheading="__('Убедитесь, что ваш аккаунт использует длинный и случайный пароль для безопасности')">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                    wire:model="current_password"
                    :label="__('Текущий пароль')"
                    type="password"
                    required
                    autocomplete="current-password"
            />
            <flux:input
                    wire:model="password"
                    :label="__('Новый пароль')"
                    type="password"
                    required
                    autocomplete="new-password"
            />
            <flux:input
                    wire:model="password_confirmation"
                    :label="__('Подтвердите пароль')"
                    type="password"
                    required
                    autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Сохранить') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Сохранено.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
