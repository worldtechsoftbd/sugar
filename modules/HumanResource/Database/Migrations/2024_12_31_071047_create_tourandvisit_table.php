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
        Schema::create('tour_and_visits', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('emp_id')->constrained('employees')->onDelete('cascade');
            $table->year('applied_year');
            $table->foreignId('type_id')->comment('1 for Tour and 2 for Visit');
            $table->date('applied_date');
            $table->date('started_date');
            $table->date('end_date');
            $table->string('appliedStatus')->comment('1 initial waiting for Head,2 waiting for HR, 3 Approved By HR,4 Cancel by HR or Head ');
            $table->string('responsiblePerson');
            $table->text('remarks')->nullable();
            $table->integer('status')->default(1)->comment('101 initial,201 updated and 276 for deleted ');
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
        Schema::dropIfExists('tour_and_visits');
    }
};
