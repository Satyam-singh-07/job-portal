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
