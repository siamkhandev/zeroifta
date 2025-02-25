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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('vehicle_id')->nullable()->unique();
            $table->string('vin')->nullable();
            $table->string('make_year')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('license')->nullable();
            $table->string('license_plate_number')->nullable();
            $table->string('secondary_tank_capacity')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            //
        });
    }
};
