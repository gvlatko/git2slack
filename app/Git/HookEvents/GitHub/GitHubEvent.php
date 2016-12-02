<?php namespace App\Git\HookEvents\GitHub;

use App\Git\DTO\BranchDTO;
use App\Git\DTO\RepositoryDTO;
use App\Git\DTO\SenderDTO;
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
     * @return RepositoryDTO
     */
    public function repository()
    {
        return new RepositoryDTO(
            $this->payload["repository"]["name"],
            $this->payload["repository"]["html_url"]
        );
    }

    /**
     * Returns the Branch Details
     * @return BranchDTO
     */
    public function branch()
    {
        $refs = explode("/", $this->payload["ref"]);
        $branch = $refs[count($refs) - 1];
        return new BranchDTO(
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
     * @return SenderDTO
     */
    public function sender()
    {
        return new SenderDTO(
          $this->payload["sender"]["login"],
          $this->payload["sender"]["avatar_url"],
          $this->payload["repository"]["html_url"]
        );
    }

}