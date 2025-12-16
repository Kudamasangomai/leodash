<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // convert existing values from Active to 1/0
        DB::table('trucks')->update([
            'status' => DB::raw("CASE WHEN status = 'active' THEN 1 ELSE 0 END")
        ]);


        Schema::table('trucks', function (Blueprint $table) {
            $table->boolean('status')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            // change column back to string
    Schema::table('trucks', function (Blueprint $table) {
        $table->string('status')->default('active')->change();
    });

    // convert boolean values back to strings
    DB::table('trucks')->update([
        'status' => DB::raw("CASE WHEN status = 1 THEN 'active' ELSE 'inactive' END")
    ]);
    }
};
