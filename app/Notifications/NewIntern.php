<?php

namespace App\Notifications;

use App\Http\Controllers\BasicController;
use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Offer;
use App\Models\Refill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewIntern extends Notification
{
    use Queueable;

    public $intern;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Contract $intern)
    {
        //
        $this->intern = $intern;
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
            'intern_id' => $this->intern->id,
            'title' => "Nouvelle offre d\'emploi N° " . $this->intern->id,
            'content' => "Nouvelle offre d\'emploi N° " . $this->intern->id . ".",
            'date' => $this->intern->updated_at,
            'status' => BasicController::status($this->intern->status),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'intern_id' => $this->intern->id,
            'title' => "Nouvelle offre d\'emploi N° " . $this->intern->id,
            'status' => BasicController::status($this->intern->status),
        ]);
    }
}
