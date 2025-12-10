<?php

namespace App\Http\Controllers;

use App\Models\User;
use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Support\Stringable;

class TelegramController extends WebhookHandler
{
    protected function prepareChat(): TelegraphChat
    {
        $id = $this->message->chat()->id();

        return TelegraphChat::query()
            ->firstOrCreate(
                ['chat_id' => $id],
                ['name' => 'telegram']
            );
    }

    public function start(): void
    {
        $chat = $this->prepareChat();

        Telegraph::chat($chat)
            ->message('Добро пожаловать Чтобы привязать аккаунт введите ваш токен')
            ->send();

        $chat->storage()->set('awaiting_token', true);
    }

    protected function handleChatMessage(Stringable $text): void
    {
        $chat = $this->prepareChat();

        if ($chat->storage()->get('awaiting_token')) {
            $token = $text->toString();
            $messageId = $this->messageId;

            $user = User::query()
                ->where('telegram_token', $token)
                ->first();

            if ($user) {
                $user->update([
                    'telegram_id' => $chat->chat_id,
                    'telegram_token' => null,
                ]);

                $this->reply("Успешно Аккаунт привязан Ваш аккаунт {$user->name} теперь связан с этим чатом");

                Telegraph::chat($chat)
                    ->deleteMessage($messageId)
                    ->send();

                $chat->storage()->set('awaiting_token', null);
                return;
            }

            $this->reply('Ошибка привязки Пользователь с таким токеном не найден');
            return;
        }

        $this->reply('Для привязки аккаунта введите команду start');
    }
}
