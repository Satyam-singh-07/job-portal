<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\UserPageActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityTrackerController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'path' => ['required', 'string', 'max:2048'],
            'seconds' => ['required', 'integer', 'min:1', 'max:120'],
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        $parsedPath = parse_url($data['path'], PHP_URL_PATH);
        $parsedQuery = parse_url($data['path'], PHP_URL_QUERY);

        $path = is_string($parsedPath) && $parsedPath !== '' ? $parsedPath : '/';
        $normalizedPath = '/'.ltrim($path, '/');
        if (is_string($parsedQuery) && $parsedQuery !== '') {
            $normalizedPath .= '?'.$parsedQuery;
        }
        $pathHash = hash('sha256', $normalizedPath);

        $user = $request->user();
        $sessionId = (string) $request->session()->getId();

        $activity = UserPageActivity::query()->firstOrCreate(
            [
                'user_id' => (int) $user->id,
                'activity_date' => now()->toDateString(),
                'path' => $normalizedPath,
                'path_hash' => $pathHash,
                'session_id' => $sessionId,
            ],
            [
                'page_title' => $data['title'] ?? null,
                'total_seconds' => 0,
                'last_seen_at' => now(),
            ]
        );

        $nextTotalSeconds = min(86400, (int) $activity->total_seconds + (int) $data['seconds']);

        $activity->forceFill([
            'page_title' => $data['title'] ?? $activity->page_title,
            'total_seconds' => $nextTotalSeconds,
            'last_seen_at' => now(),
        ])->save();

        return response()->json(['ok' => true]);
    }
}
