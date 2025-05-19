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
        Schema::create('shift_details', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('ShiftID');
            $table->unsignedBigInteger('DepartmentId');
            $table->integer('MaxPerShift')->default(0);
            $table->integer('OnHoldPerShift')->default(0);
            $table->boolean('IsApplicableConfig')->default(false);
            $table->tinyInteger('Status')->default(1);


            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamp('Created_At')->useCurrent();
            $table->timestamp('Updated_At')->nullable()->useCurrentOnUpdate();
            $table->softDeletes('Deleted_At');
            $table->time('StartTime');
            $table->time('EndTime');


            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ShiftID')->references('id')->on('shift_master')->onDelete('cascade'); // Assuming ShiftMaster has a table named shift_masters
            $table->foreign('DepartmentId')->references('id')->on('departments')->onDelete('cascade'); // Assuming Department has a table named departments
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_details');
    }
};
