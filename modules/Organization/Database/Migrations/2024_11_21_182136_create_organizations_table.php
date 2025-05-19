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
        Schema::create('organization', function (Blueprint $table) {
            $table->id();
            $table->string('org_name', 100);
            $table->string('description', 200)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: Active, 2: Inactive, 276: Deleted');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization#');
    }
};
