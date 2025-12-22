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
        Schema::create('lightvehiclescorings', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->string('asset_name');
            $table->string('site_name')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration_seconds')->nullable();
            $table->decimal('distance_km', 8, 2)->nullable();

            $table->decimal('overspeed_score', 5, 2)->nullable();
            $table->integer('overspeed_occ')->nullable();
            $table->integer('overspeed_max')->nullable();
            $table->integer('overspeed_duration')->nullable();

            $table->decimal('overrev_score', 5, 2)->nullable();
            $table->integer('overrev_occ')->nullable();
            $table->integer('overrev_max')->nullable();
            $table->integer('overrev_duration')->nullable();

            $table->decimal('harsh_acc_score', 5, 2)->nullable();
            $table->integer('harsh_acc_occ')->nullable();
            $table->integer('harsh_acc_max')->nullable();
            $table->integer('harsh_acc_duration')->nullable();

            $table->decimal('harsh_brake_score', 5, 2)->nullable();
            $table->integer('harsh_brake_occ')->nullable();
            $table->integer('harsh_brake_max')->nullable();
            $table->integer('harsh_brake_duration')->nullable();

            $table->decimal('idle_score', 5, 2)->nullable();
            $table->integer('idle_occ')->nullable();
            $table->integer('idle_duration')->nullable();

            $table->decimal('greenband_percentage', 5, 2)->nullable();
            $table->integer('greenband_duration')->nullable();

            $table->decimal('overall_score', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lightvehiclescorings');
    }
};
