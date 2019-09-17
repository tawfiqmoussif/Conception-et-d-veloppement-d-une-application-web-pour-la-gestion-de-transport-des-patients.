<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Demande;
use App\User;

class NewDemande
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $demande;
    public $brancardier;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Demande $demande)
    {
        $this->demande=$demande;     
        $this->brancardier=User::find(2)->get();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('demandes.'.$this->brancardier);
    }

    public function broadcastWith()
    {
        return ["demande" => $this->demande];
    }
}
