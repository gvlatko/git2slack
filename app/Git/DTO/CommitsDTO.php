<?php namespace App\Git\DTO;

class CommitsDTO {

    private $commits;
    /**
     * @var bool
     */
    private $truncated;

    /**
     * CommitsDTO constructor.
     * @param $commits
     * @param bool $truncated
     */
    public function __construct($commits, $truncated = false)
    {
        $this->commits = $commits;
        $this->truncated = $truncated;
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

}