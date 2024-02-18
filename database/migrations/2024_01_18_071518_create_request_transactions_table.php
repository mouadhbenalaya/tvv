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
        Schema::create('request_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('request_steps_id')->nullable();
            $table->foreign('request_steps_id')->references('id')->on('request_stepss');


            $table->unsignedBigInteger('request_id')->nullable();
            $table->foreign('request_id')->references('id')->on('requests');



            $table->unsignedBigInteger('profile_id')->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles');




            $table->unsignedBigInteger('step_action_id')->nullable();
            $table->foreign('step_action_id')->references('id')->on('step_actions');


            $table->string('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_transactions');
    }
};
