<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $agentId;

    public function __construct(Message $message, $agentId)
    {
        $this->message = $message;
        $this->agentId = $agentId;
    }

    public function broadcastOn()
    {
        return [new Channel("messages.agent.{$this->agentId}")];
    }

    public function broadcastAs()
    {
        return 'message.created';
    }
}
