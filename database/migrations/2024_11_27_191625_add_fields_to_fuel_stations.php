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
        Schema::table('fuel_stations', function (Blueprint $table) {
            $table->decimal('lastprice', 8, 2)->nullable();
            $table->string('address')->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('ifta_tax', 8, 2)->nullable();
            $table->boolean('is_optimal')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fuel_stations', function (Blueprint $table) {
            $table->dropColumn(['lastprice', 'address', 'discount', 'ifta_tax', 'is_optimal']);
        });
    }
};
