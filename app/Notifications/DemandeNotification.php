<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Demande;

class DemandeNotification extends Notification
{
    use Queueable;
    public $demande;
    public $demandeur;
    public $serviceDestination;
    public $serviceSource;
    public $created_at_demande;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($demande)
    {
        $this->demande=$demande;     
        $this->demandeur = Demande::find($demande->id)->demandeur()->get();
        $this->serviceDestination = Demande::find($demande->id)->service_destination()->get();
        $this->serviceSource = Demande::find($demande->id)->service_source()->get();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
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
    public function toDatabase($notifiable)
    {
        return [
            'demande' => $this->demande,  
            'demandeur' => $this->demandeur,
            'serviceDestination' => $this->serviceDestination,
            'serviceSource' => $this->serviceSource,
        ];
    }
    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'demande' => $this->demande,  
            'demandeur' => $this->demandeur,
            'serviceDestination' => $this->serviceDestination,
            'serviceSource' => $this->serviceSource,
        ]);
    }
   
}
