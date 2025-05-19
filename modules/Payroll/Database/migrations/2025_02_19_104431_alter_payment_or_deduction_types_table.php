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
        Schema::table('payment_or_deduction_types', function (Blueprint $table) {
            $table->string('payment_code',15)->after('uuid')->nullable();
        });
    }

    public function down()
    {
        Schema::table('payment_or_deduction_types', function (Blueprint $table) {
            $table->dropColumn('payment_code');
        });
    }
};
