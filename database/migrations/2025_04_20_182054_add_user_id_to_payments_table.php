<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('payments', function (Blueprint $table) {
        // Add user_id as an unsignedBigInteger to match users table id
        $table->unsignedBigInteger('user_id')->after('reservation_id');

        // Add the foreign key constraint
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('payments', function (Blueprint $table) {
        // Drop foreign key constraint and column
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
