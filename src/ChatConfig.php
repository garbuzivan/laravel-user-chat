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

    public const MESSAGE_TYPE = [
        0 => 'Сообщение',
        1 => 'Обновление сообщения',
        2 => 'Удаление сообщения',
        3 => 'Системное сообщение',
    ];
}
