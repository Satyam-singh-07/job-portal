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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('employer_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('job_id')->nullable()->constrained('jobs')->nullOnDelete();
            $table->string('subject')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->unique(['candidate_user_id', 'employer_user_id', 'job_id'], 'conversation_unique_triplet');
            $table->index(['candidate_user_id', 'last_message_at']);
            $table->index(['employer_user_id', 'last_message_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
