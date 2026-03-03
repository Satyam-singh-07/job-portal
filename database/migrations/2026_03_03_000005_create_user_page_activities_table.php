<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_page_activities', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('path', 2048);
            $table->string('path_hash', 64);
            $table->string('page_title')->nullable();
            $table->date('activity_date');
            $table->unsignedInteger('total_seconds')->default(0);
            $table->timestamp('last_seen_at')->nullable();
            $table->string('session_id', 120)->nullable();
            $table->timestamps();

            $table->index(['activity_date', 'user_id']);
            $table->index('last_seen_at');
            $table->unique(['user_id', 'activity_date', 'path_hash', 'session_id'], 'user_activity_unique_daily_page');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_page_activities');
    }
};
