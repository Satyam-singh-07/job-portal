<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\StoreJobAlertRequest;
use App\Http\Requests\Candidate\UpdateJobAlertStatusRequest;
use App\Http\Services\Candidate\JobAlertService;
use Illuminate\Http\Request;

class JobAlertController extends Controller
{
    public function index(Request $request, JobAlertService $service)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:all,active,paused',
            'per_page' => 'nullable|integer|min:5|max:50',
        ]);

        $status = $validated['status'] ?? 'all';
        $perPage = $validated['per_page'] ?? 10;

        $user = auth()->user();

        $alerts = $service->getForUser($user, $status, $perPage);
        $stats = $service->getStats($user);

        return view('candidates.alerts', compact('alerts', 'stats', 'status'));
    }

    public function store(StoreJobAlertRequest $request, JobAlertService $service)
    {
        $service->create(auth()->user(), $request->validated());

        return redirect()
            ->route('candidate.alerts')
            ->with('success', 'Job alert created successfully.');
    }

    public function updateStatus(
        UpdateJobAlertStatusRequest $request,
        int $alert,
        JobAlertService $service
    ) {
        $jobAlert = $service->findOwnedAlertOrFail(auth()->user(), $alert);
        $service->updateStatus($jobAlert, (bool) $request->boolean('is_active'));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Alert status updated successfully.',
            ]);
        }

        return back()->with('success', 'Alert status updated successfully.');
    }

    public function pauseAll(JobAlertService $service)
    {
        $updatedCount = $service->pauseAll(auth()->user());

        return back()->with('success', "Paused {$updatedCount} active alert(s).");
    }

    public function destroy(int $alert, JobAlertService $service)
    {
        $jobAlert = $service->findOwnedAlertOrFail(auth()->user(), $alert);
        $service->delete($jobAlert);

        return back()->with('success', 'Alert deleted successfully.');
    }
}
