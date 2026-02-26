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
            <a href="#." class="btn btn-outline-primary"><i class="fa-solid fa-filter" aria-hidden="true"></i> Filters</a>
            <a href="#." class="btn btn-primary"><i class="fa-solid fa-arrow-rotate-right" aria-hidden="true"></i> Sync updates</a>
          </div>
        </div>

        <div class="row row-cols-1 row-cols-lg-2 g-4 application-grid">
          <div class="col">
            <div class="application-card">
              <div class="application-header">
                <span class="status-chip interview">Interview</span>
              </div>
              <div class="application-title">
                <h4><a href="job-detail.html">Lead Product Designer</a></h4>
                <div class="application-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Remote · North America</div>
                <p>Skyline Digital · Design Systems team</p>
              </div>
              <div class="application-pill"><i class="fa-solid fa-calendar-check" aria-hidden="true"></i> Loop scheduled for Apr 20</div>
              <div class="application-footer">
                <div class="application-meta">
                  <div class="meta-avatar"><img src="images/employers/emplogo1.jpg" alt="Skyline Digital"></div>
                  <div>
                    <span class="meta-label">Applied 12 days ago</span>
                    <span class="meta-value">via Jobs Portal</span>
                  </div>
                </div>
                <a href="#." class="btn btn-outline-primary btn-sm rounded-pill">View thread</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="application-card">
              <div class="application-header">
                <span class="status-chip review">Review</span>
              </div>
              <div class="application-title">
                <h4><a href="job-detail.html">Senior Frontend Engineer</a></h4>
                <div class="application-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Berlin, Germany</div>
                <p>Bright Labs · Platform squad</p>
              </div>
              <div class="application-pill"><i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i> Awaiting recruiter response</div>
              <div class="application-footer">
                <div class="application-meta">
                  <div class="meta-avatar"><img src="images/employers/emplogo7.jpg" alt="Bright Labs"></div>
                  <div>
                    <span class="meta-label">Applied 5 days ago</span>
                    <span class="meta-value">Referral · Maya</span>
                  </div>
                </div>
                <a href="#." class="btn btn-outline-primary btn-sm rounded-pill">Send nudge</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="application-card">
              <div class="application-header">
                <span class="status-chip offer">Offer</span>
              </div>
              <div class="application-title">
                <h4><a href="job-detail.html">Product Design Manager</a></h4>
                <div class="application-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Toronto, Canada</div>
                <p>Northwind Commerce · Growth org</p>
              </div>
              <div class="application-pill"><i class="fa-solid fa-badge-dollar" aria-hidden="true"></i> Offer received · reviewing</div>
              <div class="application-footer">
                <div class="application-meta">
                  <div class="meta-avatar"><img src="images/employers/emplogo4.jpg" alt="Northwind"></div>
                  <div>
                    <span class="meta-label">Applied 22 days ago</span>
                    <span class="meta-value">Recruiter: Alex Chen</span>
                  </div>
                </div>
                <a href="#." class="btn btn-outline-primary btn-sm rounded-pill">Open offer</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="application-card">
              <div class="application-header">
                <span class="status-chip archived">Archived</span>
              </div>
              <div class="application-title">
                <h4><a href="job-detail.html">Staff UX Researcher</a></h4>
                <div class="application-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Austin, USA</div>
                <p>CloudSync · Platform strategy</p>
              </div>
              <div class="application-pill"><i class="fa-solid fa-circle-xmark" aria-hidden="true"></i> Closed · keep warm</div>
              <div class="application-footer">
                <div class="application-meta">
                  <div class="meta-avatar"><img src="images/employers/emplogo9.jpg" alt="CloudSync"></div>
                  <div>
                    <span class="meta-label">Applied Feb 03</span>
                    <span class="meta-value">Feedback saved</span>
                  </div>
                </div>
                <a href="#." class="btn btn-outline-secondary btn-sm rounded-pill">View notes</a>
              </div>
            </div>
          </div>
        </div>

        <div class="list-card mt-4">
          <h3>Next Steps</h3>
          <ul>
            <li>
              <div>
                <strong>Prepare for Skyline loop</strong>
                <p class="mb-0 text-muted">Portfolio presentation + systems whiteboard.</p>
              </div>
              <a href="#." class="btn btn-outline-primary btn-sm rounded-3">Open prep kit</a>
            </li>
            <li>
              <div>
                <strong>Follow up with Bright Labs</strong>
                <p class="mb-0 text-muted">Send quick note if no update by Apr 18.</p>
              </div>
              <a href="#." class="btn btn-outline-secondary btn-sm rounded-3">Send reminder</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection