<?php

namespace App\Notifications;

use App\Git\HookEvents\ReportableGitEventInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Config\Repository as Config;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class GitEventOccured extends Notification
{
//    use Queueable;
    /**
     * @var ReportableGitEventInterface
     */
    private $event;
    /**
     * @var
     */
    private $channel;

    /**
     * Create a new notification instance.
     *
     * @param ReportableGitEventInterface $event
     * @param $channel
     */
    public function __construct(ReportableGitEventInterface $event, $channel)
    {
        $this->event = $event;
        $this->channel = $channel;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSlack($notifiable)
    {

        return (new SlackMessage)
                    ->success()
                    ->to($this->channel)
                    ->content($this->event->report());

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
