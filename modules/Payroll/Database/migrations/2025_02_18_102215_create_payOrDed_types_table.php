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
        Schema::create('payment_or_deduction_types', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->tinyInteger('pay_or_ded')->comment('1 for pay, 2 for deduction');
            $table->string('description', 50);
            $table->text('remarks')->nullable();
            $table->integer('status')->default(1)->comment('101 initial, 201 updated, 276 deleted');
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_or_deduction_types');
    }
};
