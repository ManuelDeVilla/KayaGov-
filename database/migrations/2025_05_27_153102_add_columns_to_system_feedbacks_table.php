<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('system_feedbacks', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
            $table->string('title')->after('username');
            $table->enum('type', ['bug_report', 'feature_request', 'general_feedback', 'complaint'])->default('general_feedback')->after('feedback');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('type');
            $table->enum('status', ['pending', 'reviewed', 'resolved'])->default('pending')->after('priority');
        });
    }

    public function down(): void
    {
        Schema::table('system_feedbacks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'title', 'type', 'priority', 'status']);
        });
    }
};