<?php namespace App\Git\Data;

class Repository {

    private $name;
    private $url;

    /**
     * Repository constructor.
     * @param $name
     * @param $url
     */
    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function url()
    {
        return $this->url;
    }

}
