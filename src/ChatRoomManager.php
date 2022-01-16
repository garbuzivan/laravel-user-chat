<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat;

use Garbuzivan\LaravelUserChat\Exceptions\ChatRoomNotLoad;
use Garbuzivan\LaravelUserChat\Exceptions\ChatRoomUserNotExists;
use Garbuzivan\LaravelUserChat\Exceptions\UserIsNotInChatRoom;
use Garbuzivan\LaravelUserChat\Interfaces\ChatRoomInterface;
use Garbuzivan\LaravelUserChat\Models\ChatMessage;
use Garbuzivan\LaravelUserChat\Pipeline\MessagePipeline;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pipeline\Pipeline;

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
     * Если пользователя нет в комнате чата
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
     * @param string|null $message  - текст сообщения
     * @param array       $dataJson - массив с дополнительными данными, как прикрепленные изображения
     *
     * @return ChatRoomManager
     * @throws UserIsNotInChatRoom
     */
    public function messageAdd(?string $message = null, array $dataJson = []): self
    {
        $this->isUserExist();
        $newMessage = ChatMessage::create([
            'type'         => 0, // ChatConfig::MESSAGE_TYPE[0]
            'room_type'    => get_class($this->room),
            'room_id'      => $this->room->id,
            'room_user_id' => $this->user->chat_room['id'],
            'message'      => $message,
            'data_json'    => $dataJson,
        ]);
        $data = new MessagePipeline($newMessage, $this);
        $data = app(Pipeline::class)->send($data)->through(ChatConfig::getPipelineMessageAdd())->thenReturn();
        if(ChatConfig::isWebsocket()){
            // если сокеты
        }
        return $this;
    }
}
