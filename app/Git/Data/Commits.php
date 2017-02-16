<?php namespace App\Git\Data;

class Commits {

    private $commits;
    /**
     * @var bool
     */
    private $truncated;
    private $url;

    /**
     * Commits constructor.
     * @param $commits
     * @param $url
     * @param bool $truncated
     */
    public function __construct($commits, $url, $truncated = false)
    {
        $this->commits = $commits;
        $this->truncated = $truncated;
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function commits()
    {
        return $this->commits;
    }

    public function count()
    {
        return count($this->commits());
    }

    public function truncated()
    {
        return $this->truncated;
    }

    public function url()
    {
        return $this->url;
    }

}