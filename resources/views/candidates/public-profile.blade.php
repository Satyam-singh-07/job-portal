 @extends('layouts.app')

@section('title', 'Public Profile Preview')

@section('content')



  <section class="dashboard-section">
      <div class="container">
        <div class="dashboard-layout">
            @include('candidates.partials.sidebar')


          <div class="dashboard-main">
            <div class="dashboard-page-header">
              <div>
                <h1>Public Profile Preview</h1>
                <p>
                  Review what hiring teams see, control visibility, and keep
                  your showcase links updated.
                </p>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <a href="#." class="btn btn-outline-primary"
                  ><i class="fa-solid fa-link" aria-hidden="true"></i> Copy
                  link</a
                >
                <a href="#." class="btn btn-primary"
                  ><i class="fa-solid fa-eye" aria-hidden="true"></i> View live
                  profile</a
                >
              </div>
            </div>

            <div class="dashboard-cover-card mb-4">
              <div class="dashboard-cover-media">
                <img src="images/dashboard-cover.html" alt="Profile cover" />
              </div>
              <div class="dashboard-cover-profile">
                <div class="cover-avatar">
                  <img src="images/candidates/01.jpg" alt="Job Seeker" />
                </div>
                <div>
                  <h3>Job Seeker</h3>
                  <p>
                    Lead Product Designer · Remote friendly · Currently shipping
                    fintech experiences with Skyline Digital.
                  </p>
                  <ul>
                    <li>
                      <i
                        class="fa-solid fa-location-dot"
                        aria-hidden="true"
                      ></i>
                      Seattle, USA
                    </li>
                    <li>
                      <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                      10+ yrs experience
                    </li>
                    <li>
                      <i class="fa-solid fa-globe" aria-hidden="true"></i>
                      jobsportal.com/jordan
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="list-card">
              <h3>Visibility Controls</h3>
              <ul>
                <li>
                  <div>
                    <strong>Recruiter search</strong>
                    <p class="mb-0 text-muted">
                      Allow verified recruiters to discover you in search
                      results.
                    </p>
                  </div>
                  <label class="toggle-switch">
                    <input type="checkbox" checked />
                    <span class="toggle-slider"></span>
                  </label>
                </li>
                <li>
                  <div>
                    <strong>Public link</strong>
                    <p class="mb-0 text-muted">
                      People with the link can view your profile.
                    </p>
                  </div>
                  <label class="toggle-switch">
                    <input type="checkbox" checked />
                    <span class="toggle-slider"></span>
                  </label>
                </li>
                <li>
                  <div>
                    <strong>Search engine indexing</strong>
                    <p class="mb-0 text-muted">
                      Let Google index your profile (can take up to 2 weeks).
                    </p>
                  </div>
                  <label class="toggle-switch">
                    <input type="checkbox" />
                    <span class="toggle-slider"></span>
                  </label>
                </li>
              </ul>
            </div>

            <div class="list-card mt-4">
              <h3>Profile Sections</h3>
              <ul>
                <li>
                  <div>
                    <strong>About</strong>
                    <p class="mb-0 text-muted">
                      Visible · Last edited yesterday
                    </p>
                  </div>
                  <a
                    href="edit-profile.html"
                    class="btn btn-outline-primary btn-sm rounded-3"
                    >Edit</a
                  >
                </li>
                <li>
                  <div>
                    <strong>Experience</strong>
                    <p class="mb-0 text-muted">
                      3 roles published · case studies attached
                    </p>
                  </div>
                  <a
                    href="edit-profile.html"
                    class="btn btn-outline-primary btn-sm rounded-3"
                    >Edit</a
                  >
                </li>
                <li>
                  <div>
                    <strong>Portfolio</strong>
                    <p class="mb-0 text-muted">
                      4 links · hero thumbnails enabled
                    </p>
                  </div>
                  <a href="#." class="btn btn-outline-primary btn-sm rounded-3"
                    >Manage</a
                  >
                </li>
                <li>
                  <div>
                    <strong>Testimonials</strong>
                    <p class="mb-0 text-muted">
                      Add quotes from managers and peers.
                    </p>
                  </div>
                  <a
                    href="#."
                    class="btn btn-outline-secondary btn-sm rounded-3"
                    >Add</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>



@endsection