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
        Schema::create('employee_shift_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('EmployeeShiftID');
            $table->unsignedBigInteger('mill_shift_id');
            $table->uuid('uuid')->unique();
            $table->date('shiftStartDate')->nullable();
            $table->date('shiftEndDate')->nullable();
            $table->boolean('isShiftStartEndApplicable')->default(false);
            $table->integer('CrShiftDetailID')->nullable();
            $table->integer('PrevShiftDetailID')->nullable();
            $table->unsignedBigInteger('EmployeeID');
            $table->unsignedBigInteger('AssignedBy')->nullable();
            $table->string('ShiftStatus')->nullable();
            $table->string('Status')->nullable();
            $table->boolean('OverTimeYN')->default(false);
            $table->integer('OverTimeHours')->nullable();
            $table->timestamp('Logged_At')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_shift_logs');
    }
};
