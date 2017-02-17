<?php namespace App\Git\HookEvents\Gitlab;

use App\Git\Data\Branch;
use App\Git\Data\Repository;
use App\Git\Data\Sender;
use App\Git\HookEvents\GitEventInterface;

class GitlabEvent implements GitEventInterface
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
            $this->payload["project"]["path_with_namespace"],
            $this->payload["repository"]["homepage"],
            $this->branch()
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
            $this->payload["user_name"],
            $this->payload["user_avatar"],
            'https://gitlab.com/' . $this->payload["user_name"]
        );
    }
}