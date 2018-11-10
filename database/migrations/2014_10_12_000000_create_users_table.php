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
            $table->string('name');
            $table->string('email')->nullable();
            $table->tinyInteger('state')->default(\App\Enums\UserState::ACTIVE)->comment('-1: Chưa kích hoạt; 1: Đã kích hoạt');

            $table->string('phone', 12)->nullable();
            $table->double('basic_salary')->default(0);

            $table->date('birthday')->nullable();
            $table->date('first_day_work')->nullable();
            $table->string('address')->nullable();
            $table->text('note')->nullable();

//            $table->unsignedInteger('actor_id')->nullable();
//            $table->string('actor_type')->nullable();
//            $table->index(['actor_id', 'actor_type']);

            $table->tinyInteger('use_otp')->default(\App\Enums\Confirmation::NO)->comment('-1: Không sử dụng; 1: có sử dụng');
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
