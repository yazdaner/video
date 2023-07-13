<?php

namespace Yazdan\User\Notifications;

use Illuminate\Bus\Queueable;
use Yazdan\User\Mail\VerifyCodeMail;
use Illuminate\Notifications\Notification;
use Yazdan\User\Services\VerifyMailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class verifyMailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $code = VerifyMailService::generateCode();

        VerifyMailService::cacheSet($notifiable->id,$code);

        return (new VerifyCodeMail($code))
        ->to($notifiable->email);
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
