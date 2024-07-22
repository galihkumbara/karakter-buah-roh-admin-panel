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
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('members', 'city_id')) {
                $table->integer('city_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('members', 'city_id')) {
                $table->dropColumn('city_id');
            }
        });
    }
};
