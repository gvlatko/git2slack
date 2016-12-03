<?php namespace App\Git\HookEvents;

use App\Git\Data\Branch;
use App\Git\Data\Repository;
use App\Git\Data\Sender;

interface GitEventInterface
{

    /**
     * GitEventInterface constructor.
     * @param $payload
     */
    public function __construct($payload);

    /**
     * Returns the Repository Details
     * @return Repository
     */
    public function repository();

    /**
     * Returns the Branch Details
     * @return Branch
     */
    public function branch();

    /**
     * Returns the path to the branch (repository/branch)
     * @return string
     */
    public function fullBranchPath();

    /**
     * Returns Sender Details
     * @return Sender
     */
    public function sender();

}