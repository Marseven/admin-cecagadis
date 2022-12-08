<?php

namespace App\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Query;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewQuerie extends Notification
{
    use Queueable;

    public $query;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Query $query)
    {
        //
        $this->query = $query;
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
            'query_id' => $this->query->id,
            'title' => "Nouvelle Requête N° " . $this->query->id,
            'content' => $this->query->title_query,
            'date' => $this->query->created_at,
            'status' => Controller::status($this->query->status),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'query_id' => $this->query->id,
            'title' => "Nouvelle Requête N° " . $this->query->id,
            'status' => Controller::status($this->query->status),
        ]);
    }
}
