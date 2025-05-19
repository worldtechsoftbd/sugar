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
        Schema::create('org_office_head_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_office_head_id')->nullable(); // Related OrgOfficeHead ID
            $table->uuid('uuid')->unique(); // UUID
            $table->dateTime('started_date')->nullable(); // Started date
            $table->dateTime('ended_date')->nullable(); // Ended date
            $table->unsignedBigInteger('org_office_id')->nullable(); // Organization office ID
            $table->unsignedBigInteger('emp_id')->nullable(); // Employee ID
            $table->integer('status')->default(1); // Status with default value
            $table->softDeletes('deleted_at'); // Soft deletes
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints
            $table->foreign('org_office_head_id')->references('id')->on('org_office_head')->onDelete('cascade');
            $table->foreign('org_office_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_office_head_history');
    }
};
