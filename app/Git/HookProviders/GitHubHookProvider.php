<?php namespace App\Git\HookProviders;

use Illuminate\Http\Request;

class GitHubHookProvider {
    /**
     * @var Request
     */
    private $request;
    private $payload;
    private $event;
    private $signature;
    private $name;

    /**
     * GitHubHookProvider constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->name = 'github';
        $this->request = $request;
        $this->payload = $request->all();
        $this->event = $request->header('X-GitHub-Event');
        $this->secret = env('GITHUB_WEBHOOK_SECRET');
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
     * GitHub sends a X-GitHub-Event header to identify that the hook comes from them
     * @return bool
     */
    public function identify()
    {
        return $this->event() ? true : false;
    }

    /**
     * Checks verify the hook is a valid one from github
     * @return bool
     */
    public function verify()
    {
        if (!$this->signature) {
            return false;
        }
        $this->signature = explode('=', $request->header('X-Hub-Signature'))[1];
        return hash_equals($this->signature, hash_hmac('sha1', json_encode($this->request->all()), $this->secret));
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