<?php namespace App\Git\HookEvents\GitHub;

use App\Git\HookEvents\ReportableGitEventInterface;

class GitHubPullRequestEvent extends GitHubEvent implements ReportableGitEventInterface
{

    private $payload;

    /**
     * GitHubPullRequestEvent constructor.
     * @param $payload
     */
    public function __construct($payload)
    {
        parent::__construct($payload);
        $this->payload = $payload;
    }

    /**
     * Returns whether the pull request is merged based on GitHub Docs
     * @return bool
     */
    public function pullRequestGotMerged()
    {
        return ($this->closed() && $this->merged());
    }

    /**
     * Returns the action that happened
     * @return mixed
     */
    public function action()
    {
        return $this->payload["action"];
    }

    /**
     * Returns the pull request number
     * @return mixed
     */
    public function number()
    {
        return $this->payload["number"];
    }

    /**
     * Return this url to compare changes
     * @return bool
     */
    public function diffUrl()
    {
        return $this->getPullRequestKey("diff_url");
    }

    /**
     * Return whether pull request is merged
     * @return bool
     */
    public function merged()
    {
        return $this->getPullRequestKey("merged");
    }

    /**
     * Returns whether pull request is closed
     * @return bool
     */
    public function closed()
    {
        return $this->action() === "closed";
    }

    /**
     * Formats a name like Pull Request #123
     * @return string
     */
    public function formattedName()
    {
        return 'Pull Request #' . $this->number();
    }

    /**
     * Gets a key from the pull_request array
     * @param $key
     * @return mixed
     */
    private function getPullRequestKey($key)
    {
        if (isset($this->payload["pull_request"][$key])) {
            return $this->payload["pull_request"][$key];
        }
        return false;
    }

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {
        $sender = $this->slackUrl->url($this->sender()->url(), $this->sender()->name());
        $branch = $this->slackUrl->url($this->repository()->url() . '/' . $this->branch()->name(), $this->fullBranchPath());
        if ($this->pullRequestGotMerged()) {
            return $this->message(
                $sender,
                $this->formattedName(),
                "merged",
                $branch
            );
        }

        return $this->message(
            $sender,
            $this->formattedName(),
            $this->action(),
            $branch
        );
    }

    /**
     * Generates a formatted message
     * @param $sender
     * @param $pullRequest
     * @param $action
     * @param $branch
     * @return string
     */
    private function message($sender, $pullRequest, $action, $branch)
    {
        return 'PULL REQUEST: ' . $sender . ' ' . $action . ' ' . $pullRequest . ' on ' . $branch;
    }
}