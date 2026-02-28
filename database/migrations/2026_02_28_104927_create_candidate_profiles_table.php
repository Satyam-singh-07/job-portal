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
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('preferred_locations')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('current_company')->nullable();
            $table->string('notice_period')->nullable();
            $table->string('desired_employment_type')->nullable();
            $table->string('salary_expectation')->nullable();
            $table->string('work_preference')->nullable();
            $table->text('target_roles')->nullable();
            $table->json('skills')->nullable();
            $table->json('social_links')->nullable();
            $table->string('resume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
