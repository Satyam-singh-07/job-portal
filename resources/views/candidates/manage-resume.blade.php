 @extends('layouts.app')

@section('title', 'Job Alerts')

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
                <a href="#." class="btn btn-outline-primary"
                  ><i class="fa-solid fa-clone" aria-hidden="true"></i>
                  Duplicate latest</a
                >
                <a href="build-resume.html" class="btn btn-primary"
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
                    <strong>General Product Resume</strong>
                    <p class="mb-0 text-muted">
                      Default · Used in 8 applications · Last edited Apr 10
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-success btn-sm rounded-3">
                      Default
                    </button>
                    <button class="btn btn-outline-primary btn-sm rounded-3">
                      Share
                    </button>
                  </div>
                </li>
                <li>
                  <div>
                    <strong>Fintech Leadership</strong>
                    <p class="mb-0 text-muted">
                      Tailored to B2B fintech &amp; banks · Updated Mar 21
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-secondary btn-sm rounded-3">
                      Set default
                    </button>
                    <button class="btn btn-outline-danger btn-sm rounded-3">
                      Archive
                    </button>
                  </div>
                </li>
                <li>
                  <div>
                    <strong>Contract / Freelance</strong>
                    <p class="mb-0 text-muted">
                      Hourly rate focus · Updated Feb 11
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-secondary btn-sm rounded-3">
                      Set default
                    </button>
                    <button class="btn btn-outline-danger btn-sm rounded-3">
                      Archive
                    </button>
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