<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $update = $request->all();
        Log::info('Webhook received', $update);

        if (isset($update['message'])) {
            $chat_id = $update['message']['chat']['id'];
            $text = $update['message']['text'] ?? '';
            $first_name = $update['message']['chat']['first_name'] ?? 'User';

            Log::info("Chat: $chat_id, Text: $text");

            $chat = TelegraphChat::firstOrCreate(
                ['chat_id' => $chat_id],
                ['title' => $first_name]
            );

            if ($text === '/start') {
                $chat->message('Привет! Спасибо за запуск бота')->send();
            }
        }

        return response()->json(['ok' => true]);
    }
}
