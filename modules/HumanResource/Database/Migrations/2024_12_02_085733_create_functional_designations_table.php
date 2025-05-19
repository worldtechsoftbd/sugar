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
        Schema::create('functional_designations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('functional_designation')->nullable();
            $table->text('designation_details')->nullable();
            $table->boolean('status')->default(0);
            $table->string('designation_short')->nullable();
            $table->decimal('seniority_order', 8, 2)->nullable();
            $table->updateCreatedBy();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('functional_designations');
    }
};
