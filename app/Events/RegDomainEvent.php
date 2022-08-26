<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegDomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
   public $email;
   public $name;
   public $subject;
   public $message;
   public $store;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email, $name, $subject, $message, $store)
    {
      $this->email = $email;
      $this->name = $name;
      $this->subject = $subject;
      $this->message = $message;
      $this->store = $store;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
