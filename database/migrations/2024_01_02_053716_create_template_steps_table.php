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
        Schema::create('template_steps', function (Blueprint $table) {
            $table->id();



            $table->unsignedBigInteger('request_type_id')->nullable();
            $table->foreign('request_type_id')->references('id')->on('request_types');


            $table->integer('step_sequence')->nullable();
            $table->string('step_title_ar')->nullable();
            $table->string('step_title_en')->nullable();
            $table->boolean('can_reject')->nullable();
            $table->boolean('can_return')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_steps');
    }
};
