<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->unsignedInteger('job_posting_balance')->default(0)->after('account_status');
            $table->unsignedInteger('job_application_balance')->default(0)->after('job_posting_balance');
        });

        Schema::table('jobs', function (Blueprint $table): void {
            $table->boolean('posting_credit_consumed')->default(false)->after('status');
        });

        Schema::create('platform_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('value')->nullable();
            $table->timestamps();
        });

        DB::table('platform_settings')->insert([
            [
                'key' => 'candidate_default_application_balance',
                'value' => '25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'employer_default_posting_balance',
                'value' => '10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('jobs')->where('status', 'Published')->update([
            'posting_credit_consumed' => true,
        ]);

        $candidateRoleId = DB::table('roles')->where('name', 'candidate')->value('id');
        $employerRoleId = DB::table('roles')->where('name', 'employer')->value('id');

        if ($candidateRoleId) {
            DB::table('users')
                ->where('role_id', (int) $candidateRoleId)
                ->update(['job_application_balance' => 25]);
        }

        if ($employerRoleId) {
            DB::table('users')
                ->where('role_id', (int) $employerRoleId)
                ->update(['job_posting_balance' => 10]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_settings');

        Schema::table('jobs', function (Blueprint $table): void {
            $table->dropColumn('posting_credit_consumed');
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['job_posting_balance', 'job_application_balance']);
        });
    }
};
