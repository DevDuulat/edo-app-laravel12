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
        Telegraph::chat($this->chat)
            ->message('Добро пожаловать! Чтобы привязать аккаунт, введите ваш токен.')
            ->send();

        $this->chat->storage()->set('awaiting_token', true);
    }

    protected function handleChatMessage(Stringable $text): void
    {
        if ($this->chat->storage()->get('awaiting_token')) {
            $token = $text->toString();
            $messageId = $this->messageId;

            $user = User::query()
                ->where('telegram_token', $token)
                ->first();

            if ($user) {
                $user->update([
                    'telegram_id' => $this->chat->id,
                    'telegram_token' => null,
                ]);

                $this->reply("Успешно. Аккаунт привязан. Ваш аккаунт {$user->name} теперь связан с этим чатом.");

                Telegraph::chat($this->chat)
                    ->deleteMessage($messageId)
                    ->send();

                $this->chat->storage()->set('awaiting_token', null);
                return;
            }

            $this->reply('Ошибка привязки. Пользователь с таким токеном не найден.');
            return;
        }

        $this->reply('Для привязки аккаунта введите команду /start.');
    }
}
