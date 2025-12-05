<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
class TelegramSetWebhookCommand extends Command
{
    protected $signature = 'telegram:set-webhook';
    protected $description = 'Установить webhook для Telegram бота';

    public function handle()
    {
        $url = 'https://doc.kutstroy.kg/telegram/webhook';
        $response = Telegram::setWebhook(['url' => $url]);
        $this->info('Webhook установлен: ' . json_encode($response));
    }
}
