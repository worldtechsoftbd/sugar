<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('emp_paid_day_count', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('payroll_id');
            $table->date('payment_date')->nullable();
            $table->string('year_month', 15);
            $table->date('default_date')->nullable()->comment('This day will change every month. Default is the 1st day of the month. For new joiners, the joining date will be the default date.');
            $table->integer('day_count')->nullable();
            $table->tinyInteger('day_paid');
            $table->tinyInteger('is_paid')->default(1)->comment('1 = NO, 2 = YES');
            $table->tinyInteger('status')->default(1)->comment('1 = Full, 2 = Partial, 3 = Partial Joining, 4 = Stop, 5 = On Probation');
            $table->tinyInteger('ready_to_pay')->default(1)->comment('1 = No, 2 = Yes, 3 = LWP(Leave Without Pay)');
            $table->date('end_date')->nullable()->comment('This is the last day of the current month or the resignation date.');
            $table->string('remarks', 150)->nullable();
            $table->tinyInteger('emp_status')->comment('1 = Regular, 2 = Resign');
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payroll_id')->references('id')->on('payroll_infos')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unique(['employee_id', 'year_month'], 'uk_emp_paid_day_count');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emp_paid_day_count');
    }
};
