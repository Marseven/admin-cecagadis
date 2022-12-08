<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Données pour la vue

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (isset($this->data->r_reference)) {
            return $this->from($this->data->email, $this->data->firstname . ' ' . $this->data->lastname) // L'expéditeur
                ->subject('Nouvelle demande N° ' . $this->data->r_reference) // Le sujet
                ->markdown('request_card.mail_notif')
                ->with('data', $this->data);
        } else {
            return $this->from("rechargevisa@digitech-africa.com") // L'expéditeur
                ->subject('Nouvelle recharge N° ' . $this->data->reference) // Le sujet
                ->markdown('refills.mail_notif')
                ->with('data', $this->data);
        }
    }
}
