<?php namespace App\Git\HookEvents\GitHub;

use App\Git\Data\Branch;
use App\Git\Data\Formatters\PullRequestSlackFormatter;
use App\Git\Data\Repository;
use App\Git\Data\Sender;
use App\Git\HookEvents\GitPullRequestInterface;
use App\Git\HookEvents\ReportableGitEventInterface;

class GitHubPullRequestEvent implements GitPullRequestInterface, ReportableGitEventInterface
{
    /**
     * @var
     */
    private $payload;


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
        return strtolower($this->getPayloadKey("action"));
    }

    public function number()
    {
        return $this->getPullRequestKey("number");
    }

    public function title()
    {
        return $this->getPullRequestKey("title");
    }

    public function url()
    {
        return $this->getPullRequestKey("html_url");
    }

    public function formattedTitle()
    {
        return '[PR #' . $this->number() . '] ' . $this->title();
    }

    public function description()
    {
        return $this->getPullRequestKey("body");
    }

    public function repository()
    {
        $payloadRepository = $this->getPayloadKey("repository");
        return new Repository(
            $payloadRepository["full_name"],
            $payloadRepository["html_url"]
        );
    }

    public function branch()
    {
        $payloadBranch = $this->getPullRequestKey("head");
        return new Branch(
            $payloadBranch["ref"]
        );
    }

    public function sender()
    {
        $payloadSender = $this->getPayloadKey("sender");
        return new Sender(
            $payloadSender["login"],
            $payloadSender["avatar_url"],
            $payloadSender["html_url"]
        );
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