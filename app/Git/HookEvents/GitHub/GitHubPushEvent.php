<?php namespace App\Git\HookEvents\GitHub;

use App\Git\Data\Commits;
use App\Git\Data\SlackUrl;
use App\Git\HookEvents\ReportableGitEventInterface;
use Illuminate\Config\Repository as Config;

class GitHubPushEvent extends GitHubEvent implements ReportableGitEventInterface{

    private $payload;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var SlackUrl
     */
    private $slackUrl;

    /**
     * PushEvent constructor.
     * @param $payload
     * @param Config $config
     * @param SlackUrl $slackUrl
     */
    public function __construct($payload, Config $config, SlackUrl $slackUrl)
    {
        parent::__construct($payload);
        $this->payload = $payload;
        $this->config = $config;
        $this->slackUrl = $slackUrl;
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
        $commitsLimit = $this->config->get('githooks.commits.limit');


        $sender = $this->slackUrl->url($this->sender()->name(), $this->sender()->url());
        $branch = $this->slackUrl->url($this->fullBranchPath(), $this->repository()->url() . "/" . $this->branch()->name());


        //user probably created and pushed an empty branch
        if ($commitsCount === 0) {
            return $sender . ' pushed the '
                . $branch . ' branch without any commits.';
        }


        // bitbucket doesn't send more than 5 commits so we're going to limit this too
        if( $commitsCount > $commitsLimit) {
            return $this->message($sender, "5+ commits", $branch);
        }

        $commits = $commitsCount . ($commitsCount > 1 && $commitsCount <= $commitsLimit ? ' commits' : ' commit');
        return $this->message($sender, $commits, $branch);
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