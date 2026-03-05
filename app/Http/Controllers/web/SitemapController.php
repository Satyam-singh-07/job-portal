<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = $this->staticUrls()
            ->merge($this->jobLocationUrls())
            ->merge($this->jobUrls())
            ->merge($this->employerUrls())
            ->unique('loc')
            ->values();

        return response()
            ->view('sitemap.index', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    protected function staticUrls(): Collection
    {
        return collect([
            [
                'loc' => route('home'),
                'lastmod' => now(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('jobs.index'),
                'lastmod' => now(),
                'changefreq' => 'hourly',
                'priority' => '0.9',
            ],
            [
                'loc' => route('employers.index'),
                'lastmod' => now(),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
        ]);
    }

    protected function jobUrls(): Collection
    {
        return Job::query()
            ->where('status', 'Published')
            ->select(['slug', 'updated_at'])
            ->get()
            ->map(function (Job $job): array {
                return [
                    'loc' => route('jobs.show', ['slug' => $job->slug]),
                    'lastmod' => $job->updated_at ?? now(),
                    'changefreq' => 'daily',
                    'priority' => '0.8',
                ];
            });
    }

    protected function jobLocationUrls(): Collection
    {
        return Job::query()
            ->where('status', 'Published')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->selectRaw('location, MAX(updated_at) as lastmod')
            ->groupBy('location')
            ->get()
            ->map(function (Job $job): array {
                return [
                    'loc' => route('jobs.index', ['location' => $job->location]),
                    'lastmod' => $job->lastmod ? Carbon::parse($job->lastmod) : now(),
                    'changefreq' => 'daily',
                    'priority' => '0.7',
                ];
            });
    }

    protected function employerUrls(): Collection
    {
        return User::query()
            ->whereNotNull('username')
            ->where('username', '!=', '')
            ->whereHas('role', function ($query) {
                $query->where('name', 'employer');
            })
            ->select(['username', 'updated_at'])
            ->get()
            ->map(function (User $user): array {
                $username = ltrim((string) $user->username, '@');

                return [
                    'loc' => route('company.show', ['username' => $username]),
                    'lastmod' => $user->updated_at ?? now(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            });
    }
}
