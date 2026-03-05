<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Message;
use App\Models\ResumeView;
use Illuminate\View\View;

class CandidateDashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $profile = $user->candidateProfile ?? $user->candidateProfile()->create();

        $applicationsBase = $user->applications();
        $totalApplications = (clone $applicationsBase)->count();

        $statusCounts = (clone $applicationsBase)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $recentApplications = (clone $applicationsBase)
            ->with(['job.user'])
            ->latest()
            ->take(6)
            ->get();

        $followingCount = $user->followingEmployers()->count();
        $followingsPreview = $user->followingEmployers()
            ->withCount([
                'jobs as open_jobs_count' => function ($query) {
                    $query->where('status', 'Published');
                },
            ])
            ->latest('employer_followers.created_at')
            ->take(3)
            ->get();

        $profileViews = ResumeView::query()
            ->where('candidate_user_id', $user->id)
            ->count();

        $unreadMessages = Message::query()
            ->whereNull('read_at')
            ->where('sender_user_id', '!=', $user->id)
            ->whereHas('conversation', function ($query) use ($user) {
                $query->where('candidate_user_id', $user->id);
            })
            ->count();

        $resumeCount = $profile->resume ? 1 : 0;

        $appliedJobIds = $user->applications()->pluck('job_id');
        $keywords = collect(preg_split('/[\n,|]+/', (string) $profile->target_roles))
            ->map(fn (string $value): string => trim($value))
            ->filter(fn (string $value): bool => $value !== '')
            ->take(5)
            ->values();

        $recommendedJobsQuery = Job::query()
            ->where('status', 'Published')
            ->whereNotIn('id', $appliedJobIds)
            ->with('user:id,company_name,logo')
            ->select([
                'id',
                'user_id',
                'title',
                'slug',
                'location',
                'department',
                'employment_type',
                'salary_range',
                'created_at',
            ]);

        if ($keywords->isNotEmpty()) {
            $recommendedJobsQuery->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $search = addcslashes($keyword, '\\%_');
                    $query->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('department', 'like', "%{$search}%");
                }
            });
        }

        if ($profile->location) {
            $searchLocation = addcslashes((string) $profile->location, '\\%_');
            $recommendedJobsQuery->orderByRaw(
                "CASE WHEN location LIKE ? THEN 0 ELSE 1 END",
                ["%{$searchLocation}%"]
            );
        }

        $recommendedJobs = $recommendedJobsQuery
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'profile_views' => $profileViews,
            'followings' => $followingCount,
            'resume_versions' => $resumeCount,
            'unread_messages' => $unreadMessages,
            'applications_total' => $totalApplications,
            'applications_pending' => (int) ($statusCounts['Pending'] ?? 0),
            'applications_interviewing' => (int) ($statusCounts['Interviewing'] ?? 0),
            'applications_offered' => (int) ($statusCounts['Offered'] ?? 0),
            'application_balance' => (int) ($user->job_application_balance ?? 0),
        ];

        return view('candidates.dashboard', [
            'profile' => $profile,
            'stats' => $stats,
            'recentApplications' => $recentApplications,
            'recommendedJobs' => $recommendedJobs,
            'followingsPreview' => $followingsPreview,
        ]);
    }
}
