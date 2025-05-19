<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_leave_balance', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('emp_id');
            $table->year('leave_year');
            $table->unsignedBigInteger('leave_type_id');
            $table->double('leave_balance')->default(0);
            $table->double('leave_spent')->default(0);
            $table->double('cr_leave_balance')->default(0)->comment('Carry Forward Leave Balance');
            $table->text('remarks')->nullable();
            $table->string('status')->default('active');
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leave_balance');
    }
};
