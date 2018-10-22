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

            $table->unsignedInteger('rep_id')->nullable();
            $table->unsignedInteger('to_id')->nullable();
            $table->unsignedInteger('appointment_id');
            $table->unsignedInteger('lead_id')->comment('Tương ứng với lead_id bên appointment');

            $table->string('voucher_code', 100)->nullable();

            $table->timestamp('time_in')->nullable();
            $table->timestamp('time_out')->nullable();

            $table->text('note')->nullable();

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
