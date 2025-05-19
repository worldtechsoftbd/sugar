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
            Schema::table('employee_shifts', function (Blueprint $table) {
                $table->uuid('uuid')->unique(); // Unique identifier for each shift
                $table->date('shiftStartDate')->nullable(); // Start date of the shift, can be null
                $table->date('shiftEndDate')->nullable(); // End date of the shift, can be null
                $table->boolean('isShiftStartEndApplicable')->default(false); // Flag to indicate if start/end dates are applicable
                $table->integer('CrShiftDetailID')->nullable(); // Current shift detail ID, can be null
                $table->integer('PrevShiftDetailID')->nullable(); // Previous shift detail ID, can be null
                $table->integer('AssignedBy')->nullable(); // User ID who assigned the shift, can be null
                $table->string('ShiftStatus')->nullable()->comment('101: Initial, 201: Approved, 301: Single Transfer, 401: Shift Rotation, 501: Shift Merging, 128: Inactive'); // Status of the shift, can be null
                $table->string('Status')->nullable()->comment('1: Assigned, 2: Unassigned, 276: Deleted'); // General status, can be null
                $table->boolean('OverTimeYN')->default(false); // Indicates if overtime is applicable
                $table->integer('OverTimeHours')->nullable(); // Number of overtime hours, can be null

                $table->softDeletes(); // Adds deleted_at column for soft deletes
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
