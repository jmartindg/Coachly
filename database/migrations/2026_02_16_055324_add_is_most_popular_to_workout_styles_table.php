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
        Schema::table('workout_styles', function (Blueprint $table) {
            $table->boolean('is_most_popular')->default(false)->after('sort_order');
        });

        DB::table('workout_styles')
            ->where('key', 'online_coaching')
            ->update(['is_most_popular' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workout_styles', function (Blueprint $table) {
            $table->dropColumn('is_most_popular');
        });
    }
};
