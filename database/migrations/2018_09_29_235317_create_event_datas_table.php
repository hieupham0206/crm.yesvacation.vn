<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_datas', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('lead_id');

            $table->timestamp('appointment_date');

            $table->timestamp('time_in');
            $table->timestamp('time_out');

            $table->tinyInteger('show_up')->comment('-1: Không; 1: Có');
            $table->tinyInteger('deal')->comment('-1: Không; 1: Có');

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
        Schema::dropIfExists('event_datas');
    }
}
