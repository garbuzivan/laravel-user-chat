<?php
// Garbuzivan\LaravelUserChat

use Garbuzivan\LaravelUserChat\Models\ChatRoom;

return [
    /**
     * Комнаты чата, используется поле id для полиморфной связи
     */
    'room' => ChatRoom::class,

    /**
     * Использование вебсокета с событиями по чатам
     */
    'websocket_enable' => true,

    /**
     * Pipeline добавления новых сообщений
     */
    'pipeline_message_add' => [],

    /**
     * Pipeline удаления сообщений
     */
    'pipeline_message_delete' => [],

    /**
     * Pipeline редактирования сообщений
     */
    'pipeline_message_edit' => [],
];
