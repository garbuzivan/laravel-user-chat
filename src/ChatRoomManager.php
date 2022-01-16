<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat;

use Garbuzivan\LaravelUserChat\Exceptions\ChatRoomNotLoad;
use Garbuzivan\LaravelUserChat\Exceptions\ChatRoomUserNotExists;
use Garbuzivan\LaravelUserChat\Exceptions\UserIsNotInChatRoom;
use Garbuzivan\LaravelUserChat\Interfaces\ChatRoomInterface;
use Illuminate\Database\Eloquent\Collection;

class ChatRoomManager
{
    /**
     * @var ChatManager
     */
    protected ChatManager $chatManager;

    /**
     * Все пользователи текущего чата
     *
     * @var Collection
     */
    protected Collection $members;

    /**
     * Текущий пользователь чата
     *
     * @var object|null
     */
    protected ?object $user = null;

    /**
     * Текущий пользователь чата
     *
     * @var ChatRoomInterface|null
     */
    protected ?ChatRoomInterface $room = null;

    /**
     * @param ChatManager $chatManager
     */
    public function __construct(ChatManager $chatManager)
    {
        $this->chatManager = $chatManager;
    }

    /**
     * Получить текущий экземпляр ChatManager
     *
     * @return ChatManager
     */
    public function getChatManager(): ChatManager
    {
        return $this->chatManager;
    }

    /**
     * Загрузить текущую комнату по объекту комнаты
     *
     * @return $this
     */
    public function setRoom(int $roomId): self
    {
        $this->chatManager->getRoomById($roomId);
        $this->loadRoom();
        return $this;
    }

    /**
     * Загрузить текущую комнату по ID
     *
     * @return $this
     */
    public function setRoomById(int $roomId): self
    {
        $this->chatManager->getRoomById($roomId);
        $this->loadRoom();
        return $this;
    }

    /**
     * Установить текущего пользователя комнаты
     *
     * @param object $user
     *
     * @return ChatRoomManager
     * @throws ChatRoomNotLoad
     * @throws ChatRoomUserNotExists
     * @throws UserIsNotInChatRoom
     */
    public function setUser(object $user): self
    {
        $this->isLoadRoom();
        if (empty($user->id)) {
            throw new ChatRoomUserNotExists();
        }
        $type = get_class($user);
        $id = $user->id;
        foreach ($this->members as $member) {
            if ($member->id == $id && get_class($member) == $type) {
                $this->user = $member;
                break;
            }
        }
        $this->isUserExist();
        return $this;
    }

    /**
     * Получить данные комнаты чата
     *
     * @return object
     * @throws ChatRoomNotLoad
     */
    public function getRoomInfo(): object
    {
        $this->isLoadRoom();
        return $this->room;
    }

    /**
     * Получить список пользователей комнаты чата
     *
     * @return Collection
     * @throws ChatRoomNotLoad
     */
    public function getRoomUsers(): Collection
    {
        $this->isLoadRoom();
        return $this->members;
    }

    /**
     * Получить данные текущего пользователя комнаты чата
     *
     * @return object
     * @throws ChatRoomNotLoad
     */
    public function getRoomUser(): object
    {
        $this->isLoadRoom();
        return $this->user;
    }

    /**
     * Выполнить загрузку данных комнаты после установки чата
     */
    protected function loadRoom(): void
    {
        $this->room = $this->chatManager->getRoom();
        $this->isLoadRoom();
        $this->members = $this->chatManager->roomUsers();
    }

    /**
     * Проверка на загрузку комнаты
     *
     * @throws ChatRoomNotLoad
     */
    protected function isLoadRoom(): void
    {
        if (is_null($this->room)) {
            throw new ChatRoomNotLoad();
        }
    }

    /**
     * Если пользователе нет в комнате чата
     *
     * @throws UserIsNotInChatRoom
     */
    protected function isUserExist(): void
    {
        if (is_null($this->user)) {
            throw new UserIsNotInChatRoom();
        }
    }

    /**
     * Добавление нового комментария в комнату чата
     *
     * @param string|null $text - текст сообщения
     * @param array  $data_json - массив с дополнительными данными, как прикрепленные изображения
     * @param int    $type - тип сообщения
     *
     * @return ChatRoomManager
     * @throws UserIsNotInChatRoom
     */
    public function messageAdd(?string $text = null, array $data_json = [], int $type = 0): self
    {
        $this->isUserExist();

        return $this;
    }
}
