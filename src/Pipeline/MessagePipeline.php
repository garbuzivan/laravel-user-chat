<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Pipeline;

use Garbuzivan\LaravelUserChat\ChatRoomManager;
use Garbuzivan\LaravelUserChat\Models\ChatMessage;

class MessagePipeline
{
    public ChatMessage $message;
    public ChatRoomManager $manager;

    /**
     * @param ChatMessage     $message
     * @param ChatRoomManager $manager
     */
    public function __construct(ChatMessage $message, ChatRoomManager $manager)
    {
        $this->message = $message;
        $this->manager = $manager;
    }
}
