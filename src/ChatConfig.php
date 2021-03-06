<?php

namespace Garbuzivan\LaravelUserChat;

use Garbuzivan\LaravelUserChat\Pipeline\Add\UpdateLastMessage;

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

    /**
     * Проверка включения вебсокета и событий
     * PS сокеты работают только для App/Models/User
     *
     * @return bool
     */
    public static function isWebsocket(): bool
    {
        return intval(config(ChatConfig::CONFIG_NAME . 'websocket_enable', 0)) == 1;
    }

    /**
     * Pipelines добавления сообщений
     *
     * @return array
     */
    public static function getPipelineMessageAdd(): array
    {
        $arr = config(ChatConfig::CONFIG_NAME . 'pipeline_message_add');
        $standard = [UpdateLastMessage::class];
        $arr = is_array($arr) ? $arr : [];
        return array_merge($arr, $standard);
    }

    /**
     * Pipelines добавления сообщений
     *
     * @return array
     */
    public static function getPipelineMessageDelete(): array
    {
        $arr = config(ChatConfig::CONFIG_NAME . 'pipeline_message_delete');
        $standard = [UpdateLastMessage::class];
        $arr = is_array($arr) ? $arr : [];
        return array_merge($arr, $standard);
    }

    /**
     * Статус пользователей, которым позволено добавление сообщений в комнате чата
     *
     * @return array
     */
    public static function getChmodMessageAdd(): array
    {
        $arr = config(ChatConfig::CONFIG_NAME . 'chmod_message_add');
        return is_array($arr) ? $arr : [0, 1, 2];
    }

    /**
     * Статус пользователей, которым позволено удаление сообщений в комнате чата
     *
     * @return array
     */
    public static function getChmodMessageDelete(): array
    {
        $arr = config(ChatConfig::CONFIG_NAME . 'chmod_message_delete');
        return is_array($arr) ? $arr : [1, 2];
    }
}
