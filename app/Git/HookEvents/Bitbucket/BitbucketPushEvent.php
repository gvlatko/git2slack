<?php namespace App\Git\HookEvents\Bitbucket;

use App\Git\Data\Commits;
use App\Git\HookEvents\ReportableGitEventInterface;
use Illuminate\Config\Repository as Config;

class BitbucketPushEvent extends BitbucketEvent implements ReportableGitEventInterface
{

    private $payload;
    /**
     * @var Config
     */
    private $config;

    /**
     * BitbucketPushEvent constructor.
     * @param $payload
     * @param Config $config
     */
    public function __construct($payload, Config $config)
    {
        parent::__construct($payload);
        $this->payload = $payload;
        $this->config = $config;
    }

    public function commits()
    {
        return new Commits(
            $this->payload["push"]["changes"][0]["commits"],
            $this->payload["push"]["changes"][0]["truncated"]
        );
    }

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {
        if ($this->commits()->truncated()) {
            return $this->message(
                $this->sender()->name(),
                "5+ commits",
                $this->fullBranchPath()
            );
        }

        $commitsCount = $this->commits()->count();
        $commitsLimit = $this->config->get('githooks.commits.limit');

        //user probably created and pushed an empty branch
        if ($commitsCount === 0) {
            return $this->sender()->name() . ' pushed the '
            . $this->fullBranchPath() . ' branch without any commits.';
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