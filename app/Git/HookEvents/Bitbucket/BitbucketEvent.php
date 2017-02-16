<?php namespace App\Git\HookEvents\Bitbucket;

use App\Git\Data\Branch;
use App\Git\Data\Repository;
use App\Git\Data\Sender;
use App\Git\HookEvents\GitEventInterface;

class BitbucketEvent implements GitEventInterface
{
    /**
     * @var
     */
    private $payload;

    /**
     * BitbucketEvent constructor.
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
        return new Repository(
            $this->payload["repository"]["full_name"],
            $this->payload["repository"]["links"]["html"]["href"],
            $this->branch()
        );
    }

    /**
     * Returns the Branch Details
     * @return Branch
     */
    public function branch()
    {
        $branch = $this->payload["push"]["changes"][0]["new"] !== null
            ? $this->payload["push"]["changes"][0]["new"]["name"]
            : $this->payload["push"]["changes"][0]["old"]["name"];
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
            $this->payload["actor"]["username"],
            $this->payload["actor"]["links"]["avatar"],
            $this->payload["actor"]["links"]["html"]
        );
    }
}