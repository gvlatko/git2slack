<?php

namespace App\Git\Data;

class MergeRequestComment {
    private $note;
    private $url;

    /**
     * MergeRequestComment constructor.
     * @param $note
     * @param $url
     */
    public function __construct($note, $url)
    {
        $this->note = $note;
        $this->url = $url;
    }

    public function note() {
        return $this->note;
    }

    public function url() {
        return $this->url;
    }

}
