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
        Schema::table('template_data_fields', function (Blueprint $table) {

            $table->boolean('enabled')->default(1)->nullable();

            $table->unsignedBigInteger('template_data_field_id')->nullable();
            $table->foreign('template_data_field_id')->references('id')->on('template_data_fields');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_data_fields', function (Blueprint $table) {
            //
        });
    }
};
