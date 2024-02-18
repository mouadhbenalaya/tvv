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
        Schema::table('template_steps', function (Blueprint $table) {
            $table->unsignedBigInteger('request_permission_id')->nullable();
            $table->foreign('request_permission_id')->references('id')->on('request_permissions');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_steps', function (Blueprint $table) {
            //
        });
    }
};
