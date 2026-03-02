<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the jobs.
     */
    public function index(Request $request)
    {
        $query = Job::with('user')->where('status', 'Published');

        // Search by keyword, company, or title
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('company_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by location
        if ($request->has('location') && !empty($request->location) && $request->location !== 'Location') {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Filter by category (department)
        if ($request->has('category') && !empty($request->category) && $request->category !== 'Category') {
            $query->where('department', 'like', "%{$request->category}%");
        }

        // Filter by Job Type (employment_type)
        if ($request->has('types') && is_array($request->types)) {
            $query->whereIn('employment_type', $request->types);
        }

        // Filter by Experience
        if ($request->has('experience') && is_array($request->experience)) {
            $query->whereIn('experience', $request->experience);
        }

        // Sorting
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'recent':
                $query->latest();
                break;
            case 'salary_high':
                $query->orderBy('salary_range', 'desc'); // Note: salary_range is string, might need improvement
                break;
            case 'salary_low':
                $query->orderBy('salary_range', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $jobs = $query->paginate(10)->appends($request->all());

        if ($request->ajax()) {
            return response()->json([
                'html' => view('jobs.partials.job-list', compact('jobs'))->render(),
                'count_text' => "Showing " . $jobs->firstItem() . " - " . $jobs->lastItem() . " of " . $jobs->total() . " results",
                'total_found' => $jobs->total() . " Jobs Found"
            ]);
        }

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Display the specified job.
     */
    public function show($slug)
    {
        $job = Job::with('user')->where('slug', $slug)->where('status', 'Published')->firstOrFail();
        
        $hasApplied = false;
        if (Auth::check() && Auth::user()->isCandidate()) {
            $hasApplied = JobApplication::where('user_id', Auth::id())
                ->where('job_id', $job->id)
                ->exists();
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

        return view('jobs.show', compact('job', 'relatedJobs', 'hasApplied'));
    }
}
