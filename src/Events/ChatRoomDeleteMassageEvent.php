<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Events;

use Garbuzivan\LaravelUserChat\Broadcasting\ChatManagerChannel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatRoomDeleteMassageEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public int $deleteMessageID;
    public object $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $deleteMessageID, object $user)
    {
        $this->deleteMessageID = $deleteMessageID;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel(ChatManagerChannel::NAME . '.' . $this->user->id);
    }
}
