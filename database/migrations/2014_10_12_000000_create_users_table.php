<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 12)->nullable();
            $table->smallInteger('state')->default(1)->comment('0: Chưa kích hoạt; 1: Đã kích hoạt');

            $table->unsignedInteger('actor_id')->nullable();
            $table->string('actor_type')->nullable();
            $table->index(['actor_id', 'actor_type']);

            $table->tinyInteger('use_otp')->default(1)->comment('1: có sử dụng; -1: Không sử dụng');
            $table->string('otp', 6)->nullable();
            $table->timestamp('otp_expired_at')->nullable()->comment('OTP hết hạn trong 5 phút');

            $table->string('password');
            $table->rememberToken();
            $table->timestamp('last_login')->nullable();

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
        Schema::dropIfExists('users');
    }
}
