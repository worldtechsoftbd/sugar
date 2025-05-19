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
        Schema::create('employee_leave_balance_history', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('leave_balance_id');
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('leave_type_id');
            $table->double('leave_balance');
            $table->double('leave_spent');
            $table->double('cr_leave_balance');
            $table->text('remarks')->nullable();
            $table->boolean('status')->default(1);
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leave_balance_history');
    }
};
