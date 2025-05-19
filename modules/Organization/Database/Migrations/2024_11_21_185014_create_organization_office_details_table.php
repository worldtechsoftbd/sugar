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
        Schema::create('organization_office_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_offices_id'); // Foreign key to Org_Offices table
            $table->string('office_name', 100);
            $table->string('description', 200)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: Active, 2: Inactive, 276: Deleted');
            $table->integer('sort_order')->nullable();
            $table->boolean('is_parent')->default(false); // Indicates if it is a parent office
            $table->unsignedBigInteger('parent_id')->nullable(); // Self-referencing foreign key
            $table->string('manager_name', 100)->nullable();
            $table->string('manager_phone', 20)->nullable();
            $table->string('manager_email', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            // Foreign key to Org_Offices
            $table->foreign('org_offices_id')->references('id')->on('organization_offices')->onDelete('cascade');

            // Self-referencing foreign key to allow parent-child relationship
            $table->foreign('parent_id')->references('id')->on('organization_office_details')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_office_details');
    }
};
