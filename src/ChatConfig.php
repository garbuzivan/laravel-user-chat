<?php

namespace Garbuzivan\LaravelUserChat;

class ChatConfig
{
    public const CONFIG_NAME = 'garbuzivan-laravel-user-chat';

    public const USER_STATUS = [
        0 => 'Пользователь',
        1 => 'Модератор',
        2 => 'Администратор',
    ];
}
