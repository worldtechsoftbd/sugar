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
        Schema::table('shifts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id'); // Add `uuid` column
            $table->string('Description')->nullable()->after('uuid'); // Add `Description` column
            $table->boolean('IsApplicableGracePeriod')->default(true)->after('Description'); // Add `IsApplicableGracePeriod`
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
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn([
                'uuid',
                'Description',
                'IsApplicableGracePeriod',
                'deleted_at',
                'created_by',
                'updated_by',
            ]);
        });
    }
};

