<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;

class EmployerController extends Controller
{
    public function show(string $username)
    {
        $normalizedUsername = ltrim(trim($username), '@');

        $employer = User::where(function ($query) use ($normalizedUsername) {
            $query->where('username', '@'.$normalizedUsername)
                ->orWhere('username', $normalizedUsername);
        })
            ->firstOrFail();

        if (! $employer->isEmployer()) {
            abort(404, 'Company not found');
        }

        $openJobs = Job::where('user_id', $employer->id)
            ->where('status', 'Published')
            ->withCount([
                'applications',
                'jobViews as views_count',
            ])
            ->latest()
            ->get();

        $totalApplicants = JobApplication::whereHas('job', function ($query) use ($employer) {
            $query->where('user_id', $employer->id);
        })->count();

        return view('employers.show', [
            'employer' => $employer,
            'openJobs' => $openJobs,
            'totalApplicants' => $totalApplicants,
        ]);
    }
}
