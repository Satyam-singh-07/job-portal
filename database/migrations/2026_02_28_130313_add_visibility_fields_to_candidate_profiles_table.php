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
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->boolean('is_searchable')->default(true);
            $table->boolean('is_public_link_active')->default(true);
            $table->boolean('is_indexed_by_search_engines')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn(['is_searchable', 'is_public_link_active', 'is_indexed_by_search_engines']);
        });
    }
};
