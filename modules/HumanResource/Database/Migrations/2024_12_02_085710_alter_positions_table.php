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
        Schema::table('positions', function (Blueprint $table) {
            $table->string('position_short')->after('position_name')->nullable();
            $table->boolean('OverTimeYN')->default(false); // Indicates if overtime is applicable
            $table->decimal('seniority_order', 8, 2)->after('position_short');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn('position_short');
            $table->dropColumn('seniority_order');
        });
    }
};
