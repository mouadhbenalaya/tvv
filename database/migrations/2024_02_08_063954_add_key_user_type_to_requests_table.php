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
        Schema::table('requests', function (Blueprint $table) {
            $table->unsignedBigInteger('trainee_profile_id')->nullable();
            $table->foreign('trainee_profile_id')->references('id')->on('profiles');

            $table->unsignedBigInteger('trainer_profile_id')->nullable();
            $table->foreign('trainer_profile_id')->references('id')->on('profiles');


            $table->string("establishmed_id")->nullable()->comment('reference facility id');

            $table->unsignedBigInteger('citie_id')->nullable();
            $table->foreign('citie_id')->references('id')->on('cities');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            //
        });
    }
};
