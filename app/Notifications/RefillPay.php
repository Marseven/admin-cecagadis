<?php

namespace App\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefillPay extends Notification
{
    use Queueable;

    public $payment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        //
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
            'payment_id' => $this->payment->id,
            'title' => "Paiment Pour la commande de recharge N°" . $this->payment->reference_refill,
            'content' => "Féliciations, vous avez payé " . $this->payment->amount . " FCFA pour une commande de recharge d'une carte prépayé " . $this->payment->bank . ".",
            'date' => $this->payment->paid_at,
            'status' => Controller::status($this->payment->status),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'payment_id' => $this->payment->id,
            'title' => "Paiment Pour la commande de recharge N°" . $this->payment->reference_refill,
            'status' => Controller::status($this->payment->status),
        ]);
    }
}
