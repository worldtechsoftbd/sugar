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
        Schema::table('attendances', function (Blueprint $table) {
            $table->date('attendance_date')->after('employee_id');;
            $table->string('checkType')->after('machine_state')->comment('I =In & O= Out')->nullable();
            $table->integer('verifyCode')->after('checkType')->nullable();
            $table->integer('sensorId')->after('verifyCode')->comment('Machine serial number')->nullable();
            $table->string('sn')->after('sensorId')->nullable();
            $table->string('attendance_remarks')->after('sn')->comment('Remarks For Attendance')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'attendance_date',
                'checkType',
                'verifyCode',
                'sensorId',
                'sn',
                'attendance_remarks'
            ]);
        });
    }
};
