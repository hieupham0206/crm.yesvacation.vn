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

            $table->mediumInteger('time_of_call')->comment('Thoi gian gọi, tính bằng giây');
            $table->tinyInteger('type')->comment('1: Manual; 2: HistoryCall; 3:CallBackCall; 4: AppointmentCall');

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
