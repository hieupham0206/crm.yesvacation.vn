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
        //Add khóa ngoại bảng department_details
        Schema::table('department_details', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('department_id')->references('id')->on('departments');
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