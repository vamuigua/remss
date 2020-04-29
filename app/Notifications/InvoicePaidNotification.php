<?php

namespace App\Notifications;

use App\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvoicePaidNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $payment;
    public $user_route;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment, $user_route)
    {
        $this->payment = $payment;
        $this->user_route = $user_route;
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
                    ->subject('Invoice Paid from REMSS')
                    ->line('Invoice No' . $this->payment->invoice->invoice_no)
                    ->line('Payment No' . $this->payment->payment_no)
                    ->line('Amount Paid' . $this->payment->amount_paid)
                    ->action('Check Payment', url('/'.$this->user_route.'/payments/' . $this->payment->id))
                    ->line('Thank you for using REMSS Payment platform!');
    }

    public function toDatabase()
    {
        return [
            'subject' => 'Invoice Paid from REMSS!',
            'id' => $this->payment->id,
            'notification_type' => 'invoice paid',
        ];
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
