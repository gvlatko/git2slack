<?php namespace App\Git\DTO;

class SenderDTO {
    private $avatar;
    private $name;
    private $url;

    /**
     * SenderDTO constructor.
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