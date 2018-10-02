<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();
            $table->string('name');
            $table->tinyInteger('gender')->default(1)->comment('1: Nam; 2: Nữ');
            $table->string('phone', 12)->nullable();

            $table->date('birthday');
            $table->string('address')->nullable();
            $table->string('city')->nullable();

            $table->smallInteger('state')->default(1)->comment('1: New Customer; 2: DeadNumber; 3: WrongNumber; 4: OrderCity; 5: NoAnswer; 6: NoInterested; 7: CallLater; 8: Appointment');
            $table->text('comment')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
