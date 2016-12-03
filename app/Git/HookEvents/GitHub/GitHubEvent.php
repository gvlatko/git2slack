<?php namespace App\Git\HookEvents\GitHub;

use App\Git\Data\Branch;
use App\Git\Data\Repository;
use App\Git\Data\Sender;
use App\Git\HookEvents\GitEventInterface;


class GitHubEvent implements GitEventInterface
{
    private $payload;

    /**
     * GitEventInterface constructor.
     * @param $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Returns the Repository Details
     * @return Repository
     */
    public function repository()
    {
        return new Repostory(
            $this->payload["repository"]["name"],
            $this->payload["repository"]["html_url"]
        );
    }

    /**
     * Returns the Branch Details
     * @return Branch
     */
    public function branch()
    {
        $refs = explode("/", $this->payload["ref"]);
        $branch = $refs[count($refs) - 1];
        return new Branch(
            $branch
        );
    }

    /**
     * Returns the path to the branch (repository/branch)
     * @return string
     */
    public function fullBranchPath()
    {
        return $this->repository()->name() . '/' . $this->branch()->name();
    }

    /**
     * Returns Sender Details
     * @return Sender
     */
    public function sender()
    {
        return new Sender(
          $this->payload["sender"]["login"],
          $this->payload["sender"]["avatar_url"],
          $this->payload["repository"]["html_url"]
        );
    }

}