<?php

namespace App\Http\Controllers;

use App\Models\User;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;

class TelegramController extends WebhookHandler
{
    public function start(): void
    {
        Log::info('Telegram /start вызван', [
            'chat_id' => $this->update()->chat()->id,
            'username' => $this->update()->chat()->username
        ]);

        $keyboard = Keyboard::make()->text('Ввести токен', 'enter_token');

        $this->reply(
            "Добро пожаловать!\n\nЧтобы привязать ваш аккаунт, нажмите кнопку ниже и введите токен.",
            $keyboard
        );
    }

    public function handleText(): void
    {
        $text = $this->update()->message()->text;
        $chatId = $this->update()->chat()->id;
        $username = $this->update()->chat()->username;

        Log::info('Telegram сообщение получено', [
            'chat_id' => $chatId,
            'username' => $username,
            'text' => $text
        ]);

        if ($text === 'enter_token') {
            Log::info('Пользователь нажал кнопку Ввести токен', [
                'chat_id' => $chatId
            ]);
            $this->reply("Пожалуйста, введите ваш токен:");
            return;
        }

        $user = User::where('telegram_token', $text)->first();

        if ($user) {
            $user->telegram_id = $chatId;
            $user->telegram_token = null;
            $user->save();

            Log::info('Телеграм ID привязан к пользователю', [
                'user_id' => $user->id,
                'chat_id' => $chatId
            ]);

            $this->reply("Аккаунт успешно привязан к Telegram!");
        } else {
            Log::warning('Попытка привязки с неверным токеном', [
                'chat_id' => $chatId,
                'token' => $text
            ]);
            $this->reply("Неверный токен. Проверьте и попробуйте снова.");
        }
    }
}
