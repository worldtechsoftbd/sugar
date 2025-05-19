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
        Schema::create('employee_shifts', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('CrShiftDetailID'); // Current Shift Detail ID
            $table->unsignedBigInteger('PrevShiftDetailID'); // Previous Shift Detail ID
            $table->unsignedBigInteger('EmployeeID'); // Employee ID
            $table->unsignedBigInteger('AssignedBy')->nullable(); // User ID who assigned the shift
            $table->tinyInteger('ShiftStatus')->default(101)->comment('101: For Initial, 201: Approve, 301: Single Transfer, 401: Shift Rotation, 501: Shift Merging, 128: Shift Inactive'); // Shift Status
            $table->tinyInteger('Status')->default(1)->comment('1: Assigned, 2: Unassigned, 276: Deleted'); // Status
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes('Deleted_At'); // soft delete for deleted_at

            // Adding new fields with default values.
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Foreign Key Constraints
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
        Schema::dropIfExists('employee_shifts');
    }
};