<?php

namespace App\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRequest extends Notification
{
    use Queueable;

    public $request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'request_id' => $this->request->id,
            'title' => "Nouvel Achat de Carte Prépayée - N° " . $this->request->id,
            'content' => "Nouvel achat de carte prépayée " . $this->request->bank . " N° " . $this->request->r_reference . " .",
            'date' => $this->request->updated_at,
            'status' => Controller::status($this->request->status),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'request_id' => $this->request->id,
            'title' => "Nouvel Achat de Carte Prépayée - N° " . $this->request->id,
            'status' => Controller::status($this->request->status),
        ]);
    }
}
