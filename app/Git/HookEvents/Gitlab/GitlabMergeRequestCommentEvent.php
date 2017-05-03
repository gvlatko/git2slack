<?php

namespace App\Git\HookEvents\Gitlab;

use App\Git\Data\Branch;
use App\Git\Data\Formatters\MergeRequestCommentSlackFormatter;
use App\Git\Data\Repository;
use App\Git\Data\Sender;
use App\Git\HookEvents\GitMergeRequestCommentInterface;
use App\Git\HookEvents\ReportableGitEventInterface;
use App\Git\Data\MergeRequestComment;

class GitlabMergeRequestCommentEvent implements GitMergeRequestCommentInterface, ReportableGitEventInterface{
    /**
     * @var
     */
    private $payload;


    /**
     * GitlabMergeRequestCommentEvent constructor.
     * @param $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function comment()
    {
        return new MergeRequestComment(
            $this->payload['object_attributes']['note'],
            $this->payload['object_attributes']['url']
        );
    }

    public function sender() {
        $payloadSender = $this->payload["user"];
        return new Sender(
            $payloadSender["name"],
            $payloadSender["avatar_url"],
            'http://gitlab.com/' . $payloadSender["username"]
        );
    }


    private function commentBelongsToMergeRequest()
    {
        return $this->payload['object_attributes']['noteable_type'] === 'MergeRequest';
    }



    public function number()
    {
        return $this->payload['merge_request']['iid'];
    }

    public function title()
    {
        return $this->payload['merge_request']['title'];
    }

    public function url()
    {
        return $this->payload['merge_request']['target']['web_url'];
    }

    public function formattedTitle()
    {
        return '[PR #' . $this->number() . '] ' . $this->title();
    }

    public function repository()
    {
        $payloadRepository = $this->payload['merge_request']['target'];
        return new Repository(
            $payloadRepository["path_with_namespace"],
            $payloadRepository["web_url"]
        );
    }

    public function branch()
    {
        return new Branch(
            $this->payload['merge_request']['target_branch']
        );
    }


    /**
     * Generates a message about what happened in the event
     * @return mixed
     */
    public function report()
    {

        if (!$this->commentBelongsToMergeRequest()) return false;

        $formatter = new MergeRequestCommentSlackFormatter($this);
        return $formatter->format();

        // TODO: Implement report() method.
    }

}