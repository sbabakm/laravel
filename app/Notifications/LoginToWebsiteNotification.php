<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginToWebsiteNotification extends Notification implements shouldQueue
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
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');

//        return (new MailMessage)
//            ->subject('اطلاع رسانی خوش آمدگویی به وب سایت')
//            ->line('خوش آمدید')
//            ->action('انتقال به وب سایت', url('/'))
//            ->line('تشکر از شما');

//        return (new MailMessage)
//            ->subject('اطلاع رسانی خوش آمدگویی به وب سایت')
//            ->view('emails.login-to-website');
//    }

        return (new MailMessage)
            ->subject('اطلاع رسانی خوش آمدگویی به وب سایت')
            ->markdown('emails.login-to-website2');
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
