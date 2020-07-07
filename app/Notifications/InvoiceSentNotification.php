<?php

namespace App\Notifications;

use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Exception;

class InvoiceSentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $invoice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
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
            ->subject('New Invoice from REMSS')
            ->line('You have a New Invoice!.')
            ->action('Check Invoice', url('/admin/invoices/' . $this->invoice->id))
            ->line('Thank you for using our application!');
    }

    public function toDatabase()
    {
        return [
            'subject' => 'You have a New Invoice!',
            'id' => $this->invoice->id,
            'notification_type' => 'invoice sent',
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
        Log::debug('InvoiceSentNotification Failed: ' . $exception->getMessage());
    }
}
