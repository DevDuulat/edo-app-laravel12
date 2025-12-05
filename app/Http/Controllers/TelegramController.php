<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DefStudio\Telegraph\Telegraph;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $update = $request->all();
        Log::info('Webhook received', $update);

        if(isset($update['message'])) {
            $chat_id = $update['message']['chat']['id'];
            $text = $update['message']['text'] ?? '';

            Log::info("Chat: $chat_id, Text: $text");

            if($text === '/start') {
                Telegraph::chat($chat_id)->message('Привет! Спасибо за запуск бота')->send();
            }
        }

        return response()->json(['ok' => true]);
    }

}
