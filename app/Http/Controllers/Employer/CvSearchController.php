<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CvSearchController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'experience_level' => ['nullable', 'string', 'max:255'],
            'work_preference' => ['nullable', 'string', 'max:255'],
            'desired_employment_type' => ['nullable', 'string', 'max:255'],
            'has_resume' => ['nullable', 'in:0,1'],
            'sort' => ['nullable', 'in:recent,oldest,name_asc,name_desc'],
        ]);

        $query = CandidateProfile::query()
            ->with('user:id,first_name,last_name,email,username,logo')
            ->where('is_searchable', true)
            ->whereHas('user.role', function ($roleQuery) {
                $roleQuery->where('name', 'candidate');
            });

        $search = trim((string) ($validated['q'] ?? ''));
        if ($search !== '') {
            $safeSearch = addcslashes($search, '\\%_');
            $query->where(function ($profileQuery) use ($safeSearch) {
                $profileQuery->where('title', 'like', "%{$safeSearch}%")
                    ->orWhere('target_roles', 'like', "%{$safeSearch}%")
                    ->orWhere('skills', 'like', "%{$safeSearch}%")
                    ->orWhere('current_company', 'like', "%{$safeSearch}%")
                    ->orWhere('location', 'like', "%{$safeSearch}%")
                    ->orWhereHas('user', function ($userQuery) use ($safeSearch) {
                        $userQuery->where('first_name', 'like', "%{$safeSearch}%")
                            ->orWhere('last_name', 'like', "%{$safeSearch}%")
                            ->orWhere('email', 'like', "%{$safeSearch}%")
                            ->orWhere('username', 'like', "%{$safeSearch}%");
                    });
            });
        }

        if (! empty($validated['location'])) {
            $location = addcslashes((string) $validated['location'], '\\%_');
            $query->where('location', 'like', "%{$location}%");
        }

        if (! empty($validated['experience_level'])) {
            $query->where('experience_level', $validated['experience_level']);
        }

        if (! empty($validated['work_preference'])) {
            $query->where('work_preference', $validated['work_preference']);
        }

        if (! empty($validated['desired_employment_type'])) {
            $query->where('desired_employment_type', $validated['desired_employment_type']);
        }

        if (array_key_exists('has_resume', $validated)) {
            if ((string) $validated['has_resume'] === '1') {
                $query->whereNotNull('resume')->where('resume', '!=', '');
            } else {
                $query->where(function ($subQuery) {
                    $subQuery->whereNull('resume')->orWhere('resume', '');
                });
            }
        }

        switch ($validated['sort'] ?? 'recent') {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->join('users', 'users.id', '=', 'candidate_profiles.user_id')
                    ->orderBy('users.first_name')
                    ->orderBy('users.last_name')
                    ->select('candidate_profiles.*');
                break;
            case 'name_desc':
                $query->join('users', 'users.id', '=', 'candidate_profiles.user_id')
                    ->orderByDesc('users.first_name')
                    ->orderByDesc('users.last_name')
                    ->select('candidate_profiles.*');
                break;
            case 'recent':
            default:
                $query->latest();
                break;
        }

        $candidates = $query->paginate(12)->withQueryString();

        $filters = [
            'q' => $validated['q'] ?? null,
            'location' => $validated['location'] ?? null,
            'experience_level' => $validated['experience_level'] ?? null,
            'work_preference' => $validated['work_preference'] ?? null,
            'desired_employment_type' => $validated['desired_employment_type'] ?? null,
            'has_resume' => $validated['has_resume'] ?? null,
            'sort' => $validated['sort'] ?? 'recent',
        ];

        $statsBase = CandidateProfile::query()
            ->where('is_searchable', true)
            ->whereHas('user.role', function ($roleQuery) {
                $roleQuery->where('name', 'candidate');
            });

        $stats = [
            'searchable_candidates' => (clone $statsBase)->count(),
            'with_resume' => (clone $statsBase)->whereNotNull('resume')->where('resume', '!=', '')->count(),
            'new_last_30_days' => (clone $statsBase)->where('updated_at', '>=', now()->subDays(30))->count(),
        ];

        $filterOptions = [
            'locations' => (clone $statsBase)
                ->whereNotNull('location')
                ->where('location', '!=', '')
                ->distinct()
                ->orderBy('location')
                ->pluck('location')
                ->values()
                ->all(),
            'experience_levels' => (clone $statsBase)
                ->whereNotNull('experience_level')
                ->where('experience_level', '!=', '')
                ->distinct()
                ->orderBy('experience_level')
                ->pluck('experience_level')
                ->values()
                ->all(),
            'work_preferences' => (clone $statsBase)
                ->whereNotNull('work_preference')
                ->where('work_preference', '!=', '')
                ->distinct()
                ->orderBy('work_preference')
                ->pluck('work_preference')
                ->values()
                ->all(),
            'employment_types' => (clone $statsBase)
                ->whereNotNull('desired_employment_type')
                ->where('desired_employment_type', '!=', '')
                ->distinct()
                ->orderBy('desired_employment_type')
                ->pluck('desired_employment_type')
                ->values()
                ->all(),
        ];

        return view('employer.cv-search', compact('candidates', 'filters', 'stats', 'filterOptions'));
    }
}
