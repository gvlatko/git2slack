<?php namespace App\Git\HookProviders;

use Illuminate\Http\Request;

class BitbucketHookProvider {
    /**
     * @var Request
     */
    private $request;

    private $payload;
    private $name;
    private $event;

    /**
     * BitbucketHokkProvider constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->name = 'bitbucket';
        $this->request = $request;
        $this->payload = $request->all();
        $this->event = $request->header('X-Event-Key');
    }

    public function name()
    {
        return $this->name;
    }

    public function identify()
    {
        return $this->event ? true : false;
    }

    public function verify()
    {
        // bitbucket doesn't sign payloads
        return true;
    }

    public function event()
    {
        return $this->event;
    }

    public function payload()
    {
        return $this->payload;
    }
}
