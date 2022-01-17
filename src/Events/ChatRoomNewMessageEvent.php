<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Events;

use Garbuzivan\LaravelUserChat\Broadcasting\ChatManagerChannel;
use Garbuzivan\LaravelUserChat\Exceptions\ChatRoomNotLoad;
use Garbuzivan\LaravelUserChat\Models\ChatMessage;
use Garbuzivan\LaravelUserChat\Pipeline\MessagePipeline;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatRoomNewMessageEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public object $user;
    public ChatMessage $message;

    /**
     * Create a new event instance.
     *
     * @return void
     * @throws ChatRoomNotLoad
     */
    public function __construct(MessagePipeline $data)
    {
        $this->user = $data->manager->getRoomUser()->toArray();
        $this->message = $data->message;
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
