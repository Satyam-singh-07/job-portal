<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\ResumeView;
use Illuminate\Support\Carbon;

class ResumeController extends Controller
{
    public function manage()
    {
        $user = auth()->user();
        $profile = $user->candidateProfile ?? $user->candidateProfile()->create();

        $applicationsWithResume = $user->applications()
            ->whereNotNull('resume_path')
            ->count();

        $resumeViewsCount = ResumeView::query()
            ->where('candidate_user_id', $user->id)
            ->count();

        $lastResumeViewAt = ResumeView::query()
            ->where('candidate_user_id', $user->id)
            ->latest('viewed_at')
            ->value('viewed_at');

        return view('candidates.manage-resume', [
            'profile' => $profile,
            'applicationsWithResume' => $applicationsWithResume,
            'resumeViewsCount' => $resumeViewsCount,
            'lastResumeViewAt' => $lastResumeViewAt ? Carbon::parse($lastResumeViewAt) : null,
        ]);
    }
}
