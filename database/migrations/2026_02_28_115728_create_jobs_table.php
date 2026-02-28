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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('department')->nullable();
            $table->string('location');
            $table->string('employment_type');
            $table->string('salary_range')->nullable();
            $table->string('seniority');
            $table->string('experience');
            $table->integer('open_roles')->default(1);
            $table->boolean('visa_sponsorship')->default(false);
            $table->text('summary');
            $table->text('responsibilities')->nullable();
            $table->text('skills')->nullable();
            $table->string('application_email')->nullable();
            $table->string('external_apply_link')->nullable();
            $table->boolean('allow_quick_apply')->default(true);
            $table->enum('status', ['Draft', 'Published', 'Closed'])->default('Draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
