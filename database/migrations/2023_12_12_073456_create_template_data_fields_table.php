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
        Schema::create('template_data_fields', function (Blueprint $table) {
            $table->id();

            $table->string('label')->nullable();
            $table->unsignedBigInteger('field_type_id')->nullable();
            $table->foreign('field_type_id')->references('id')->on('field_types');

            $table->unsignedBigInteger('template_data_id');
            $table->foreign('template_data_id')->references('id')->on('template_datas');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_data_fields');
    }
};
