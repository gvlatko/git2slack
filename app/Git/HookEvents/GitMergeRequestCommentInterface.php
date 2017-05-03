<?php
namespace App\Git\HookEvents;

interface GitMergeRequestCommentInterface
{
    public function number();

    public function title();

    public function url();

    public function formattedTitle();

    public function repository();

    public function branch();

    public function sender();

    public function comment();

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report();
}