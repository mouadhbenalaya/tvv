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
        Schema::create('request_data_fields', function (Blueprint $table) {
            $table->id();

            $table->string('label')->nullable();
            $table->string('field_value')->nullable();


            $table->unsignedBigInteger('field_type_id')->nullable();
            $table->foreign('field_type_id')->references('id')->on('field_types');

            $table->unsignedBigInteger('request_data_id')->nullable();
            $table->foreign('request_data_id')->references('id')->on('request_datas');

            $table->unsignedBigInteger('request_data_field_id')->nullable();
            $table->foreign('request_data_field_id')->references('id')->on('request_data_fields');


            $table->boolean('is_overwritten')->default(0)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_data_fields');
    }
};
