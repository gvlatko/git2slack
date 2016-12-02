<?php namespace App\Git\HookEvents\GitHub;

use App\Git\HookEvents\ReportableGitEventInterface;

class GitHubPullRequestCommentEvent extends GitHubEvent implements ReportableGitEventInterface
{

    private $payload;

    public function __construct($payload)
    {
        parent::__construct($payload);
        $this->payload = $payload;
    }

    /**
     * Returns the file that's commented on
     * @return string
     */
    public function file()
    {
        return $this->payload["path"];
    }

    /**
     * Returns the url to the comment
     * @return bool
     */
    public function url()
    {
        return $this->getCommentKey("html_url");
    }

    /**
     * Return the comment body
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
     * Returns a formatted string like Pull Request #123
     * @return string
     */
    private function pullRequest()
    {
        return 'Pull Request #' . $this->payload["pull_request"]["number"];
    }

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {
        return $this->message(
            $this->sender()->name(),
            $this->pullRequest(),
            $this->body(),
            $this->fullBranchPath()
        );
    }

    /**
     * Generates a formatted message
     * @param $sender
     * @param $pullRequest
     * @param $comment
     * @param $branch
     * @return string
     */
    private function message($sender, $pullRequest, $comment, $branch)
    {
        return 'PULL REQUEST COMMENT: ' . $sender . ' commented \"' . $comment . '\" on ' . $pullRequest . ' on ' . $branch;
    }
}