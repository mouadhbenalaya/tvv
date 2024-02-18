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
        Schema::create('request_datas', function (Blueprint $table) {
            $table->id();


            $table->text('description')->nullable();

            $table->string('title')->nullable();
            $table->string('type_data')->nullable()->comment('data type of this block table or not');


            $table->unsignedBigInteger('template_data_id')->nullable();
            $table->foreign('template_data_id')->references('id')->on('template_datas');



            $table->unsignedBigInteger('request_data_id')->nullable();
            $table->foreign('request_data_id')->references('id')->on('request_datas');



            $table->unsignedBigInteger('request_id')->nullable();
            $table->foreign('request_id')->references('id')->on('requests');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_datas');
    }
};
