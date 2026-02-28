<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\UpdateCompanyProfileRequest;
use App\Http\Services\Employer\CompanyProfileService;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function edit()
    {

        $employer = auth()->user();

        $industries = config('industries.list'); // dynamic industries

        return view('employers.company-profile', compact('employer', 'industries'));
    }

    public function update(
        UpdateCompanyProfileRequest $request,
        CompanyProfileService $service
    ) {
        $service->update(auth()->user(), $request);

        return redirect()
            ->route('employer.company-profile')
            ->with('success', 'Company profile updated successfully.');
    }

    public function updateLogo(
        Request $request,
        CompanyProfileService $service
    ) {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        $path = $service->uploadLogo($user, $request->file('logo'));

        return response()->json([
            'status' => true,
            'logo_url' => $path,
        ]);
    }
}
