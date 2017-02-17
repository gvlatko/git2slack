<?php

namespace App\Git\Data\Formatters;

use App\Git\Data\Branch;
use App\Git\Data\Commits;
use App\Git\Data\Repository;
use App\Git\Data\Sender;

class CommitsSlackFormatter implements GitDataFormatterInterface {
    /**
     * @var Commits
     */
    private $commits;

    const COMMITS_LIMIT = 5;
    /**
     * @var Branch
     */
    private $branch;
    /**
     * @var Sender
     */
    private $sender;
    /**
     * @var Repository
     */
    private $repository;

    /**
     * CommitsSlackFormatter constructor.
     * @param Commits $commits
     * @param Sender $sender
     * @param Branch $branch
     * @param Repository $repository
     */
    public function __construct(Commits $commits, Sender $sender, Branch $branch, Repository $repository)
    {
        $this->commits = $commits;
        $this->branch = $branch;
        $this->sender = $sender;
        $this->repository = $repository;
    }

    public function format()
    {
        $commitsCount = $this->commits->count();
        $commitsLimit = self::COMMITS_LIMIT;

        $repositoryUrl = $this->slackLink($this->repository->url() . '/' . $this->branch->name(), $this->repository->name() . '/' . $this->branch->name());

        //user probably created and pushed an empty branch
        if ($commitsCount === 0) {
            return $this->sender->name() . ' pushed the '
            . $repositoryUrl . ' branch without any commits.';
        }


        // bitbucket doesn't send more than 5 commits so we're going to limit this too
        if( $commitsCount > $commitsLimit) {
            $commitsUrl = $this->slackLink($this->commits->url(), '5+ commits');
            return $this->message($this->sender->name(), $commitsUrl, $repositoryUrl);
        }

        $commitsCount = $commitsCount . ($commitsCount > 1 ? ' commits' : ' commit');
        $commitsUrl = $this->slackLink($this->commits->url(), $commitsCount);
        return $this->message($this->sender->name(), $commitsUrl, $repositoryUrl);
    }

    private function slackLink($url, $text)
    {
        return '<' . $url . '|' . $text . '>';
    }

    /**
     * Generates a formatted message
     * @param $sender
     * @param $commits
     * @param $repository
     * @return string
     * @internal param $branch
     */
    private function message($sender, $commits,  $repository)
    {
        return 'COMMIT: ' . $sender . ' pushed ' .  $commits . ' to ' . $repository;
    }
}