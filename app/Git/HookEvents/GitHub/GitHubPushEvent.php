<?php namespace App\Git\HookEvents\GitHub;

use App\Git\Data\Commits;
use App\Git\HookEvents\ReportableGitEventInterface;
use Illuminate\Config\Repository as Config;

class GitHubPushEvent extends GitHubEvent implements ReportableGitEventInterface{

    private $payload;
    /**
     * @var Config
     */
    private $config;

    /**
     * PushEvent constructor.
     * @param $payload
     * @param Config $config
     */
    public function __construct($payload, Config $config)
    {
        parent::__construct($payload);
        $this->payload = $payload;
        $this->config = $config;
    }

    /**
     * Returns the commits pushed
     * @return Commits
     */
    public function commits()
    {
        return new Commits(
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
        $commitsLimit = $this->config->get('githook.commits.limit');

        //user probably created and pushed an empty branch
        if ($commitsCount === 0) {
            return $this->sender()->name() . ' pushed the '
                . $this->fullBranchPath() . ' branch without any commits.';
        }

        // bitbucket doesn't send more than 5 commits so we're going to limit this too
        if( $commitsCount > $commitsLimit) {
            return $this->message($this->sender()->name(), "5+ commits", $this->fullBranchPath());
        }

        $commits = $commitsCount . ($commitsCount > 1 && $commitsCount <= $commitsLimit ? ' commits' : ' commit');
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