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
        Schema::create('request_stepss', function (Blueprint $table) {
            $table->id();

            $table->string("step_title_ar")->nullable();
            $table->string("step_title_en")->nullable();
            $table->integer("step_sequence")->nullable();
            $table->boolean("can_reject")->nullable();
            $table->boolean("can_return")->nullable();
            $table->boolean("status")->default(0)->nullable();

            $table->unsignedBigInteger('request_id')->nullable();
            $table->foreign('request_id')->references('id')->on('requests');


            $table->unsignedBigInteger('template_step_id')->nullable();
            $table->foreign('template_step_id')->references('id')->on('template_steps');

            $table->unsignedBigInteger('request_permission_id')->nullable();
            $table->foreign('request_permission_id')->references('id')->on('request_permissions');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_stepss');
    }
};
