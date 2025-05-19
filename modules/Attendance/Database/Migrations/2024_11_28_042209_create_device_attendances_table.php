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
        Schema::create('device_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('userId')->constrained('users');
            $table->integer('status')->default(101)->comment('101 initial, 201 processed');
            $table->timestamp('checkTime');
            $table->string('checkType');
            $table->integer('verifyCode');
            $table->integer('sensorId');
            $table->string('memoInfo');
            $table->integer('workCode');
            $table->string('sn');
            $table->integer('userExtFmt');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_attendances');
    }
};
