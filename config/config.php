<?php
// Garbuzivan\LaravelUserChat

use Garbuzivan\LaravelUserChat\Models\ChatRoom;

return [
    /**
     * Комнаты чата, используется поле id для полиморфной связи
     */
    'room'                    => ChatRoom::class,

    /**
     * Использование вебсокета с событиями по чатам
     */
    'websocket_enable'        => true,

    /**
     * Pipeline добавления новых сообщений
     */
    'pipeline_message_add'    => [],

    /**
     * Pipeline удаления сообщений
     */
    'pipeline_message_delete' => [],

    /**
     * Pipeline редактирования сообщений
     */
    'pipeline_message_edit'   => [],

    /**
     * Статус пользователей, которым позволено добавление сообщений в комнате чата
     */
    'chmod_message_add'   => [0, 1, 2],

    /**
     * Статус пользователей, которым позволено удаление сообщений в комнате чата
     */
    'chmod_message_delete'   => [1, 2],
];
