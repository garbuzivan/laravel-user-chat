<?php
// Garbuzivan\LaravelUserChat

use Garbuzivan\LaravelUserChat\Models\ChatRoom;

return [
    /**
     * Комнаты чата, используется поле id для полиморфной связи
     */
    'room' => ChatRoom::class,
];
