<?php

namespace App\Git\Data\Formatters;

use App\Git\HookEvents\GitPullRequestInterface;

class PullRequestSlackFormatter implements GitDataFormatterInterface {
    /**
     * @var GitPullRequestInterface
     */
    private $pullRequestEvent;


    /**
     * PullRequestSlackFormatter constructor.
     * @param GitPullRequestInterface $pullRequestEvent
     */
    public function __construct(GitPullRequestInterface $pullRequestEvent)
    {
        $this->pullRequestEvent = $pullRequestEvent;
    }

    public function format()
    {


        $pullRequestUrl = $this->slackLink(
          $this->pullRequestEvent->url(),
            $this->pullRequestEvent->formattedTitle()
        );

        $repositoryUrl = $repositoryUrl = $this->slackLink(
            $this->pullRequestEvent->repository()->url(),
            $this->pullRequestEvent->repository()->name()
        );

        $slackTitle = $pullRequestUrl . ' has been ' . $this->pullRequestEvent->action()
        . ' on ' . $repositoryUrl ;

        return [
            'title' => '[' . $repositoryUrl . '] ' .$this->pullRequestEvent->sender()->name() . ' has ' . $this->pullRequestEvent->action() . ' a pull request.',
            'description' => $this->pullRequestEvent->description(),
            'url' => $this->pullRequestEvent->url(),
//            'action' => strtoupper('PR ' . $this->pullRequestEvent->number() . ' ' . $this->pullRequestEvent->action()),
            'action' => $pullRequestUrl
        ];
    }

    private function slackLink($url, $text)
    {
        return '<' . $url . '|' . $text . '>';
    }
}