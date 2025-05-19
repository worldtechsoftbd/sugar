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
        Schema::create('payroll_infos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('emp_id');
            $table->string('payrollId', 30);
            $table->text('remarks')->nullable();
            $table->integer('status')->default(1)->comment('101 initial, 201 updated, 276 deleted');
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payroll_infos');
    }
};
