<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_salaries', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');

            $table->date('period');

            $table->tinyInteger('total_day_off');
            $table->tinyInteger('total_day_work');

            $table->double('basic_salary')->default(0);
            $table->double('provisional_commission')->default(0);
            $table->double('total_bonus')->default(0);
            $table->double('total_salary')->default(0);
            $table->double('tax')->default(0);
            $table->double('rent')->default(0);
            $table->double('final_salary')->default(0);

            $table->tinyInteger('state')->default(1)->comment('-1: Not yet; 1: Done');

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
        Schema::dropIfExists('final_salaries');
    }
}
