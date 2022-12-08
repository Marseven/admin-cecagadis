<?php

namespace App\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Refill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefillDo extends Notification
{
    use Queueable;

    public $refill;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Refill $refill)
    {
        //
        $this->refill = $refill;
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
            'refill_id' => $this->refill->id,
            'title' => "Commande de Recharge Traitée",
            'content' => "Votre commande de Recharge N° " . $this->refill->reference . " a été traitée avec succès. Merci pour votre confiance.",
            'date' => $this->refill->updated_at,
            'status' => Controller::status($this->refill->status),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'refill_id' => $this->refill->id,
            'title' => "Commande de Recharge Traitée",
            'status' => Controller::status($this->refill->status),
        ]);
    }
}
