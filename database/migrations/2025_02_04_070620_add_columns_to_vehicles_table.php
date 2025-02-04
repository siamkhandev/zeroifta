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
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');
            $table->unique(['vin', 'owner_type'], 'unique_vehicle_entity');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('owner_id');
            $table->dropColumn('owner_type');
            $table->dropColumn('unique_vehicle_entity');
        });
    }
};
