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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('Pending'); // Pending, Reviewed, Interviewing, Offered, Rejected, Accepted
            $table->text('cover_letter')->nullable();
            $table->string('resume_path')->nullable(); // If candidate wants to use a specific resume for this application
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['job_id', 'user_id']); // Ensure a candidate can only apply once for a job
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
