<?php

namespace App\Http\Controllers;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;

class TelegramController extends WebhookHandler
{
   public function start():void
   {
       $this->reply("Добро пожаловать!");
       Telegraph::registerBotCommands([
           'help'=>'вызов описания',
           'test'=> 'test',
       ])->send();
   }
}
