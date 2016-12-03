<?php namespace App\Git\Data;

class Sender {
    private $avatar;
    private $name;
    private $url;

    /**
     * Sender constructor.
     * @param $name
     * @param $avatar
     * @param $url
     */
    public function __construct($name, $avatar, $url)
    {
        $this->avatar = $avatar;
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function avatar()
    {
        return $this->avatar;
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