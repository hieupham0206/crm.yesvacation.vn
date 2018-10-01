<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('member_id');
            $table->unsignedInteger('event_data_id');

            $table->double('amount')->default(0);
            $table->double('net_amount')->default(0);
            $table->timestamp('paid_first_date')->nullable();
            $table->double('paid_first')->default(0);
            $table->timestamp('paid_last_date')->nullable();
            $table->double('paid_last')->default(0);

            $table->tinyInteger('state')->default(1)->comment('-1: Not yest; 1: Done');

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
        Schema::dropIfExists('contracts');
    }
}
