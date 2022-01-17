<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ChatRoomWhereIsAdmin extends Model
{
    use HasFactory;

    protected $table = 'chat_room_where_is_admin';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'room_type',
        'room_id',
        'last_read_message_id',
        'last_read_datetime',
        'last_message_id',
        'last_message_datetime',
        'project_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'room_id'               => 'integer',
        'room_type'             => 'string',
        'last_read_message_id'  => 'integer',
        'last_read_datetime'    => 'datetime',
        'last_message_id'       => 'integer',
        'last_message_datetime' => 'datetime',
        'project_id'               => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'room_id'   => 'required',
        'room_type' => 'required',
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
}
