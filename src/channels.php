<?php

declare(strict_types=1);

use Garbuzivan\LaravelUserChat\Broadcasting\ChatManagerChannel;
use Garbuzivan\LaravelUserChat\ChatConfig;
use Illuminate\Support\Facades\Broadcast;

if (ChatConfig::isWebsocket()) {
    Broadcast::channel(ChatManagerChannel::NAME . '.{userId}', ChatManagerChannel::class);
}

