<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VasChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatId;
    public $message;
    public $usersName;
    public $businesssName;
    public $textTime;
    public $sendUserId;

    public function __construct($chatId,$message,$usersName, $businesssName, $textTime,$sendUserId)
    {
        $this->chatId = $chatId;
        $this->message = $message;
        $this->usersName = $usersName;
        $this->businesssName = $businesssName;
        $this->textTime = $textTime;
        $this->sendUserId = $sendUserId;
    }

    public function broadcastOn(): array
    {
        return ['vas-chat-'.$this->chatId];
    }

    public function broadcastAs()
    {
        return 'message-sent';
    }
}
