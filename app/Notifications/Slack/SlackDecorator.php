<?php

namespace App\Slack\Notifications;

use App\Git\HookEvents\GitEventInterface;
use App\Notifications\EventDecoratorInterface;

class SlackDecorator implements EventDecoratorInterface
{
    /**
     * @var GitEventInterface
     */
    private $event;

    /**
     * SlackDecorator constructor.
     * @param GitEventInterface $event
     */
    function __construct(GitEventInterface $event)
    {
        $this->event = $event;
    }


    public function decorate()
    {
    }
}
