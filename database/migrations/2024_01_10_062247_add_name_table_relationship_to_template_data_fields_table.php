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
            $table->string('name_table_relationship')->nullable();
            $table->string('type_data_table_relationship')->nullable();
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
