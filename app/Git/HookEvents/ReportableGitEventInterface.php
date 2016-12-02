<?php namespace App\Git\HookEvents;

Interface ReportableGitEventInterface {

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report();

}