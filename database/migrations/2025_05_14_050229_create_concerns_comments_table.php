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
        Schema::create('concerns_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concerns_id')->constrained('concerns', 'id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // optional but recommended
            $table->text('comment'); // renamed from 'comments'
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concerns_comments');
    }
};
