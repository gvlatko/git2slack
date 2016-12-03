<?php namespace App\Git\Data;

class Diff {

    private $url;

    /**
     * Diff constructor.
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