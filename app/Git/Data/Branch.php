<?php namespace App\Git\Data;

class Branch {

    private $branch;

    /**
     * Branch constructor.
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