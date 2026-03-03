<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\UpdateCandidateProfileRequest;
use App\Http\Services\Candidate\CandidateProfileService;
use Illuminate\Http\Request;

class CandidateProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->candidateProfile ?? $user->candidateProfile()->create();

        return view('candidates.edit-profile', compact('user', 'profile'));
    }

    public function publicProfile()
    {
        $user = auth()->user();
        $profile = $user->candidateProfile ?? $user->candidateProfile()->create();

        return view('candidates.public-profile', compact('user', 'profile'));
    }

    public function updateVisibility(Request $request)
    {
        $request->validate([
            'field' => 'required|string|in:is_searchable,is_public_link_active,is_indexed_by_search_engines',
            'value' => 'required|boolean',
        ]);

        $profile = auth()->user()->candidateProfile ?? auth()->user()->candidateProfile()->create();
        $profile->update([
            $request->field => $request->value,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Visibility setting updated successfully.',
        ]);
    }

    public function updateOpenToWork(Request $request)
    {
        $validated = $request->validate([
            'open_to_work' => 'required|boolean',
        ]);

        $profile = auth()->user()->candidateProfile ?? auth()->user()->candidateProfile()->create();
        $isSearchable = (bool) $validated['open_to_work'];

        $profile->update([
            'is_searchable' => $isSearchable,
        ]);

        return response()->json([
            'status' => true,
            'open_to_work' => $profile->is_searchable,
            'message' => $profile->is_searchable
                ? 'Open to Work is enabled.'
                : 'Open to Work is disabled.',
        ]);
    }

    public function update(
        UpdateCandidateProfileRequest $request,
        CandidateProfileService $service
    ) {
        $service->update(auth()->user(), $request);

        return redirect()
            ->route('candidate.edit-profile')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePhoto(
        Request $request,
        CandidateProfileService $service
    ) {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        $path = $service->uploadPhoto($user, $request->file('photo'));

        return response()->json([
            'status' => true,
            'photo_url' => $path,
        ]);
    }
}
