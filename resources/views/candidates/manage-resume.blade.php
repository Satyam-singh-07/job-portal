 @extends('layouts.app')

@section('title', 'Manage Resume')

@section('content')

   <section class="dashboard-section">
      <div class="container">
        <div class="dashboard-layout">
         
                @include('candidates.partials.sidebar')

                
          <div class="dashboard-main">
            <div class="dashboard-page-header">
              <div>
                <h1>Manage Resume Library</h1>
                <p>
                  Organize multiple versions, set a default, and collaborate
                  with recruiters in one spot.
                </p>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('candidate.edit-profile') }}" class="btn btn-outline-primary"
                  ><i class="fa-solid fa-upload" aria-hidden="true"></i>
                  Upload / Replace Resume</a
                >
                <a href="{{ route('candidate.build-resume') }}" class="btn btn-primary"
                  ><i class="fa-solid fa-pen" aria-hidden="true"></i> Edit in
                  builder</a
                >
              </div>
            </div>

            <div class="list-card">
              <h3>Resume Versions</h3>
              <ul>
                <li>
                  <div>
                    <strong>{{ $profile->title ?: 'Default Resume' }}</strong>
                    <p class="mb-0 text-muted">
                      Default · Used in {{ $applicationsWithResume }} applications ·
                      {{ $lastResumeViewAt ? 'Last viewed '.$lastResumeViewAt->diffForHumans() : 'No views yet' }}
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    @if ($profile->resume)
                      <a href="{{ \Illuminate\Support\Facades\Storage::url($profile->resume) }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-success btn-sm rounded-3">
                        View Resume
                      </a>
                    @else
                      <button class="btn btn-outline-secondary btn-sm rounded-3" disabled>
                        No Resume Uploaded
                      </button>
                    @endif
                  </div>
                </li>
                <li>
                  <div>
                    <strong>Resume Views</strong>
                    <p class="mb-0 text-muted">
                      Employers opened your resume {{ $resumeViewsCount }} times.
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('candidate.applications') }}" class="btn btn-outline-primary btn-sm rounded-3">
                      View Applications
                    </a>
                  </div>
                </li>
                <li>
                  <div>
                    <strong>Visibility</strong>
                    <p class="mb-0 text-muted">
                      Resume is {{ $profile->is_searchable ? 'searchable' : 'not searchable' }} for recruiters.
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('candidate.edit-profile') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                      Update Visibility
                    </a>
                  </div>
                </li>
              </ul>
            </div>

            <div class="settings-card mt-4">
              <div class="settings-card-header">
                <div>
                  <p class="text-uppercase text-muted small fw-semibold mb-1">
                    Storage
                  </p>
                  <h3>Version Controls</h3>
                  <p>
                    Rename, annotate, or archive older versions to keep things
                    tidy.
                  </p>
                </div>
              </div>
              <div class="settings-grid">
                <div>
                  <label class="form-label" for="versionName"
                    >Version name</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="versionName"
                    placeholder="Fall 2025 Fintech"
                  />
                </div>
                <div>
                  <label class="form-label" for="versionTemplate"
                    >Template</label
                  >
                  <select class="form-select" id="versionTemplate">
                    <option selected>Minimal ATS</option>
                    <option>Vibrant</option>
                    <option>Editorial</option>
                    <option>Startup</option>
                  </select>
                </div>
                <div class="grid-span-2">
                  <label class="form-label" for="versionNotes">Notes</label>
                  <textarea
                    class="form-control"
                    id="versionNotes"
                    placeholder="Great for roles that emphasize design systems + scaling teams."
                  ></textarea>
                </div>
              </div>
              <div class="form-actions mt-3">
                <button type="button" class="btn btn-outline-secondary">
                  Cancel
                </button>
                <button type="button" class="btn btn-primary">
                  Save changes
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>



@endsection
