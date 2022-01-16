<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Models;

use Garbuzivan\LaravelUserChat\Interfaces\ChatRoomInterface;
use Garbuzivan\LaravelUserChat\Traits\ChatRoomTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model implements ChatRoomInterface
{
    use HasFactory, ChatRoomTrait;

    protected $table = 'chat_rooms';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'project_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'   => 'integer',
        'project_id'   => 'integer',
        'name' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];
}
