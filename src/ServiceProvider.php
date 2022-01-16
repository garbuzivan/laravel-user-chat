<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat;

use Garbuzivan\LaravelUserChat\Interfaces\ChatRoomInterface;
use Garbuzivan\LaravelUserChat\Models\ChatRoom;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services...
     *
     * @return void
     */
    public function boot()
    {
        $configPath = $this->configPath();

        $this->publishes([
            $configPath . '/config.php' => $this->publishPath(ChatConfig::CONFIG_NAME . '.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        include __DIR__ . '/channels.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ChatRoomInterface::class,
            config(ChatConfig::CONFIG_NAME . '.room', ChatRoom::class)
        );
        $this->app->bind(ChatRoomManager::class);
        $this->app->bind(ChatManager::class);
    }

    /**
     * @return string
     */
    protected function configPath(): string
    {
        return __DIR__ . '/../config';
    }

    /**
     * @param $configFile
     *
     * @return string
     */
    protected function publishPath($configFile): string
    {
        return config_path($configFile);
    }
}
