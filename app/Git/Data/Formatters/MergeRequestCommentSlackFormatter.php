<?php

namespace App\Git\Data\Formatters;

use App\Git\HookEvents\GitMergeRequestCommentInterface;

class MergeRequestCommentSlackFormatter implements GitDataFormatterInterface {
    /**
     * @var GitMergeRequestCommentInterface
     */
    private $mergeRequestComment;


    /**
     * MergeRequestCommentSlackFormatter constructor.
     * @param GitMergeRequestCommentInterface $mergeRequestComment
     */
    public function __construct(GitMergeRequestCommentInterface $mergeRequestComment)
    {
        $this->mergeRequestComment = $mergeRequestComment;
    }


    private function slackLink($url, $text)
    {
        return '<' . $url . '|' . $text . '>';
    }

    public function format()
    {
        $mergeRequestUrl = $this->slackLink(
            $this->mergeRequestComment->url(),
            $this->mergeRequestComment->formattedTitle()
        );

        $repositoryUrl = $repositoryUrl = $this->slackLink(
            $this->mergeRequestComment->repository()->url(),
            $this->mergeRequestComment->repository()->name()
        );

        $commentUrl = $this->slackLink(
            $this->mergeRequestComment->comment()->url(),
            $this->mergeRequestComment->comment()->note()
        );


        return [
            'title' => '[' . $repositoryUrl . '] ' .$this->mergeRequestComment->sender()->name() . ' commented: *' . $commentUrl . '*',
            'description' => '', //$this->mergeRequestComment->description(),
            'url' => $this->mergeRequestComment->url(),
//            'action' => strtoupper('PR ' . $this->pullRequestEvent->number() . ' ' . $this->pullRequestEvent->action()),
            'action' => $mergeRequestUrl
        ];
    }
}