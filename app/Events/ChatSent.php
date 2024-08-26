<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class ChatSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $reciver;
    public string $message;
    /**
     * Create a new event instance.
     */
    public function __construct(User $reciver,string $message)
    {
$this->reciver = $reciver;
$this->message=$message;
 }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
{
    return new PrivateChannel('private-' . $this->reciver->id);
}

    public function  broadcastAs(){
        return 'ChatSent';
    }
}
