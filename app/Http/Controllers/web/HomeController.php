<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $publishedJobsQuery = Job::query()->where('status', 'Published');

        $featuredJobs = (clone $publishedJobsQuery)
            ->with('user:id,company_name,username,logo')
            ->latest()
            ->take(8)
            ->get([
                'id',
                'user_id',
                'title',
                'slug',
                'location',
                'employment_type',
                'salary_range',
                'created_at',
            ]);

        $topCompanies = User::query()
            ->whereHas('role', function ($query) {
                $query->where('name', 'employer');
            })
            ->withCount([
                'jobs as open_jobs_count' => function ($query) {
                    $query->where('status', 'Published');
                },
            ])
            ->having('open_jobs_count', '>', 0)
            ->orderByDesc('open_jobs_count')
            ->latest('id')
            ->take(8)
            ->get([
                'id',
                'company_name',
                'username',
                'logo',
                'industry',
            ]);

        $heroCategories = (clone $publishedJobsQuery)
            ->whereNotNull('department')
            ->where('department', '<>', '')
            ->distinct()
            ->orderBy('department')
            ->pluck('department')
            ->take(8)
            ->values()
            ->all();

        $heroLocations = (clone $publishedJobsQuery)
            ->whereNotNull('location')
            ->where('location', '<>', '')
            ->distinct()
            ->orderBy('location')
            ->pluck('location')
            ->take(8)
            ->values()
            ->all();

        $stats = [
            'jobs' => (clone $publishedJobsQuery)->count(),
            'companies' => User::query()
                ->whereHas('role', function ($query) {
                    $query->where('name', 'employer');
                })
                ->whereHas('jobs', function ($query) {
                    $query->where('status', 'Published');
                })
                ->count(),
            'locations' => (clone $publishedJobsQuery)
                ->whereNotNull('location')
                ->where('location', '<>', '')
                ->distinct('location')
                ->count('location'),
        ];

        return view('home', compact(
            'featuredJobs',
            'topCompanies',
            'heroCategories',
            'heroLocations',
            'stats'
        ));
    }
}
