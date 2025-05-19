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
        Schema::create('shift_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->string('ShiftName');
            $table->text('Description')->nullable();
            $table->time('StartTime');
            $table->time('EndTime');
            $table->integer('GracePeriod')->default(0);
            $table->boolean('IsApplicableGracePeriod')->default(false);
            $table->tinyInteger('Status')->default(1);

            $table->timestamps(0);
            $table->softDeletes('Deleted_At', 0);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_master');
    }
};