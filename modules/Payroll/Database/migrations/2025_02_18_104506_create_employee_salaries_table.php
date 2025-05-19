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
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('emp_id');
            $table->tinyInteger('pay_or_ded')->comment('1 for pay, 2 for deduction');
            $table->unsignedBigInteger('type_id');
            $table->decimal('amount', 16, 2);
            $table->text('remarks')->nullable();
            $table->integer('status')->default(1)->comment('101 initial, 201 updated, 276 deleted');
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('payment_or_deduction_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_salaries');
    }
};
