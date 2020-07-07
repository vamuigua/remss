<?php

namespace App\Notifications;

use App\Notice;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class NoticeSentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $notice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return explode(', ', $notifiable->notification_preference);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Notice from REMSS')
            ->line('You have a New Notice! ' . $notifiable->name)
            ->line($this->notice->subject)
            ->line($this->notice->message)
            ->action('Check Notice', url('/user/notices/' . $this->notice->id))
            ->line('Thank you for using our application!');
    }

    public function toDatabase()
    {
        return [
            'subject' => $this->notice->subject,
            'message' => $this->notice->message,
            'id' => $this->notice->id,
            'notification_type' => 'notice',
        ];
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    public function viaQueues()
    {
        return [
            'mail' => 'mail-queue',
            'database' => 'database-queue',
        ];
    }

    /**
     * Handle a notification failure.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
        Log::debug('NoticeSentNotification Failed: ' . $exception->getMessage());
    }
}
