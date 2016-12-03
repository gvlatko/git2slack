<?php namespace App\Git\HookEvents\GitHub;

use App\Git\DTO\CommitsDTO;
use App\Git\HookEvents\ReportableGitEventInterface;
use App\Git;

class GitHubPushEvent extends GitHubEvent implements ReportableGitEventInterface{

    private $payload;

    /**
     * PushEvent constructor.
     * @param $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
        parent::__construct($payload);
    }

    /**
     * Returns the commits pushed
     * @return CommitsDTO
     */
    public function commits()
    {
        return new CommitsDTO(
            $this->payload["commits"]
        );
    }

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {
        $commitsCount = $this->commits()->count();

        //user probably created and pushed an empty branch
        if ($commitsCount === 0) {
            return $this->sender()->name() . ' pushed the '
                . $this->fullBranchPath() . ' branch without any commits.';
        }

        // bitbucket doesn't send more than 5 commits so we're going to limit this too
        if( $commitsCount > Git\COMMITS_LIMIT) {
            return $this->message($this->sender()->name(), "5+ commits", $this->fullBranchPath());
        }

        $commits = $commitsCount . ($commitsCount > 1 && $commitsCount <= Git\COMMITS_LIMIT ? ' commits' : ' commit');
        return $this->message($this->sender()->name(), $commits, $this->fullBranchPath());
    }

    /**
     * Generates a formatted message
     * @param $sender
     * @param $commits
     * @param $branch
     * @return string
     */
    private function message($sender, $commits, $branch)
    {
        return 'COMMIT: ' . $sender . ' pushed ' . $commits . ' to ' . $branch;
    }
}