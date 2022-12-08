<?php

namespace App\Notifications;

use App\Http\Controllers\BasicController;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Refill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOffer extends Notification
{
    use Queueable;

    public $offer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Offer $offer)
    {
        //
        $this->offer = $offer;
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

    public function toArray($notifiable)
    {
        return [
            'offer_id' => $this->offer->id,
            'title' => "Nouvelle offre d\'emploi N° " . $this->offer->id,
            'content' => "Nouvelle offre d\'emploi N° " . $this->offer->id . ".",
            'date' => $this->offer->updated_at,
            'status' => BasicController::status($this->offer->status),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'offer_id' => $this->offer->id,
            'title' => "Nouvelle offre d\'emploi N° " . $this->offer->id,
            'status' => BasicController::status($this->offer->status),
        ]);
    }
}
