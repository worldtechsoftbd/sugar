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
        Schema::table('mill_shifts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id'); // Add `uuid` column
            $table->integer('MaxPerShift')->nullable()->after('uuid'); // Add `MaxPerShift` column
            $table->integer('OnHoldPerShift')->nullable()->after('MaxPerShift'); // Add `OnHoldPerShift` column
            $table->boolean('IsApplicableConfig')->default(false)->after('OnHoldPerShift'); // Add `IsApplicableConfig` column
            $table->boolean('OverTimeYN')->default(false)->after('IsApplicableConfig'); // Add `OverTimeYN` column
            $table->integer('MaxOverTime')->nullable()->after('OverTimeYN'); // Add `MaxOverTime` column
            $table->integer('MinTime')->nullable()->after('MaxOverTime'); // Add `MinTime` column
            $table->softDeletes()->after('updated_at'); // Add `deleted_at` column for soft deletes
            $table->unsignedBigInteger('created_by')->nullable()->after('deleted_at'); // Add `created_by` column
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by'); // Add `updated_by` column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mill_shifts', function (Blueprint $table) {
            $table->dropColumn([
                'uuid',
                'MaxPerShift',
                'OnHoldPerShift',
                'IsApplicableConfig',
                'OverTimeYN',
                'MaxOverTime',
                'MinTime',
                'created_by',
                'updated_by',
            ]);
            $table->dropSoftDeletes();
        });
    }
};
