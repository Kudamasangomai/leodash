<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('faults', function (Blueprint $table) {
            $table->string('slug', 50)->nullable()->after('id')->unique();
        });


        DB::table('faults')->get()->each(function ($fault) {
            $slug = Str::slug($fault->name, '_');
            DB::table('faults')->where('id', $fault->id)->update([
                'slug' => $slug,
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('faults', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

};
