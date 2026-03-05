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
        Schema::create('resume_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained('job_applications')->onDelete('cascade');
            $table->foreignId('candidate_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('employer_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('viewed_at');
            $table->timestamps();

            $table->index(['candidate_user_id', 'viewed_at']);
            $table->index(['job_application_id', 'viewed_at']);
            $table->index(['employer_user_id', 'viewed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_views');
    }
};
