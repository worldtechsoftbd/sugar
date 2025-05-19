<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('employee_salaries', function (Blueprint $table) {
            $table->unsignedBigInteger('payroll_info_id')->after('emp_id')->nullable();

            $table->foreign('payroll_info_id')->references('id')->on('payroll_infos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('employee_salaries', function (Blueprint $table) {
            $table->dropForeign(['payroll_info_id']);
            $table->dropColumn('payroll_info_id');
        });
    }
};
