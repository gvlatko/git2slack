<?php

namespace App\Notifications;

use Illuminate\Notifications\Notifiable;

class SlackNotifiable {

    use Notifiable;
    private $webhook_url;

    /**
     * SlackNotifiable constructor.
     * @param $webhook_url
     */
    function __construct($webhook_url)
    {
        $this->webhook_url = $webhook_url;
    }

    public function routeNotificationForSlack()
    {
        return $this->webhook_url;
    }
}