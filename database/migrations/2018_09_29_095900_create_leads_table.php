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
            $table->string('email')->nullable();
            $table->tinyInteger('gender')->default(\App\Enums\Gender::MALE)->comment('1: Nam; 2: Nữ');
            $table->timestamp('birthday')->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('province_id')->comment('Tỉnh thành phố')->nullable();
            $table->string('phone', 12)->nullable();

            $table->smallInteger('state')->default(\App\Enums\LeadState::NEW_CUSTOMER)->comment('1: New Customer; 2: DeadNumber; 3: WrongNumber; 4: OtherCity; 5: NoAnswer; 6: NoInterested; 7: CallLater; 8: Appointment, 9: Not Deal Yet; 10: Member');
            $table->timestamp('call_date')->nullable()->comment('Thời gian cuộc gọi cuối cùng');
            $table->text('comment')->nullable();
            
            $table->unsignedInteger('user_id')->comment('Đánh dấu lead của user, khi thay doi thi set null nhu cũ')->nullable();

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
