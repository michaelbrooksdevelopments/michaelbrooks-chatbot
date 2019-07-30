<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class OnboardingConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $extras = $this->getBot()->getMessage()->getExtras();
        $response = $extras['apiReply'];


        $question = Question::create($response)
            ->addButtons([
                Button::create('View website')->value('website'),
                Button::create('See FAQs')->value('faqs')
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'website') {
                $this->say('You can view my website here which gives you more information. - https://michaelbrooks.dev');
            }
        });
    }
}
