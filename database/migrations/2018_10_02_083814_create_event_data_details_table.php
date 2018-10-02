<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventDataDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_data_details', function (Blueprint $table) {
            $table->increments('id');

            //note: Thiếu eventdata_id, dư id_lead ?
//            $table->unsignedInteger('lead_id');
            $table->unsignedInteger('event_data_id');
            $table->unsignedInteger('user_id');
            $table->smallInteger('state')->default(1)->comment('1: TeleMarketer; 2: REP; 3: TO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_data_details');
    }
}
