<?php namespace App\Git\DTO;

class DiffDTO {

    private $url;

    /**
     * DiffDTO constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    public function url()
    {
        return $this->url;
    }
}