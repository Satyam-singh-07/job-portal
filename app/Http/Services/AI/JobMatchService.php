<?php

namespace App\Http\Services\AI;

use App\Models\Job;
use App\Models\User;

class JobMatchService
{
    public function score(User $candidate, Job $job): array
    {
        $profile = $candidate->candidateProfile;

        if (! $profile) {
            return [
                'score' => 0,
                'label' => 'Low',
                'highlights' => ['Complete your profile for better AI matching'],
            ];
        }

        $score = 0;
        $highlights = [];

        $jobSkills = $this->tokenize((string) $job->skills);
        $candidateSkills = $this->tokenizeSkills($profile->skills);
        $skillMatches = count(array_intersect($candidateSkills, $jobSkills));
        $skillWeight = min(40, $skillMatches * 8);
        $score += $skillWeight;
        if ($skillWeight > 0) {
            $highlights[] = $skillMatches.' skill match'.($skillMatches === 1 ? '' : 'es');
        }

        $candidateRoleTerms = $this->tokenize((string) $profile->target_roles.' '.(string) $profile->title);
        $jobRoleTerms = $this->tokenize((string) $job->title.' '.(string) $job->department);
        $roleMatches = count(array_intersect($candidateRoleTerms, $jobRoleTerms));
        $roleWeight = min(25, $roleMatches * 6);
        $score += $roleWeight;
        if ($roleWeight > 0) {
            $highlights[] = 'Role alignment';
        }

        $locationWeight = $this->locationWeight((string) $profile->location, (string) $job->location);
        $score += $locationWeight;
        if ($locationWeight > 0) {
            $highlights[] = 'Location fit';
        }

        $employmentWeight = 0;
        $desiredType = mb_strtolower((string) $profile->desired_employment_type);
        $jobType = mb_strtolower((string) $job->employment_type);
        if ($desiredType !== '' && $jobType !== '' && str_contains($desiredType, $jobType)) {
            $employmentWeight = 10;
        }
        $score += $employmentWeight;
        if ($employmentWeight > 0) {
            $highlights[] = 'Employment type match';
        }

        $experienceWeight = $this->experienceWeight((string) $profile->experience_level, (string) $job->experience);
        $score += $experienceWeight;
        if ($experienceWeight > 0) {
            $highlights[] = 'Experience fit';
        }

        $score = max(0, min(100, (int) round($score)));

        return [
            'score' => $score,
            'label' => $score >= 75 ? 'High' : ($score >= 45 ? 'Medium' : 'Low'),
            'highlights' => array_slice($highlights, 0, 3),
        ];
    }

    protected function tokenizeSkills(mixed $skills): array
    {
        if (is_array($skills)) {
            return $this->normalizeTokens($skills);
        }

        return $this->tokenize((string) $skills);
    }

    protected function tokenize(string $text): array
    {
        return $this->normalizeTokens(preg_split('/[^a-z0-9\+\#]+/i', mb_strtolower($text)) ?: []);
    }

    protected function normalizeTokens(array $tokens): array
    {
        $stopwords = ['and', 'with', 'for', 'the', 'a', 'an', 'in', 'to', 'of', 'on'];

        return array_values(array_unique(array_filter(array_map(function ($token) {
            return trim((string) $token);
        }, $tokens), function (string $token) use ($stopwords): bool {
            return $token !== '' && mb_strlen($token) > 1 && ! in_array($token, $stopwords, true);
        })));
    }

    protected function locationWeight(string $candidateLocation, string $jobLocation): int
    {
        if ($candidateLocation === '' || $jobLocation === '') {
            return 0;
        }

        $candidate = mb_strtolower($candidateLocation);
        $job = mb_strtolower($jobLocation);

        if ($candidate === $job) {
            return 15;
        }

        if (str_contains($candidate, $job) || str_contains($job, $candidate)) {
            return 10;
        }

        return 0;
    }

    protected function experienceWeight(string $candidateLevel, string $jobExperience): int
    {
        $candidateYears = $this->extractYears($candidateLevel);
        $jobYears = $this->extractYears($jobExperience);

        if ($candidateYears === null || $jobYears === null) {
            return 0;
        }

        if ($candidateYears >= $jobYears) {
            return 10;
        }

        if (($jobYears - $candidateYears) <= 1) {
            return 5;
        }

        return 0;
    }

    protected function extractYears(string $value): ?int
    {
        if (preg_match('/(\d+)/', $value, $matches) !== 1) {
            return null;
        }

        return (int) $matches[1];
    }
}
