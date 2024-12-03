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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('driver_id')->nullable();
            $table->string('license_state')->nullable();
            $table->string('license_number')->nullable();
            $table->date('license_start_date')->nullable();
            $table->string('username')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('driver_id');
            $table->dropColumn('license_state');
            $table->dropColumn('license_number');
            $table->dropColumn('license_start_date');
            $table->dropColumn('username');
        });
    }
};
