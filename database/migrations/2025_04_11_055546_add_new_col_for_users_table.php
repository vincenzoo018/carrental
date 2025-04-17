<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role');
            $table->string('phone_number');
            $table->string('address');
            $table->unsignedBigInteger('role_id');
            $table->string('license');
            $table->foreign('role_id')->references('role_id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('phone_number');
            $table->dropColumn('address');
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
