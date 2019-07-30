<?php

use App\Conversations\OnboardingConversation;
use Botman\Botman\BotMan;
use BotMan\BotMan\Middleware\Dialogflow;

$botman = resolve('botman');

$dialogflow = Dialogflow::create(getenv('DIALOGFLOW_TOKEN'))->listenForAction();
$botman->middleware->received($dialogflow);

$botman->hears('/start|GET_STARTED', function (BotMan $bot) {

})->stopsConversation();

$botman->group(['middleware' => $dialogflow], function (BotMan $bot) {
    $bot->hears('input.welcome', function (BotMan $bot) {
        $bot->startConversation(new OnboardingConversation());
    })->stopsConversation();
});