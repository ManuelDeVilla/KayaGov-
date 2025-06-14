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
        Schema::create('concern_priorities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('Users', 'id')->onDelete('cascade');
            $table->foreignId('concern_id')->constrained('concerns', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concern_priorities');
    }
};
