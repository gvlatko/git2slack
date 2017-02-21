<?php
namespace App\Git\HookEvents;

interface GitPullRequestInterface
{
    public function action();

    public function number();

    public function title();

    public function url();

    public function formattedTitle();

    public function description();

    public function repository();

    public function branch();

    public function sender();

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report();
}