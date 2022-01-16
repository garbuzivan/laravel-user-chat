<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Exceptions;

use Exception;

class UserIsNotInChatRoom extends Exception
{
    protected $message = 'Пользователь не состоит в комнате чата';
}
