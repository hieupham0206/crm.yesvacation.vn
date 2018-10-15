<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->unsignedInteger('member_id')->nullable();

            $table->mediumInteger('time_of_call')->comment('Thoi gian gọi, tính bằng giây');
            $table->tinyInteger('type')->default(\App\Enums\HistoryCallType::MANUAL)->comment('1: Manual; 2: HistoryCall; 3:CallBackCall; 4: AppointmentCall');

            $table->text('comment')->nullable();
            $table->smallInteger('state')->default(\App\Enums\LeadState::NEW_CUSTOMER)->comment('Tương ứng cột state bên lead');

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
