<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();
            $table->string('name');
            $table->tinyInteger('gender')->default(1)->comment('1: Nam; 2: Nữ');

            $table->date('birthday');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('dial_code')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('phone', 12)->nullable();

            $table->string('email')->nullable();
            $table->string('spouce_name')->nullable();
            $table->string('spouce_phone')->nullable();
            $table->string('product_type')->nullable();
            $table->string('product_phone')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('member_ship')->nullable();

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
        Schema::dropIfExists('members');
    }
}