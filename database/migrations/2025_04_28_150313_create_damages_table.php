<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamagesTable extends Migration
{
    public function up()
    {
        Schema::create('damages', function (Blueprint $table) {
            $table->id('damage_id'); // Primary key
            $table->unsignedBigInteger('reservation_id'); // Foreign key reference to reservations table
            $table->string('damage_types'); // Damage types (comma-separated)
            $table->text('damage_description'); // Detailed description of the damage
            $table->enum('severity', ['minor', 'moderate', 'severe']); // Severity of damage
            $table->decimal('repair_cost', 10, 2); // Estimated repair cost
            $table->decimal('violation_fee', 10, 2); // Violation fee
            $table->boolean('insurance_claim')->default(false); // Whether insurance claim is filed
            $table->json('damage_photos')->nullable(); // Store damage photos (JSON array)
            $table->date('assessment_date'); // Date of the assessment
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraints
            $table->foreign('reservation_id')->references('reservation_id')->on('reservations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('damages');
    }
}
