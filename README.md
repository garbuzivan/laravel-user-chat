# Interface laravel user chat

Interface laravel user chat

## Install - Установка

<pre>composer require garbuzivan/laravel-user-chat</pre>

## Конфигурационный файл

<pre>php artisan vendor:publish --force --provider="Garbuzivan\LaravelUserChat\ServiceProvider" --tag="config"</pre>

## Добавление ServiceProvider в config/app.php секция 'providers'

<pre>Garbuzivan\LaravelUserChat\ServiceProvider::class,</pre>

## Локальная установка пакета после генерации, без публикации в GIT и PACKAGIST

Добавить в секцию repositories файла composer.json путь пакета в формате:

<pre>
"repositories": [
    {
        "type": "path",
        "url": "./packages/garbuzivan/laravel-user-chat/"
    }
]
</pre>

## Пример добавления новой комнаты чата + добавления участников чата

<pre>
$chatManager = app(\Garbuzivan\LaravelUserChat\ChatManager::class);
$users = User::take(5)->inRandomOrder()->get();
$projectID = 1;
$chatManager->roomCreate('test', $projectID)->roomMembersAdd($users);
</pre>

## Пример получения всех чатов пользователя

<pre>
$user = Auth::user();
$chatManager = app(\Garbuzivan\LaravelUserChat\ChatManager::class);
$projectId = 0; // 0 == все проекты, >0 - чаты конкретного проекта
$userRooms = $chatManager->getChatRoomsUser($user, $projectId);
</pre>

## Пример загрузки данных о комнате чата

<pre>
$chatRoom = app(\Garbuzivan\LaravelUserChat\ChatRoomManager::class);
try {
    $room = $chatRoom->setRoomById(4)->setUser(Auth::user());
} catch (ChatRoomNotLoad $e) {
    echo 'Комната чата не найдена';
    exit();
} catch (ChatRoomUserNotExists $e) {
    echo 'В setUser не передан объект пользователя';
    exit();
} catch (UserIsNotInChatRoom $e) {
    echo 'Пользователь не имеет доступ к текущей комнате чата';
    exit();
}
</pre>


## Пример добавления сообщения

<pre>
$room->messageAdd('Тестовое сообщение');
</pre>


## Пример установки последнего прочитаннного сообщения

<pre>
$room->messageRead($idMessageRead);
</pre>


## Получить список сообщений комнаты чата

<pre>
$currentPage = 1;
$perPage = 100;
$room->getMessageList($currentPage, $perPage);
</pre>


## Получить список непрочитанных сообщений комнаты чата

<pre>
$currentPage = 1;
$perPage = 100;
$room->getMessageListNoRead($currentPage, $perPage);
</pre>


## Удалить сообщение из комнаты чата

<pre>
$room->messageDelete($messageID);
</pre>

