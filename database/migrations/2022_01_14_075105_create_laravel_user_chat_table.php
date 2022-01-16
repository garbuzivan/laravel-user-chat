<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaravelUserChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->integer('status')->default(0);
            $table->integer('project_id')->default(0)->comment('ID проекта');
            $table->timestamps();
        });
        Schema::create('chat_room_users', function (Blueprint $table) {
            $table->id();
            $table->morphs('room');
            $table->morphs('user');
            $table->integer('status')->default(0)->comment('Статус пользователя в чате');
            $table->integer('last_read_message_id')->default(0)->comment('Последний прочитанный комментарий');
            $table->dateTimeTz('last_read_datetime')->nullable()->comment('Время последнего чтения чата');
            $table->integer('last_message_id')->default(0)->comment('Последний комментарий в чате');
            $table->dateTimeTz('last_message_datetime')->nullable()->comment('Время последнего комментария в чате');
            $table->integer('project_id')->default(0)->comment('ID проекта');
            $table->index('room_type');
            $table->index('room_id');
            $table->index('user_type');
            $table->index('user_id');
        });
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0)
                ->comment('Тип сообщения');
            $table->morphs('room');
            $table->integer('room_user_id')->references('id')->on('chat_room_users');
            $table->longText('message')->nullable()
                ->comment('Текстовое сообщение');
            $table->longText('data_json')->nullable()
                ->comment('json параметры для вывода дополнительных данных');
            $table->integer('drop_message_id')->default(0)->comment('ID сообщения для удаления, если type == 2');
            $table->integer('active')->default(1)->comment('Актуальность сообщения');
            $table->index('room_type');
            $table->index('room_id');
            $table->index('room_user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_rooms');
        Schema::dropIfExists('chat_room_users');
        Schema::dropIfExists('chat_messages');
    }
}
