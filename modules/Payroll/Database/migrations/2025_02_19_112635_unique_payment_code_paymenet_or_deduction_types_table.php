<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('payment_or_deduction_types', function (Blueprint $table) {
            $table->unique('payment_code');
        });
    }

    public function down()
    {
        Schema::table('payment_or_deduction_types', function (Blueprint $table) {
            $table->dropUnique(['payment_code']);
        });
    }
};