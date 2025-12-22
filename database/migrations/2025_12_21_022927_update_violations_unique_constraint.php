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
        Schema::table('violations', function (Blueprint $table) {
              // 1️⃣ Drop old unique constraint
            $table->dropUnique('violations_date_asset_unique'); // name of old unique index

            // 2️⃣ Add new unique constraint including event_type
            $table->unique(['date', 'asset', 'event_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('violations', function (Blueprint $table) {
                   // 1️⃣ Drop the new unique constraint
            $table->dropUnique(['date', 'asset', 'event_type']);

            // 2️⃣ Restore old unique constraint
            $table->unique(['date', 'asset']);
        });
    }
};
