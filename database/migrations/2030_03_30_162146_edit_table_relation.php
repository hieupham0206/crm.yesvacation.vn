<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditTableRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add khóa ngoại bảng leads
        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('province_id')->references('id')->on('provinces');
        });
        //Add khóa ngoại bảng contracts
        Schema::table('contracts', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('event_data_id')->references('id')->on('event_datas');
        });
        //Add khóa ngoại bảng contract_details
        Schema::table('contract_details', function (Blueprint $table) {
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->foreign('user_id')->references('id')->on('users');
        });
        //Add khóa ngoại bảng event_datas
        Schema::table('event_datas', function (Blueprint $table) {
            $table->foreign('lead_id')->references('id')->on('leads');
        });
        //Add khóa ngoại bảng final_salaries
        Schema::table('final_salaries', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        //Add khóa ngoại bảng user_department
        Schema::table('user_department', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('department_id')->references('id')->on('departments');
        });
        //Add khóa ngoại bảng departments
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('province_id')->references('id')->on('provinces');
        });
        //Add khóa ngoại bảng history_calls
        Schema::table('history_calls', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('lead_id')->references('id')->on('leads');
            $table->foreign('member_id')->references('id')->on('members');
        });
        //Add khóa ngoại bảng bonus
        Schema::table('bonus', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        //Add khóa ngoại bảng appointments
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('lead_id')->references('id')->on('leads');
        });
        //Add khóa ngoại bảng callbacks
        Schema::table('callbacks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('lead_id')->references('id')->on('leads');
        });
        //Add khóa ngoại bảng time_breaks
        Schema::table('time_breaks', function (Blueprint $table) {
            $table->foreign('reason_break_id')->references('id')->on('reason_breaks');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
