<?php namespace App\Git\Data;

class Branch {

    private $name;

    /**
     * Branch constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }

}