<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\JobIndexRequest;
use App\Http\Services\AI\JobMatchService;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function __construct(protected JobMatchService $jobMatchService)
    {
    }

    /**
     * Display a listing of the jobs.
     */
    public function index(JobIndexRequest $request)
    {
        $filters = $request->normalized();

        $query = Job::query()
            ->select([
                'id',
                'user_id',
                'title',
                'slug',
                'department',
                'location',
                'employment_type',
                'salary_range',
                'summary',
                'created_at',
            ])
            ->with('user:id,company_name,logo')
            ->where('status', 'Published');

        if (Auth::check() && Auth::user()->isCandidate()) {
            $query->withCount([
                'favoritedBy as is_favorited' => function ($favoriteQuery) {
                    $favoriteQuery->where('users.id', Auth::id());
                },
            ]);
        }

        if ($filters['search']) {
            $search = addcslashes($filters['search'], '\\%_');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('company_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($filters['location']) {
            $location = addcslashes($filters['location'], '\\%_');
            $query->where('location', 'like', "%{$location}%");
        }

        if ($filters['category']) {
            $category = addcslashes($filters['category'], '\\%_');
            $query->where('department', 'like', "%{$category}%");
        }

        if ($filters['types'] !== []) {
            $query->whereIn('employment_type', $filters['types']);
        }

        if ($filters['experience'] !== []) {
            $query->whereIn('experience', $filters['experience']);
        }

        switch ($filters['sort']) {
            case 'salary_high':
                $query->orderBy('salary_range', 'desc')->latest('id');
                break;
            case 'salary_low':
                $query->orderBy('salary_range', 'asc')->latest('id');
                break;
            case 'recent':
            default:
                $query->latest();
                break;
        }

        $jobs = $query
            ->paginate(10)
            ->appends(array_filter($filters, static fn (mixed $value): bool => $value !== null && $value !== []));

        if (Auth::check() && Auth::user()->isCandidate()) {
            $candidate = Auth::user()->loadMissing('candidateProfile');

            $jobs->setCollection(
                $jobs->getCollection()->map(function (Job $job) use ($candidate): Job {
                    $result = $this->jobMatchService->score($candidate, $job);
                    $job->setAttribute('ai_match_score', (int) $result['score']);
                    $job->setAttribute('ai_match_label', (string) $result['label']);
                    $job->setAttribute('ai_match_highlights', (array) $result['highlights']);

                    return $job;
                })
            );
        }

        $firstItem = $jobs->firstItem() ?? 0;
        $lastItem = $jobs->lastItem() ?? 0;
        $countText = "Showing {$firstItem} - {$lastItem} of {$jobs->total()} results";

        if ($request->ajax()) {
            return response()->json([
                'html' => view('jobs.partials.job-list', compact('jobs'))->render(),
                'count_text' => $countText,
                'total_found' => $jobs->total() . ' Jobs Found',
            ]);
        }

        $filterOptions = Cache::remember(
            'jobs:filter-options:v1',
            now()->addMinutes(10),
            function (): array {
                $baseQuery = Job::query()->where('status', 'Published');

                return [
                    'locations' => (clone $baseQuery)
                        ->whereNotNull('location')
                        ->distinct()
                        ->orderBy('location')
                        ->pluck('location')
                        ->values()
                        ->all(),
                    'categories' => (clone $baseQuery)
                        ->whereNotNull('department')
                        ->where('department', '<>', '')
                        ->distinct()
                        ->orderBy('department')
                        ->pluck('department')
                        ->values()
                        ->all(),
                ];
            }
        );

        return view('jobs.index', [
            'jobs' => $jobs,
            'filters' => $filters,
            'jobTypes' => JobIndexRequest::jobTypes(),
            'experienceLevels' => JobIndexRequest::experienceLevels(),
            'filterOptions' => $filterOptions,
            'countText' => $countText,
        ]);
    }

    /**
     * Display the specified job.
     */
    public function show($slug, Request $request)
    {
        $job = Job::with('user')->where('slug', $slug)->where('status', 'Published')->firstOrFail();

        $this->recordJobView($job->id, $request);
        
        $hasApplied = false;
        $isFavorited = false;
        $candidateApplicationBalance = null;
        $canApplyWithBalance = true;

        if (Auth::check() && Auth::user()->isCandidate()) {
            $hasApplied = JobApplication::where('user_id', Auth::id())
                ->where('job_id', $job->id)
                ->exists();

            $isFavorited = Auth::user()
                ->favoriteJobs()
                ->where('jobs.id', $job->id)
                ->exists();

            $candidateApplicationBalance = (int) (Auth::user()->job_application_balance ?? 0);
            $canApplyWithBalance = $candidateApplicationBalance > 0;
        }

        $relatedJobs = Job::with('user')
            ->where('status', 'Published')
            ->where('id', '!=', $job->id)
            ->where(function($q) use ($job) {
                $q->where('department', $job->department)
                  ->orWhere('location', 'like', "%{$job->location}%");
            })
            ->limit(3)
            ->get();

        return view('jobs.show', compact(
            'job',
            'relatedJobs',
            'hasApplied',
            'isFavorited',
            'candidateApplicationBalance',
            'canApplyWithBalance'
        ));
    }

    protected function recordJobView(int $jobId, Request $request): void
    {
        $user = $request->user();
        $ip = (string) $request->ip();
        $userAgent = (string) $request->userAgent();

        $viewerKey = $user
            ? 'user:'.$user->id
            : 'guest:'.sha1($ip.'|'.$userAgent);

        if (! Cache::add("jobs:view-lock:{$jobId}:{$viewerKey}", true, now()->addMinutes(15))) {
            return;
        }

        DB::table('job_views')->upsert([
            [
                'job_id' => $jobId,
                'user_id' => $user?->id,
                'viewer_key' => $viewerKey,
                'viewed_on' => now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['job_id', 'viewer_key', 'viewed_on'], ['updated_at']);
    }
}
