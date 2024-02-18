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
        Schema::table('cities', function (Blueprint $table) {
            $table->string("name_ar")->after('name')->nullable();
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->string("name_ar")->after('name')->nullable();

        });
        Schema::table('regions', function (Blueprint $table) {
            $table->string("name_ar")->after('name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};