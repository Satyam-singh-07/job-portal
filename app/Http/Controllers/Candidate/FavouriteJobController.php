<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class FavouriteJobController extends Controller
{
    public function index(Request $request)
    {
        $favoriteJobs = $request->user()
            ->favoriteJobs()
            ->with('user')
            ->orderByPivot('created_at', 'desc')
            ->paginate(9);

        return view('candidates.favourites', compact('favoriteJobs'));
    }

    public function store(Request $request, Job $job)
    {
        if ($job->status !== 'Published') {
            return response()->json([
                'status' => false,
                'message' => 'Only published jobs can be saved.',
            ], 422);
        }

        $request->user()->favoriteJobs()->syncWithoutDetaching([$job->id]);

        return response()->json([
            'status' => true,
            'message' => 'Job saved to favourites.',
        ]);
    }

    public function destroy(Request $request, Job $job)
    {
        $request->user()->favoriteJobs()->detach($job->id);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Removed from favourites.',
            ]);
        }

        return redirect()
            ->route('candidate.favourites')
            ->with('success', 'Removed from favourites.');
    }
}
