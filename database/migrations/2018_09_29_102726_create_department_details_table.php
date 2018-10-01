<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_details', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('department_id');
            $table->unsignedInteger('user_id');
            $table->tinyInteger('type')->default(1)->comment(' 1: Employee; 2: Supervisor');

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
        Schema::dropIfExists('department_details');
    }
}
