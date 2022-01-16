<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Pipeline\Add;

use Closure;
use Garbuzivan\LaravelUserChat\Exceptions\ChatRoomNotLoad;
use Garbuzivan\LaravelUserChat\Interfaces\MessagePipelineInterface;
use Garbuzivan\LaravelUserChat\Models\ChatRoomUser;
use Garbuzivan\LaravelUserChat\Pipeline\MessagePipeline;

class UpdateLastMessage implements MessagePipelineInterface
{
    /**
     * Обновляем дату и id последнего сообщения в комнате чата
     *
     * @param MessagePipeline $data
     * @param Closure         $next
     *
     * @return MessagePipeline
     * @throws ChatRoomNotLoad
     */
    public function handle(MessagePipeline $data, Closure $next): MessagePipeline
    {
        $message = $data->message;
        $room = $data->manager->getRoomInfo();
        ChatRoomUser::where('room_type', get_class($room))->where('room_id', $room->id)
            ->update([
                'last_message_id'       => $message->id,
                'last_message_datetime' => $message->created_at,
            ]);
        return $next($data);
    }
}
