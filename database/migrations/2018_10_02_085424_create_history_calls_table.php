<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_calls', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('lead_id');
            $table->unsignedInteger('member_id');

            $table->string('name');
            $table->string('phone')->nullable();

            $table->smallInteger('call_times');
            $table->tinyInteger('type')->comment('1: auto; 2: callback; 3:history');
            //todo: 4 field chưa rõ Status_LEAD, Comment_LEAD, Date, Time

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
        Schema::dropIfExists('history_calls');
    }
}
