<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FollowerController extends Controller
{
    public function index(): View
    {
        $employer = auth()->user();

        $followers = $employer->followers()
            ->whereHas('role', fn ($q) => $q->where('name', 'candidate'))
            ->with('candidateProfile')
            ->latest('employer_followers.created_at')
            ->paginate(12);

        return view('employer.followers', compact('followers'));
    }
}
