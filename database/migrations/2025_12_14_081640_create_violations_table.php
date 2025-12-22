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
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->string('asset');
            $table->string('driver')->nullable();
            $table->date('date');
            $table->string('location')->nullable();
            $table->string('duration')->nullable();
            $table->integer('max_speed');
            $table->string('destination')->nullable();
            $table->string('coordinates')->nullable();
            $table->timestamps();
            $table->unique(['date', 'asset']); // prevent duplicates
        });
    }
    // php artisan make:Model lightvehiclescoring -mc

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
