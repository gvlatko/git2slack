<?php namespace App\Git\DTO;

class RepositoryDTO {

    private $name;
    private $url;

    /**
     * RepositoryDTO constructor.
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
