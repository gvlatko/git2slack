<?php

namespace App\Git\Data;

class PullRequest {

    private $payload;

    /**
     * PullRequest constructor.
     * @param $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload["pull_request"];
    }


}