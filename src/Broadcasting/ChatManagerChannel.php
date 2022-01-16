<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Broadcasting;

use App\Models\User;

class ChatManagerChannel
{
    public const NAME = 'userchat';

    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param int  $userId
     *
     * @return bool
     */
    public function join(User $user, int $userId)
    {
        return is_int($user->id) && $user->id == $userId;
    }
}
