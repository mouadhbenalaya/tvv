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
            $table->string('release_version')->nullable();
            $table->dateTime('release_date')->nullable();

            $table->unsignedBigInteger('request_type_id')->nullable();
            $table->foreign('request_type_id')->references('id')->on('request_types');


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
