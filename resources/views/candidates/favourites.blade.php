@extends('layouts.app')

@section('title', 'My Favourite Jobs')

@section('content')
<section class="dashboard-section">
  <div class="container">
    <div class="dashboard-layout">
      @include('candidates.partials.sidebar')

      <div class="dashboard-main">
        <div class="dashboard-page-header">
          <div>
            <h1>Saved Roles</h1>
            <p>Curate the opportunities you want to revisit, compare details, and stay updated.</p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('candidate.alerts') }}" class="btn btn-outline-primary">
              <i class="fa-solid fa-bell" aria-hidden="true"></i> Manage alerts
            </a>
            <a href="{{ route('jobs.index') }}" class="btn btn-primary">
              <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Find new jobs
            </a>
          </div>
        </div>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($favoriteJobs->count() > 0)
          <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 saved-grid">
            @foreach($favoriteJobs as $job)
              <div class="col">
                <div class="saved-card h-100 d-flex flex-column">
                  <div class="application-header">
                    <span class="status-chip {{ strtolower($job->employment_type ?? 'fulltime') }}">
                      {{ $job->employment_type ?? 'N/A' }}
                    </span>
                  </div>

                  <div class="application-title">
                    <h4>
                      <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                    </h4>
                    <div class="application-location">
                      <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                      {{ $job->location ?: 'Location not specified' }}
                    </div>
                    <p>{{ $job->user?->company_name ?: 'Company not available' }}</p>
                  </div>

                  <div class="application-pill">
                    <i class="fa-solid fa-sack-dollar" aria-hidden="true"></i>
                    Salary: {{ $job->salary_range ?: 'Not disclosed' }}
                  </div>

                  <div class="application-footer mt-auto">
                    <div class="application-meta">
                      <div class="meta-avatar">
                        <img src="{{ $job->user?->logo_url }}" alt="{{ $job->user?->company_name ?: 'Company' }}">
                      </div>
                      <div>
                        <span class="meta-label">Saved {{ optional($job->pivot?->created_at)->diffForHumans() }}</span>
                        <span class="meta-value">{{ $job->department ?: 'General' }}</span>
                      </div>
                    </div>

                    <div class="d-flex gap-2">
                      <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill">View</a>

                      <form method="POST" action="{{ route('candidate.favourites.destroy', $job->id) }}"
                        onsubmit="return confirm('Remove this job from favourites?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill" aria-label="Remove favourite">
                          <i class="fa-solid fa-trash" aria-hidden="true"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <div class="mt-4">
            {{ $favoriteJobs->withQueryString()->links() }}
          </div>
        @else
          <div class="list-card mt-4">
            <h3>No favourites yet</h3>
            <p class="text-muted mb-3">You have not saved any jobs. Explore jobs and save roles you want to revisit.</p>
            <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse jobs</a>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
