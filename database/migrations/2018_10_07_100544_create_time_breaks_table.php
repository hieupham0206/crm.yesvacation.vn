<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeBreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_breaks', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('reason_break_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('start_break')->nullable();
            $table->timestamp('end_break')->nullable();
            $table->string('another_reason')->nullable();

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
        Schema::dropIfExists('time_breaks');
    }
}
