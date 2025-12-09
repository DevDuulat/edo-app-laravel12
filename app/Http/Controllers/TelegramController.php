<?php

namespace App\Http\Controllers;

use App\Models\User;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Support\Stringable;

class TelegramController extends WebhookHandler
{
    public function start(): void
    {
        Telegraph::message('Добро пожаловать! Чтобы привязать аккаунт, пожалуйста, введите ваш токен.')
            ->send();
        $this->chat->storage()->set('awaiting_token', true);
    }

    protected function handleChatMessage(Stringable $text): void
    {
        if ($this->chat->storage()->get('awaiting_token')) {
            $token = $text->toString();

            $messageIdToDelete = $this->messageId;

            $user = User::query()
                ->where('telegram_token', $token)
                ->first();

            if ($user) {
                $user->update([
                    'telegram_id' => $this->chat->id,
                    'telegram_token' => null,
                ]);


                $this->reply("🎉 Успешно!\nАккаунт привязан!\nВаш аккаунт **{$user->name}** теперь связан с этим Telegram чатом.");

                Telegraph::chat($this->chat)
                    ->deleteMessage($messageIdToDelete)
                    ->send();


            } else {
                $this->reply('❌ **Ошибка привязки!**\nНе удалось найти пользователя с таким токеном. Пожалуйста, проверьте токен и попробуйте снова.');

                return;
            }

            $this->chat->storage()->set('awaiting_token', null);

        } else {
            $this->reply('Я получил ваше сообщение: ' . $text->toString() . '. Для привязки аккаунта введите команду /start.');
        }
    }
}