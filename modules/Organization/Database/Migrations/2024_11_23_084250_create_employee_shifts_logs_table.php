<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_shifts_logs', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key
            $table->unsignedBigInteger('EmployeeShiftID'); // Foreign key to EmployeeShift
            $table->unsignedBigInteger('CrShiftDetailID'); // Current Shift Detail ID
            $table->unsignedBigInteger('PrevShiftDetailID'); // Previous Shift Detail ID
            $table->unsignedBigInteger('EmployeeID'); // Employee ID
            $table->unsignedBigInteger('AssignedBy')->nullable(); // User ID who assigned the shift
            $table->tinyInteger('ShiftStatus'); // Shift Status
            $table->tinyInteger('Status'); // Status
            $table->timestamps(); // Created_At and Updated_At
            $table->timestamp('Logged_At')->useCurrent(); // Time of logging

            // Adding new fields with default values.
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            // Foreign Key Constraints
            $table->foreign('EmployeeShiftID')->references('id')->on('employee_shifts')->onDelete('cascade');
            $table->foreign('CrShiftDetailID')->references('id')->on('shift_details')->onDelete('cascade');
            $table->foreign('PrevShiftDetailID')->references('id')->on('shift_details')->onDelete('cascade');
            $table->foreign('EmployeeID')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('AssignedBy')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');


        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_shifts_logs');
    }
};