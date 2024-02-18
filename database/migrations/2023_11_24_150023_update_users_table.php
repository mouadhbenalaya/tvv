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
        Schema::table('users', function (Blueprint $table) {
            $table->string('second_name')->nullable();
            $table->string('third_name')->nullable();
            $table->string('id_number');
            $table->string('mobile_number');
            $table->boolean('lives_in_saudi_arabi');
            $table->foreignId('country_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('second_name');
            $table->dropColumn('third_name');
            $table->dropColumn('id_number');
            $table->dropColumn('mobile_number');
            $table->dropColumn('lives_in_saudi_arabi');
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
        });
    }
};
