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
