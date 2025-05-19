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
        Schema::create('org_office_head', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // UUID column
            $table->dateTime('started_date')->nullable(); // Started date column
            $table->unsignedBigInteger('org_office_id'); // Organization office ID column
            $table->unsignedBigInteger('emp_id'); // Employee ID column
            $table->integer('status')->default(1); // Status column with default value
            $table->updateCreatedBy();
            $table->softDeletes(); // Soft deletes for deleted_at
            $table->timestamps(); // Timestamps for created_at and updated_at

            // Foreign keys (if needed)
             $table->foreign('org_office_id')->references('id')->on('departments')->onDelete('cascade');
             $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_office_head');
    }
};
