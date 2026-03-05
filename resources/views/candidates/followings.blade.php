@extends('layouts.app')

@section('title', 'My Followings')

@section('content')
<section class="dashboard-section">
    <div class="container">
        <div class="dashboard-layout">
            @include('candidates.partials.sidebar')

            <div class="dashboard-main">
                <div class="dashboard-page-header">
                    <div>
                        <h1>My Followings</h1>
                        <p>Track employers you follow and discover their latest open roles.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Discover Companies
                        </a>
                    </div>
                </div>

                <div class="row g-3">
                    @forelse($followings as $employer)
                        <div class="col-md-6 col-xl-4">
                            <div class="following-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ $employer->logo_url }}" alt="{{ $employer->company_name ?: 'Company' }}" style="width:44px;height:44px;border-radius:8px;object-fit:cover;">
                                    <h4 class="mb-0">{{ $employer->company_name ?: 'Company' }}</h4>
                                </div>
                                <p class="mb-2">{{ $employer->industry ?: 'Hiring in multiple industries' }}</p>
                                <span>{{ $employer->open_jobs_count ?? 0 }} Open {{ ($employer->open_jobs_count ?? 0) === 1 ? 'Job' : 'Jobs' }}</span>

                                <div class="mt-3 d-flex gap-2">
                                    <a href="{{ route('company.show', ['username' => ltrim((string) $employer->username, '@')]) }}" class="btn btn-outline-primary btn-sm">
                                        View Company
                                    </a>
                                    <form action="{{ route('candidate.followings.destroy', $employer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Unfollow</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="list-card">
                                <h3>No followings yet</h3>
                                <p class="text-muted mb-3">Follow employers to get updates when they post new jobs.</p>
                                <a href="{{ route('jobs.index') }}" class="btn btn-primary">Explore Jobs</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($followings->hasPages())
                    <div class="pagination-wrapper mt-4">
                        {{ $followings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
