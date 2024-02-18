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
        Schema::create('template_datas', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(1)->nullable();
            $table->text('description')->nullable();

            $table->string('title')->nullable();
            $table->string('type_data')->nullable()->comment('data type of this block table or not');


            $table->unsignedBigInteger('template_data_id')->nullable();
            $table->foreign('template_data_id')->references('id')->on('template_datas');

            $table->unsignedBigInteger('request_type_id');
            $table->foreign('request_type_id')->references('id')->on('request_types');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_datas');
    }
};
