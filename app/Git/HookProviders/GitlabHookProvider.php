<?php

namespace App\Git\HookProviders;

use Illuminate\Http\Request;

class GitlabHookProvider implements HookProviderInterface{
    /**
     * @var Request
     */
    private $request;
    private $name;
    private $payload;
    private $event;


    /**
     * GitlabHookProvider constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->name = "gitlab";
        $this->request = $request;
        $this->payload = $request->all();
        $this->event = $request->header('X-Gitlab-Event');
    }


    /**
     * Name of this provider
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Identify that the hook comes from proper source
     * @return bool
     */
    public function identify()
    {
        return (bool)$this->event();
    }

    /**
     * Checks verify the hook is a valid one
     * @return bool
     */
    public function verify()
    {
        return true;
    }

    /**
     * Returns the event that occurred
     * @return array|string
     */
    public function event()
    {
        return $this->event;
    }

    /**
     * Returns the payload of the event
     * @return array
     */
    public function payload()
    {
        return $this->payload;
    }
}