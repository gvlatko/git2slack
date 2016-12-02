<?php namespace App\Git\HookEvents\GitHub;

use App\Git\HookEvents\ReportableGitEventInterface;

class GitHubCommitCommentEvent extends GitHubEvent implements ReportableGitEventInterface
{

    private $payload;

    public function __construct($payload)
    {
        parent::__construct($payload);
        $this->payload = $payload;
    }

    /**
     * Returns Commit ID
     * @return bool
     */
    public function commitId()
    {
        return $this->payload["commit_id"];
    }

    /**
     * Returns the url where the comment can be seen
     * @return bool
     */
    public function url()
    {
        return $this->getCommentKey("html_url");
    }

    /**
     * Returns the comment body
     * @return bool
     */
    public function body()
    {
        return $this->getCommentKey("body");
    }

    private function getCommentKey($key)
    {
        if (isset($this->payload["comment"][$key])) {
            return $this->payload["comment"][$key];
        }
        return false;
    }

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {
        return $this->message(
            $this->sender()->name(),
            $this->commitId(),
            $this->body(),
            $this->fullBranchPath()
        );
    }

    /**
     * Generates a formatted message
     * @param $sender
     * @param $commit
     * @param $comment
     * @param $branch
     * @return string
     */
    private function message($sender, $commit, $comment, $branch)
    {
        return 'COMMENT: ' . $sender . ' commented \"' . $comment . '\" on commit #' . $commit . ' on ' . $branch;
    }
}