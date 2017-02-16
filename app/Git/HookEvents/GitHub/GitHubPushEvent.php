<?php namespace App\Git\HookEvents\GitHub;

use App\Git\Data\Commits;
use App\Git\Data\Formatters\CommitsSlackFormatter;
use App\Git\HookEvents\ReportableGitEventInterface;

class GitHubPushEvent extends GitHubEvent implements ReportableGitEventInterface{

    private $payload;

    /**
     * PushEvent constructor.
     * @param $payload
     */
    public function __construct($payload)
    {
        parent::__construct($payload);
        $this->payload = $payload;
    }

    /**
     * Returns the commits pushed
     * @return Commits
     */
    public function commits()
    {
        return new Commits(
            $this->payload["commits"],
            $this->payload["compare"]
        );
    }

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {
        $formatter = new CommitsSlackFormatter($this->commits(), $this->sender(), $this->branch(), $this->repository());
        return $formatter->format();
    }



}