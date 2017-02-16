<?php namespace App\Git\Data;

class Repository {

    private $name;
    private $url;
    /**
     * @var Branch
     */
    private $branch;

    /**
     * Repository constructor.
     * @param $name
     * @param $url
     * @param Branch $branch
     */
    public function __construct($name, $url, Branch $branch)
    {
        $this->name = $name;
        $this->url = $url;
        $this->branch = $branch;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    public function branch()
    {
        return $this->branch;
    }
    /**
     * @return string
     */
    public function url()
    {
        return $this->url . '/'. $this->branch->name();
    }

}
