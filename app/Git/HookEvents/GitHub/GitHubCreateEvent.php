<?php namespace App\Git\HookEvents\GitHub;

use App\Git\HookEvents\ReportableGitEventInterface;

class GitHubCreateEvent extends GitHubEvent implements ReportableGitEventInterface {

    private $payload;

    /**
     * CreateEvent constructor.
     * @param $payload
     */
    public function __construct($payload)
    {
        parent::__construct($payload);
        $this->payload = $payload;
    }

    /**
     * Returns the type of the object created - repository|branch|tag
     * @return mixed
     */
    public function type()
    {
        return $this->payload["ref_type"];
    }

    /**
     * Returns the master branch
     * master branch is the branch set as the default branch on github
     * @return mixed
     */
    public function masterBranch()
    {
        return $this->payload["master_branch"];
    }
    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {
        return 'CREATE: ' . $this->sender()->name()
        . ' created a new ' . $this->type() . ': ' . $this->branch()->name() . ' on ' . $this->masterBranch();
    }
}