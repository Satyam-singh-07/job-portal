@extends('layouts.app')

@section('title', 'My Job Applications')

@section('content')

<section class="dashboard-section">
  <div class="container">
    <div class="dashboard-layout">
     
        @include('candidates.partials.sidebar')

      <div class="dashboard-main">
        <div class="dashboard-page-header">
          <div>
            <h1>My Job Applications</h1>
            <p>Stay on top of every pipeline stage, feedback, and recruiter follow-up.</p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            {{-- <a href="#." class="btn btn-outline-primary"><i class="fa-solid fa-filter" aria-hidden="true"></i> Filters</a> --}}
            <button onclick="location.reload()" class="btn btn-primary"><i class="fa-solid fa-arrow-rotate-right" aria-hidden="true"></i> Sync updates</button>
          </div>
        </div>

        <div class="alert {{ ($applicationBalance ?? 0) <= 2 ? 'alert-warning' : 'alert-info' }} d-flex justify-content-between align-items-center">
          <span><i class="fa-solid fa-wallet" aria-hidden="true"></i> Remaining application credits</span>
          <strong>{{ number_format((int) ($applicationBalance ?? 0)) }}</strong>
        </div>

        <div class="row row-cols-1 row-cols-lg-2 g-4 application-grid" id="applicationsContainer">
          @forelse($applications as $application)
            <div class="col" data-application-id="{{ $application->id }}">
              <div class="application-card">
                <div class="application-header">
                  <span class="status-chip {{ strtolower($application->status) }}">
                    {{ $application->status }}
                  </span>
                </div>
                <div class="application-title">
                  <h4><a href="{{ route('jobs.show', $application->job->slug) }}">{{ $application->job->title }}</a></h4>
                  <div class="application-location">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i> 
                    {{ $application->job->location }}
                  </div>
                  <p>{{ $application->job->user->company_name }} · {{ $application->job->department ?? 'General' }}</p>
                </div>
                
                <div class="application-pill">
                  <i class="fa-solid fa-clock" aria-hidden="true"></i> 
                  Last update: {{ $application->updated_at->diffForHumans() }}
                </div>

                <div class="application-footer">
                  <div class="application-meta">
                    <div class="meta-avatar">
                      <img src="{{ $application->job->user->logo_url }}" alt="{{ $application->job->user->company_name }}">
                    </div>
                    <div>
                      <span class="meta-label">Applied {{ $application->created_at->diffForHumans() }}</span>
                      <span class="meta-value">via Jobs Portal</span>
                    </div>
                  </div>
                  <div class="d-flex gap-2">
                    @if(in_array($application->status, ['Pending', 'Reviewed']))
                      <button onclick="withdrawApplication({{ $application->id }})" class="btn btn-outline-danger btn-sm rounded-pill">
                        Withdraw
                      </button>
                    @endif
                    <a href="{{ route('jobs.show', $application->job->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill">View Job</a>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 w-100">
              <div class="empty-state text-center py-5 bg-white rounded-4 shadow-sm">
                <i class="fa-solid fa-briefcase fa-3x mb-3 text-muted"></i>
                <h3>No Applications Yet</h3>
                <p>You haven't applied for any jobs. Start exploring opportunities today!</p>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary mt-2">Browse Jobs</a>
              </div>
            </div>
          @endforelse
        </div>

        @if($applications->hasPages())
          <div class="mt-4">
            {{ $applications->links() }}
          </div>
        @endif

        {{-- <div class="list-card mt-4">
          <h3>Next Steps</h3>
          <ul>
            <li>
              <div>
                <strong>Prepare for Skyline loop</strong>
                <p class="mb-0 text-muted">Portfolio presentation + systems whiteboard.</p>
              </div>
              <a href="#." class="btn btn-outline-primary btn-sm rounded-3">Open prep kit</a>
            </li>
          </ul>
        </div> --}}
      </div>
    </div>
  </div>
</section>

@endsection

@section('scripts')
<script>
function withdrawApplication(applicationId) {
    if (confirm('Are you sure you want to withdraw this application? This action cannot be undone.')) {
        $.ajax({
            url: `/candidate/applications/${applicationId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showToast(response.message);
                    $(`[data-application-id="${applicationId}"]`).fadeOut(300, function() {
                        $(this).remove();
                        if ($('#applicationsContainer').children().length === 0) {
                            location.reload();
                        }
                    });
                }
            },
            error: function(xhr) {
                showToast(xhr.responseJSON?.message || 'Something went wrong.', 'error');
            }
        });
    }
}

const showToast = (message, type = 'success') => {
    const $toast = $('#liveToast');
    $toast.removeClass('bg-success bg-danger').addClass(`bg-${type === 'success' ? 'success' : 'danger'}`);
    $toast.find('.toast-body').text(message);
    const toast = new bootstrap.Toast($toast[0]);
    toast.show();
};
</script>
@endsection
