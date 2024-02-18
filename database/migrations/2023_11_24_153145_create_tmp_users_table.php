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
        Schema::create('tmp_users', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('validation_token')->unique();
            $table->dateTime('validated_at')->nullable();
            $table->boolean('first_validation')->nullable()->default(null);
            $table->foreignId('user_type_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmp_users');
    }
};
