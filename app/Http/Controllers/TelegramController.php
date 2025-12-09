<?php

namespace App\Http\Controllers;

use App\Models\User;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Keyboard;

class TelegramController extends WebhookHandler
{
    public function start(): void
    {
        $keyboard = Keyboard::make()
            ->text('Ввести токен', 'enter_token');

        $this->reply("Добро пожаловать! Чтобы привязать аккаунт, нажмите кнопку и введите токен.", $keyboard);
    }

    public function handleText(): void
    {
        $text = $this->update()->message()->text;

        if ($text === 'enter_token') {
            $this->reply("Пожалуйста, введите ваш токен:");
            return;
        }

        $user = User::where('telegram_token', $text)->first();

        if ($user) {
            $user->telegram_id = $this->update()->chat()->id;
            $user->telegram_token = null;
            $user->save();

            $this->reply("Аккаунт успешно привязан к Telegram");
        } else {
            $this->reply("Неверный токен. Проверьте и попробуйте снова.");
        }
    }
}
