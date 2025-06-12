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
        Schema::table('concerns_comments', function (Blueprint $table) {
            //

            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concerns_comments', function (Blueprint $table) {
            //
        $table->dropForeign(['user_id']);

        // Step 2: Drop the actual column
        $table->dropColumn('user_id');
        });
    }
};
