<?php namespace App\Http\Controllers;

use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;

class GitEventsController extends Controller {
    /**
     * @var Config
     */
    private $config;

    /**
     * GitEventsController constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function handlePayload(Request $request)
    {

        $providers = collect($this->config->get('githooks.providers'));

        $provider = $providers->filter(function($provider) use ($request) {
            $currentProvider = new $provider($request);
            if (!$currentProvider->identify()) {
                return false;
            }

            if (!$currentProvider->verify()) {
                return false;
            }

            return $currentProvider;
        })->first();

        $provider = new $provider($request);

        $eventHandler = $this->config->get('githooks.events.' . $provider->name() . '.' . $provider->event());
        \Log::info("EVENT: " . $provider->event() . " " . $eventHandler);
        if($eventHandler) {
            $event = new $eventHandler($provider->payload(), $this->config);

            \Log::info($event->report());
        }

    }

}