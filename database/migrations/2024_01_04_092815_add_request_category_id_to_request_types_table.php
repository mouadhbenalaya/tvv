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
            $table->unsignedBigInteger('request_category_id')->nullable();
            $table->foreign('request_category_id')->references('id')->on('request_categorys');

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
