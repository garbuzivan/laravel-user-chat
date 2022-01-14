<?php

declare(strict_types=1);

namespace Garbuzivan\LaravelUserChat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatrooms extends Model
{
    use HasFactory;

    protected $table = 'chat_rooms';

    /**
     * @var array
     */
    protected $fillable = [ 
		'title',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [ 
		'id' => 'integer',
		'title' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [ 
		'title' => 'required',
    ];
    
}