<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
class TelegramController extends Controller
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $chatId = $update->getMessage()->getChat()->getId();
        $text = $update->getMessage()->getText();

        if ($text === '/start') {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Привет! Я ваш бот на Laravel'
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Вы написали: ' . $text
            ]);
        }
    }

}
