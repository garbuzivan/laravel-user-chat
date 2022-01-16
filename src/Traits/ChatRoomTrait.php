<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Traits;

use Garbuzivan\LaravelUserChat\Interfaces\ChatRoomInterface;
use Garbuzivan\LaravelUserChat\Models\ChatRoomUser;
use Illuminate\Database\Eloquent\Collection;

trait ChatRoomTrait
{
    /**
     * Создание комнаты по названию
     *
     * @param string $name
     * @param int    $projectID
     *
     * @return ChatRoomInterface
     */
    public function roomCreate(string $name, $projectID = 0): ChatRoomInterface
    {
        return self::create(['name' => $name, 'project_id' => $projectID]);
    }

    /**
     * Поиск комнаты по ID
     *
     * @param int $roomId
     *
     * @return ChatRoomInterface|null
     */
    public function getRoomById(int $roomId): ?ChatRoomInterface
    {
        return self::find($roomId);
    }

    /**
     * Удаление комнаты
     *
     * @param int $roomId
     *
     * @return bool
     */
    public function roomDelete(int $roomId): bool
    {
        return (bool)self::where('id', $roomId)->delete();
    }

    /**
     * Переименовать комнату
     *
     * @param string $name
     * @param        $objectRoom
     *
     * @return $this
     */
    public function roomRename(string $name, $objectRoom): self
    {
        $objectRoom->name = $name;
        $objectRoom->save();
        return $objectRoom;
    }

    /**
     * Связь с пользователями
     *
     * @param int $roomId
     *
     * @return Collection|null
     */
    public function users(int $roomId = 0): ?Collection
    {
        if ($roomId == 0 && !empty($this->id)) {
            $roomId = $this->id;
        }
        return ChatRoomUser::where('room_type', get_class())->where('room_id', $roomId)->get();
    }
}
