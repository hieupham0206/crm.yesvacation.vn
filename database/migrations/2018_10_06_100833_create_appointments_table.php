<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('lead_id');
//            $table->unique(['user_id', 'lead_id']);

            $table->string('spouse_name')->nullable();
            $table->string('spouse_phone')->nullable();
            $table->timestamp('appointment_datetime')->nullable();

            $table->tinyInteger('type')->default(1)->comment('1: Email; 2: SMS ; 3: Both; 4: InState');
            $table->tinyInteger('state')->default(\App\Enums\Confirmation::NO)->comment('1: Confirm; -1: Not');

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
        Schema::dropIfExists('appointments');
    }
}
