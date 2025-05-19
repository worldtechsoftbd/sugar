<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mill_shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mill_id'); // Mill ID
            $table->unsignedBigInteger('shift_id'); // Shift ID
            $table->boolean('status')->default(1); // Status
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('mill_shifts');
    }
};
