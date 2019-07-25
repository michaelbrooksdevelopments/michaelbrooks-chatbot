<?php

use Botman\Botman\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Middleware\Dialogflow;

$botman = resolve('botman');

$dialogflow = Dialogflow::create(getenv('DIALOGFLOW_TOKEN'))->listenForAction();
$botman->middleware->received($dialogflow);

$botman->hears('/start|GET_STARTED', function (BotMan $bot) {

})->stopsConversation();

$botman->group(['middleware' => $dialogflow], function (BotMan $bot) {
    $bot->hears('input.welcome', function (BotMan $bot) {
        $extras = $bot->getMessage()->getExtras();
        $response = $extras['apiReply'];

        $question = Question::create($response)
            ->addButtons([
                Button::create('View website')->value('website'),
                Button::create('See FAQs')->value('faqs')
            ]);

        $bot->ask($question, function (Answer $answer) use ($bot) {
            if ($answer->getValue() === 'website') {
                $bot->reply('You can view my website here which gives you more information. - https://michaelbrooks.dev');
            }
        });
    })->stopsConversation();
});