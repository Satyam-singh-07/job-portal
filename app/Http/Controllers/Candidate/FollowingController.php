<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FollowingController extends Controller
{
    public function index(): View
    {
        $candidate = auth()->user();

        $followings = $candidate->followingEmployers()
            ->whereHas('role', fn ($q) => $q->where('name', 'employer'))
            ->withCount([
                'jobs as open_jobs_count' => fn ($q) => $q->where('status', 'Published'),
            ])
            ->latest('employer_followers.created_at')
            ->paginate(12);

        return view('candidates.followings', compact('followings'));
    }

    public function store(User $employer): RedirectResponse
    {
        $candidate = auth()->user();

        if (! $candidate->isCandidate()) {
            abort(403);
        }

        if (! $employer->isEmployer()) {
            abort(404);
        }

        if ($candidate->id === $employer->id) {
            return back()->with('error', 'You cannot follow your own account.');
        }

        $candidate->followingEmployers()->syncWithoutDetaching([$employer->id]);

        return back()->with('success', 'You are now following '.$this->displayEmployerName($employer).'.');
    }

    public function destroy(User $employer): RedirectResponse
    {
        $candidate = auth()->user();

        if (! $candidate->isCandidate()) {
            abort(403);
        }

        $candidate->followingEmployers()->detach($employer->id);

        return back()->with('success', 'Unfollowed '.$this->displayEmployerName($employer).'.');
    }

    protected function displayEmployerName(User $employer): string
    {
        return $employer->company_name ?: (ltrim((string) $employer->username, '@') ?: 'company');
    }
}
