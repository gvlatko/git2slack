<?php namespace App\Git\HookEvents;

use App\Git\DTO\BranchDTO;
use App\Git\DTO\RepositoryDTO;
use App\Git\DTO\SenderDTO;

interface GitEventInterface
{

    /**
     * GitEventInterface constructor.
     * @param $payload
     */
    public function __construct($payload);

    /**
     * Returns the Repository Details
     * @return RepositoryDTO
     */
    public function repository();

    /**
     * Returns the Branch Details
     * @return BranchDTO
     */
    public function branch();

    /**
     * Returns the path to the branch (repository/branch)
     * @return string
     */
    public function fullBranchPath();

    /**
     * Returns Sender Details
     * @return SenderDTO
     */
    public function sender();

}