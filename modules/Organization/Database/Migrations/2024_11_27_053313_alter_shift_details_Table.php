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
        //
        Schema::table('shift_details', function (Blueprint $table) {
            $table->string('OverTimeYN')->default('N'); // Change boolean to string
            $table->decimal('MaxOverTime', 8, 2)->nullable(); // Change integer to decimal
            $table->decimal('MinTime', 8, 2)->nullable(); // Change integer to decimal
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shift_details', function (Blueprint $table) {
            $table->dropColumn('OverTimeYN');
            $table->dropColumn('MaxOverTime');
            $table->dropColumn('MinTime');
        });
    }
};
