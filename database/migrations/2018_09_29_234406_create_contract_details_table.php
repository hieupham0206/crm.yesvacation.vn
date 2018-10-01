<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_details', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('contract_id');
            $table->unsignedInteger('user_id');

            $table->double('sdm_percent')->default(0);
            $table->double('to_percent')->default(0);
            $table->double('tele_percent')->default(0);
            $table->double('private_percent')->default(0);
            $table->double('ambassador_percent')->default(0);
            $table->double('rep_percent')->default(0);
            $table->double('cs_percent')->default(0);
            $table->double('total_percent')->default(0);

            $table->double('provisional_commission')->default(0);

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
        Schema::dropIfExists('contract_details');
    }
}
