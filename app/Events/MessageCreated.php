<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('messages.' . $this->message->log_id);
    
        Log::info('Broadcasting message.created to channel: messages.' . $this->message->log_id);
    }

    public function broadcastAs()
    {
        return 'message.created'; // Specify event name here
    }
}
