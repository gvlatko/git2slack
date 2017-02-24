<?php namespace App\Git\HookEvents\Gitlab;

use App\Git\Data\Branch;
use App\Git\Data\Formatters\PullRequestSlackFormatter;
use App\Git\Data\Repository;
use App\Git\Data\Sender;
use App\Git\HookEvents\GitPullRequestInterface;
use App\Git\HookEvents\ReportableGitEventInterface;

class GitlabPullRequestEvent implements GitPullRequestInterface, ReportableGitEventInterface
{
    /**
     * @var
     */
    private $payload;

    private $actions = [
        'open' => 'opened',
        'merge' => 'merged',
        'decline' => 'declined'
    ];

    /**
     * GitHubPullRequestEvent constructor.
     * @param $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function action()
    {
        $action = strtolower($this->getPullRequestKey("state"));

        if(isset($this->actions[$action])) {
            return $this->actions[$action];
        }

        return $action;
    }

    public function number()
    {
        return $this->getPullRequestKey("iid");
    }

    public function title()
    {
        return $this->getPullRequestKey("title");
    }

    public function url()
    {
        return $this->getPullRequestKey("url");
    }

    public function formattedTitle()
    {
        return '[PR #' . $this->number() . '] ' . $this->title();
    }

    public function description()
    {
        return $this->getPullRequestKey("description");
    }

    public function repository()
    {
        $payloadRepository = $this->getPullRequestKey("target");
        return new Repository(
            $payloadRepository["path_with_namespace"],
            $payloadRepository["web_url"]
        );
    }

    public function branch()
    {
        return new Branch(
            $this->getPullRequestKey("target_branch")
        );
    }

    public function sender()
    {
        $payloadSender = $this->getPayloadKey("user");
        return new Sender(
            $payloadSender["name"],
            $payloadSender["avatar_url"],
            'http://gitlab.com/' . $payloadSender["username"]
        );
    }

    /**
     * Gets a key from the pull_request array
     * @param $key
     * @return mixed
     */
    private function getPullRequestKey($key)
    {
        if (isset($this->payload["object_attributes"][$key])) {
            return $this->payload["object_attributes"][$key];
        }
        return false;
    }

    private function getPayloadKey($key)
    {
        if (isset($this->payload[$key])) {
            return $this->payload[$key];
        }
        return false;
    }

    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {
        $formatter = new PullRequestSlackFormatter($this);
        return $formatter->format();
    }

}