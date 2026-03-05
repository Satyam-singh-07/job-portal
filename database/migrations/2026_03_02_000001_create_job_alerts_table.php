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
        Schema::create('job_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role_keywords');
            $table->string('locations')->nullable();
            $table->enum('job_type', ['any', 'full_time', 'contract', 'freelance', 'internship'])->default('any');
            $table->enum('frequency', ['instant', 'daily', 'weekly'])->default('daily');
            $table->unsignedInteger('min_salary')->nullable();
            $table->enum('delivery_channel', ['email', 'in_app', 'sms'])->default('email');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'is_active']);
            $table->index(['user_id', 'updated_at']);
            $table->index('frequency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_alerts');
    }
};
