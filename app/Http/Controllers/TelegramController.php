<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DefStudio\Telegraph\Telegraph;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $update = $request->all();

        if(isset($update['message'])) {
            $chat_id = $update['message']['chat']['id'];
            $text = $update['message']['text'] ?? '';

            if($text === '/start') {
                Telegraph::chat($chat_id)->message('Привет! Спасибо за запуск бота')->send();
            }
        }

        return response()->json(['ok' => true]);
    }

}
