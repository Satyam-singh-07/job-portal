<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Services\Employer\JobService;
use App\Models\Message;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(protected JobService $jobService)
    {
    }

    public function index(): View
    {
        $user = auth()->user();

        $stats = $this->jobService->getEmployerStats($user);
        $stats['followers'] = $user->followers()->count();
        $stats['unread_messages'] = Message::query()
            ->whereNull('read_at')
            ->where('sender_user_id', '!=', $user->id)
            ->whereHas('conversation', function ($query) use ($user) {
                $query->where('employer_user_id', $user->id);
            })
            ->count();

        return view('employers.dashboard', [
            'stats' => $stats,
            'postingBalance' => (int) ($user->job_posting_balance ?? 0),
        ]);
    }
}
