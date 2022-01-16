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

## Пример загрузки чата для диалога

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

