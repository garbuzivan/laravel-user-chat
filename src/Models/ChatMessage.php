<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'room_type',
        'room_id',
        'room_user_id',
        'messages',
        'data_json',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'room_id'      => 'integer',
        'room_type'    => 'string',
        'room_user_id' => 'integer',
        'messages'     => 'string',
        'data_json'    => 'json',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'room_id'      => 'required',
        'room_type'    => 'required',
        'room_user_id' => 'required',
    ];

    /**
     * Комната чата
     *
     * @return MorphTo
     */
    public function room(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Пользователь чата
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(ChatRoomUser::class, 'id', 'room_user_id');
    }

    /**
     * @param string $value
     *
     * @return array
     */
    public function getDataJsonAttribute(string $value): array
    {
        return json_decode($value, true);
    }

    /**
     * @param array $value
     *
     * @return string
     */
    public function setDataJsonAttribute(array $value): string
    {
        return json_encode($value);
    }
}
