<?php

namespace App\Http\Services\Candidate;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CandidateProfileService
{
    public function update(User $user, $request)
    {
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'website' => $request->website,
            'summary' => $request->summary,
        ]);

        $profileData = $request->only([
            'title',
            'phone',
            'location',
            'preferred_locations',
            'portfolio_url',
            'experience_level',
            'current_company',
            'notice_period',
            'desired_employment_type',
            'salary_expectation',
            'work_preference',
            'target_roles',
            'social_links',
        ]);

        if ($request->skills_input) {
            $profileData['skills'] = array_map('trim', explode(',', $request->skills_input));
        } else {
            $profileData['skills'] = [];
        }

        if ($request->hasFile('resume')) {
            if ($user->candidateProfile?->resume) {
                Storage::delete($user->candidateProfile->resume);
            }
            $profileData['resume'] = $request->file('resume')->store('resumes');
        }

        $user->candidateProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );
    }

    public function uploadPhoto(User $user, UploadedFile $file): string
    {
        if ($user->logo) {
            Storage::delete($user->logo);
        }

        $path = $file->store('avatars');
        $user->update(['logo' => $path]);

        return Storage::url($path);
    }
}
