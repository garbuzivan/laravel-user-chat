<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Exceptions;

use Exception;

class ChatRoomUserNotExists extends Exception
{
    protected $message = 'Объект пользователя не существует';
}
