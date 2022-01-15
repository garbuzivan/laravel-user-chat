<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ChatRoomInterface
{
    public function getRoomById(int $roomId): ?ChatRoomInterface;
    public function roomDelete(int $roomId): bool;
    public function roomRename(string $name, $objectRoom): ChatRoomInterface;
    public function users(int $roomId): ?Collection;
}
