<?php namespace App\Http\Controllers;

use App\Channels;
use App\Notifications\Slack\GitEventOccured;
use App\Notifications\Slack\SlackNotifiable;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Notifications\ChannelManager;

class GitEventsController extends Controller {
    /**
     * @var Config
     */
    private $config;
    /**
     * @var ChannelManager
     */
    private $notification;

    /**
     * GitEventsController constructor.
     * @param Config $config
     * @param ChannelManager $notification
     */
    public function __construct(Config $config, ChannelManager $notification)
    {
        $this->config = $config;
        $this->notification = $notification;
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
        if($eventHandler) {
            $event = new $eventHandler($provider->payload());
            $url = $this->config->get('githooks.slack.webhook_url');
            $channel = Channels::where('repository', '=', $event->repository()->name())->first();
            if($channel) {
                $this->notification->send(new SlackNotifiable($url), new GitEventOccured($event, $channel->destination()));
            }
        }

    }

}