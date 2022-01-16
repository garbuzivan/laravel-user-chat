<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Exceptions;

use Exception;

class NotChmodAddMessage extends Exception
{
    protected $message = 'Нет прав добавления сообщений';
}
