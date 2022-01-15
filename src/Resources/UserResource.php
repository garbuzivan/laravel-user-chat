<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Resources;

use Illuminate\Database\Eloquent\Collection;

class UserResource extends Collection
{
    protected array $collectType = [];

    public function __construct($items = [])
    {
        parent::__construct($items);
        $this->getUsersChat();
    }

    /**
     * Получаем типы связей, чтоб не делать лишние запросы
     *
     * @return void
     */
    protected function getItemsTypes(): void
    {
        foreach ($this->items as $item) {
            $this->collectType[$item->user_type][$item->user_id] = $item->toArray();
        }
    }

    /**
     * Получаем коллекцию пользователей чата из связей
     *
     * @return Collection
     */
    protected function getUsersList(): Collection
    {
        $this->getItemsTypes();
        $users = app(Collection::class);
        foreach ($this->collectType as $type => $items) {
            $result = app($type)->whereIn('id', array_keys($items))->get();
            if (!is_null($result)) {
                $users = $users->merge($result);
            }
        }
        return $users;
    }

    /**
     * Корректируем данные модели
     *
     * @return void
     */
    protected function getUsersChat(): void
    {
        $users = $this->getUsersList();
        foreach ($users as $key => $user) {
            $user->setAttribute('chat_room', $this->collectType[get_class($user)][$user->id]);
            $users[$key] = $user;
        }
        $this->collectType = [];
        parent::__construct($users);
    }
}
