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
        Schema::table('trips', function (Blueprint $table) {
            $table->string('updated_start_lat')->nullable();
            $table->string('updated_start_lng')->nullable();
            $table->string('updated_end_lat')->nullable();
            $table->string('updated_end_lng')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn('updated_start_lat');
            $table->dropColumn('updated_start_lng');
            $table->dropColumn('updated_end_lat');
            $table->dropColumn('updated_end_lng');
        });
    }
};
