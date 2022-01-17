<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhereIsAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_room_where_is_admin', function (Blueprint $table) {
            $table->id();
            $table->morphs('room');
            $table->integer('last_read_message_id')->default(0)->comment('Последний прочитанный комментарий');
            $table->dateTimeTz('last_read_datetime')->nullable()->comment('Время последнего чтения чата');
            $table->integer('last_message_id')->default(0)->comment('Последний комментарий в чате');
            $table->dateTimeTz('last_message_datetime')->nullable()->comment('Время последнего комментария в чате');
            $table->integer('project_id')->default(0)->comment('ID проекта');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_room_where_is_admin');
    }
}
