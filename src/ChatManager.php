<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat;

use Garbuzivan\LaravelUserChat\Exceptions\ChatRoomNotLoad;
use Garbuzivan\LaravelUserChat\Interfaces\ChatRoomInterface;
use Garbuzivan\LaravelUserChat\Models\ChatRoomUser;
use Garbuzivan\LaravelUserChat\Resources\UserResource;
use Illuminate\Database\Eloquent\Collection;

class ChatManager
{
    /**
     * Модель для работы с комнатами
     *
     * @var ChatRoomInterface
     */
    protected ChatRoomInterface $chatRoom;

    /**
     * Объект комнаты чата с которой работаем
     *
     * @var ChatRoomInterface|null
     */
    protected ?ChatRoomInterface $objectRoom = null;

    /**
     * @param ChatRoomInterface $chatRoom
     */
    public function __construct(ChatRoomInterface $chatRoom)
    {
        $this->chatRoom = $chatRoom;
    }

    /**
     * Создание комнаты по названию
     *
     * @param string $name
     * @param int    $projectID - ID проекта
     *
     * @return ChatManager
     */
    public function roomCreate(string $name, $projectID = 0): self
    {
        $this->objectRoom = $this->chatRoom->roomCreate($name, $projectID);
        return $this;
    }

    /**
     * Поиск комнаты по ID
     *
     * @param int $roomId
     *
     * @return ChatManager
     */
    public function getRoomById(int $roomId): self
    {
        $this->objectRoom = $this->chatRoom->getRoomById($roomId);
        return $this;
    }

    /**
     * Получить текущий загруженный чат
     *
     * @return ChatRoomInterface
     * @throws ChatRoomNotLoad
     */
    public function getRoom(): ChatRoomInterface
    {
        if (is_null($this->objectRoom)) {
            throw new ChatRoomNotLoad();
        }
        return $this->objectRoom;
    }

    /**
     * Удаление комнаты
     *
     * @return bool
     */
    public function roomDelete(): bool
    {
        if (is_null($this->objectRoom) && !isset($this->objectRoom->id)) {
            return false;
        }
        return $this->chatRoom->roomDelete($this->objectRoom->id);
    }

    /**
     * Переименовать комнату
     *
     * @param string $name
     *
     * @return $this
     */
    public function roomRename(string $name): self
    {
        if ($this->objectRoom instanceof ChatRoomInterface) {
            $this->objectRoom = $this->chatRoom->roomRename($name, $this->objectRoom);
        }
        return $this;
    }

    /**
     * Получить список пользователей группы
     * Прогоняем модели пользователей через ресурс,
     * заменяем связь на модель пользователя
     * и добавляем поле chat_room которое хранит связь и данные ChatRoomUser
     * Пример: roomUsers()->fisrt()->chat_room['status']
     *
     * @return Collection|null
     */
    public function roomUsers(): ?Collection
    {
        $users = [];
        if ($this->objectRoom instanceof ChatRoomInterface) {
            $users = $this->chatRoom->users($this->objectRoom->id);
        }
        return new UserResource($users);
    }

    /**
     * Добавить пользователя из коллекции
     *
     * @param Collection|null $members
     * @param int             $status
     *
     * @return ChatManager
     */
    public function roomMembersAdd(?Collection $members, int $status = 0): self
    {
        if ($this->objectRoom instanceof ChatRoomInterface && $members instanceof Collection && $members->count() > 0) {
            foreach ($members as $member) {
                ChatRoomUser::firstOrCreate(
                    [
                        'room_type' => get_class($this->objectRoom),
                        'room_id'   => $this->objectRoom->id,
                        'user_id'   => $member->id,
                        'user_type' => get_class($member),
                    ],
                    [
                        'status' => $status,
                    ]
                );
            }
        }
        return $this;
    }

    /**
     * Добавить пользователей через массив ID
     *
     * @param array  $ids
     * @param string $userType
     * @param int    $status
     *
     * @return ChatManager
     */
    public function roomMembersAddByIds(array $ids, string $userType, int $status = 0): self
    {
        if ($this->objectRoom instanceof ChatRoomInterface && count($ids) > 0) {
            foreach ($ids as $id) {
                $id = intval($id);
                if ($id == 0) {
                    continue;
                }
                ChatRoomUser::firstOrCreate(
                    [
                        'room_type' => get_class($this->objectRoom),
                        'room_id'   => $this->objectRoom->id,
                        'user_id'   => $id,
                        'user_type' => $userType,
                    ],
                    [
                        'status' => $status,
                    ]
                );
            }
        }
        return $this;
    }

    /**
     * Удалить пользователя по объектам коллекции
     *
     * @param mixed $members
     *
     * @return ChatManager
     */
    public function roomMembersDelete($members): self
    {
        if ($this->objectRoom instanceof ChatRoomInterface && $members instanceof Collection && $members->count() > 0) {
            foreach ($members as $member) {
                $userId = $member instanceof ChatRoomUser ? $member->user_id : $member->id;
                ChatRoomUser::where('room_type', get_class($this->objectRoom))
                    ->where('room_id', $this->objectRoom->id)
                    ->where('user_type', get_class($member))
                    ->where('user_id', $userId)
                    ->delete();
            }
        }
        return $this;
    }

    /**
     * Добавить пользователей через массив ID
     *
     * @param array  $ids
     * @param string $userType
     *
     * @return ChatManager
     */
    public function roomMembersDeleteByIds(array $ids, string $userType): self
    {
        if ($this->objectRoom instanceof ChatRoomInterface && count($ids) > 0) {
            ChatRoomUser::where('room_type', get_class($this->objectRoom))
                ->where('room_id', $this->objectRoom->id)
                ->where('user_type', $userType)
                ->whereIn('user_id', $ids)
                ->delete();
        }
        return $this;
    }

    /**
     * Изменить статус пользователя в группе
     *
     * @param mixed $user
     * @param int   $status
     *
     * @return ChatManager
     */
    public function roomUserSetStatus(mixed $user, int $status = 0): self
    {
        if ($this->objectRoom instanceof ChatRoomInterface && !empty($user->id)) {
            ChatRoomUser::where('room_type', get_class($this->objectRoom))
                ->where('room_id', $this->objectRoom->id)
                ->where('user_type', get_class($user))
                ->whereIn('user_id', $user->id)
                ->update(['status' => $status]);
        }
        return $this;
    }

    /**
     * Получить список чат-комнат пользователя
     *
     * @param object $user      - объект пользователя
     * @param int    $projectID - ID проекта, 0 == все
     *
     * @return Collection|null
     */
    public function getChatRoomUser(object $user, int $projectID = 0): ?Collection
    {
        $rooms = ChatRoomUser::where('user_type', get_class($user))->where('user_id', $user->id)->with('room');
        if (!is_null($projectID)) {
            $rooms = $rooms->where('project_id', $projectID);
        }
        $rooms = $rooms->get();
        $data = app(Collection::class);
        foreach ($rooms as $chat) {
            $data->push($chat->room()->first());
        }
        return $data;
    }
}
