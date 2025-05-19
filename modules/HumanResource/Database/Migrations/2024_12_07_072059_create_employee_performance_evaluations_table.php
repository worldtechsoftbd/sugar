<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_performance_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('title');
            $table->integer('score');
            $table->string('short_code')->nullable();
            $table->unsignedBigInteger('evaluation_type_id')->nullable();
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_performance_evaluations');
    }
};
