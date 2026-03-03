@extends('layouts.app')

@section('title', 'Company Followers')

@section('content')
<section class="dashboard-section employer-dashboard">
    <div class="container mt-4">
        <div class="dashboard-layout">
            @include('employers.partials.sidebar')

            <div class="dashboard-main">
                <div class="dashboard-page-header">
                    <div>
                        <h1>Company Followers</h1>
                        <p>Candidates following your company and waiting for new opportunities.</p>
                    </div>
                </div>

                <div class="row g-3">
                    @forelse($followers as $candidate)
                        @php
                            $profile = $candidate->candidateProfile;
                            $name = trim(($candidate->first_name ?? '').' '.($candidate->last_name ?? ''));
                            $name = $name !== '' ? $name : ($candidate->username ?: 'Candidate');
                        @endphp
                        <div class="col-md-6 col-xl-4">
                            <div class="following-card h-100">
                                <h4 class="mb-1">{{ $name }}</h4>
                                <p class="mb-2">{{ $profile?->title ?: 'Candidate' }} · {{ $profile?->location ?: 'Location not specified' }}</p>
                                <span>Followed {{ $candidate->pivot?->created_at?->diffForHumans() ?: 'recently' }}</span>
                                <div class="mt-3">
                                    <a href="{{ route('candidate.show') }}" class="btn btn-outline-primary btn-sm">View Candidate Profile</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="list-card">
                                <h3>No followers yet</h3>
                                <p class="text-muted mb-0">Publish jobs and keep your company profile updated to attract followers.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($followers->hasPages())
                    <div class="pagination-wrapper mt-4">
                        {{ $followers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
