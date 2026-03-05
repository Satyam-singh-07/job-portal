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
        Schema::table('jobs', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'jobs_status_created_idx');
            $table->index(['status', 'employment_type'], 'jobs_status_employment_idx');
            $table->index(['status', 'experience'], 'jobs_status_experience_idx');
            $table->index(['status', 'department'], 'jobs_status_department_idx');
            $table->index(['status', 'location'], 'jobs_status_location_idx');
            $table->index(['user_id', 'status'], 'jobs_user_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropIndex('jobs_status_created_idx');
            $table->dropIndex('jobs_status_employment_idx');
            $table->dropIndex('jobs_status_experience_idx');
            $table->dropIndex('jobs_status_department_idx');
            $table->dropIndex('jobs_status_location_idx');
            $table->dropIndex('jobs_user_status_idx');
        });
    }
};
