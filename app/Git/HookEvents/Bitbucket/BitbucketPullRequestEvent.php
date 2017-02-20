<?php namespace App\Git\HookEvents\Bitbucket;

use App\Git\Data\Branch;
use App\Git\Data\Formatters\PullRequestSlackFormatter;
use App\Git\Data\Repository;
use App\Git\Data\Sender;
use App\Git\HookEvents\GitPullRequestInterface;
use App\Git\HookEvents\ReportableGitEventInterface;

class BitbucketPullRequestEvent implements GitPullRequestInterface, ReportableGitEventInterface
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
        $action = strtolower($this->getPullRequestKey("state"));

        if($action === "open"){
            $action .= "ed";
        }

        return $action;
    }

    public function number()
    {
        return $this->getPullRequestKey("id");
    }

    public function title()
    {
        return $this->getPullRequestKey("title");
    }

    public function url()
    {
        return $this->getPullRequestKey("links")["html"]["href"];
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
        $payloadRepository = $this->getPullRequestKey("destination")["repository"];
        return new Repository(
            $payloadRepository["full_name"],
            $payloadRepository["links"]["html"]["href"]
        );
    }

    public function branch()
    {
        $payloadBranch = $this->getPullRequestKey("destination")["branch"];
        return new Branch(
            $payloadBranch["name"]
        );
    }

    public function sender()
    {
        $payloadSender = $this->getPayloadKey("actor");
        return new Sender(
            $payloadSender["display_name"],
            $payloadSender["links"]["avatar"]["href"],
            $payloadSender["links"]["html"]["href"]
        );
    }

    /**
     * Gets a key from the pull_request array
     * @param $key
     * @return mixed
     */
    private function getPullRequestKey($key)
    {
        if (isset($this->payload["pullrequest"][$key])) {
            return $this->payload["pullrequest"][$key];
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