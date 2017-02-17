<?php

namespace App\Notifications;

use App\Git\HookEvents\GitEventInterface;

interface EventDecoratorInterface
{
    /**
     * EventDecoratorInterface constructor.
     * @param GitEventInterface $event
     */
    public function __construct(GitEventInterface $event);

    public function decorate();
}
