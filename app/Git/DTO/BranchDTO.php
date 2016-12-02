<?php namespace App\Git\DTO;

class BranchDTO {

    private $branch;

    /**
     * BranchDTO constructor.
     * @param $branch
     */
    public function __construct($branch)
    {
        $this->branch = $branch;
    }

    public function name()
    {
        return $this->branch;
    }

}