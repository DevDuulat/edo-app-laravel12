<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Удалить аккаунт') }}</flux:heading>
        <flux:subheading>{{ __('Удалите ваш аккаунт и все его ресурсы') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('Удалить аккаунт') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form method="POST" wire:submit="deleteUser" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Вы уверены, что хотите удалить ваш аккаунт?') }}</flux:heading>

                <flux:subheading>
                    {{ __('После удаления аккаунта все его ресурсы и данные будут безвозвратно удалены. Пожалуйста, введите ваш пароль, чтобы подтвердить удаление аккаунта.') }}
                </flux:subheading>
            </div>

            <flux:input wire:model="password" :label="__('Пароль')" type="password" />

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Отмена') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit">{{ __('Удалить аккаунт') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
