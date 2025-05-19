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
        Schema::table('departments', function (Blueprint $table) {
            $table->unsignedBigInteger('org_offices_id')->nullable()->after('id'); // Foreign key to OrganizationOffices table
            $table->string('description', 200)->nullable()->after('department_name');
            $table->string('address', 200)->nullable()->after('description');
            $table->decimal('longitude', 9, 6)->nullable()->after('address');
            $table->decimal('latitude', 9, 6)->nullable()->after('longitude');
            $table->tinyInteger('status')->default(1)->comment('1: Active, 2: Inactive, 276: Deleted')->after('is_active');
            $table->string('phone_number', 20)->nullable()->after('status');
            $table->string('email', 100)->nullable()->after('phone_number');
            $table->foreign('org_offices_id')->references('id')->on('organization_offices')->onDelete('cascade'); // Add foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['org_offices_id']); // Drop the foreign key
            $table->dropColumn([
                'org_offices_id',
                'description',
                'address',
                'longitude',
                'latitude',
                'status',
                'phone_number',
                'email'
            ]);
        });
    }
};
