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
        Schema::create('tour_and_visits_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tourOrVisitId')->constrained('tour_and_visits')->onDelete('cascade');
            $table->foreignId('appliedBy')->constrained('employees')->onDelete('cascade');
            $table->json('tourOrVisitInfo');
            $table->uuid('uuid')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_and_visits_log');
    }
};
