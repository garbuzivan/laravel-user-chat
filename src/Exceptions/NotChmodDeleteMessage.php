<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Exceptions;

use Exception;

class NotChmodDeleteMessage extends Exception
{
    protected $message = 'Нет прав удаления сообщений';
}
