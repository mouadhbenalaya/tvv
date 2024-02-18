<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birth_date')->nullable();
            $table->char('gender', 1)->nullable();
            $table->foreignId('nationality_id')->nullable()->constrained('countries');
            $table->foreignId('region_id')->nullable()->constrained('regions');
            $table->foreignId('city_id')->nullable()->constrained('cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birth_date');
            $table->dropColumn('gender');
            $table->dropForeign(['nationality_id']);
            $table->dropColumn('nationality_id');
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
};
