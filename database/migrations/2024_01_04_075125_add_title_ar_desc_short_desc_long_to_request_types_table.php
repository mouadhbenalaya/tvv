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
        Schema::table('request_types', function (Blueprint $table) {
            $table->string("title_ar")->nullable();
            $table->string("desc_short_ar")->nullable();
            $table->string("desc_short_en")->nullable();
            $table->text("desc_long_ar")->nullable();
            $table->text("desc_long_en")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_types', function (Blueprint $table) {
            //
        });
    }
};
