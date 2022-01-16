<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Exceptions;

use Exception;

class ChatRoomNotLoad extends Exception
{
    protected $message = 'ChatRoom not load';
}
