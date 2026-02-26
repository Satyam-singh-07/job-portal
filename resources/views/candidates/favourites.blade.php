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
            <h1>Saved Roles</h1>
            <p>Curate the opportunities you want to revisit, compare comp, and stay alerted on updates.</p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="job-alerts.html" class="btn btn-outline-primary"><i class="fa-solid fa-bell" aria-hidden="true"></i> Manage alerts</a>
            <a href="job-listing.html" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Find new jobs</a>
          </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 saved-grid">
          <div class="col">
            <div class="saved-card">
              <div class="application-header">
                <span class="status-chip fulltime">Full Time</span>
              </div>
              <div class="application-title">
                <h4><a href="job-detail.html">Design Systems Architect</a></h4>
                <div class="application-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Remote · US / EU</div>
                <p>Dataloop Analytics · Product Platform</p>
              </div>
              <div class="application-pill"><i class="fa-solid fa-sack-dollar" aria-hidden="true"></i> Salary: $160k – $185k</div>
              <div class="application-footer">
                <div class="application-meta">
                  <div class="meta-avatar"><img src="images/employers/emplogo2.jpg" alt="Dataloop"></div>
                  <div>
                    <span class="meta-label">Saved Apr 12</span>
                    <span class="meta-value">via Jobs Portal</span>
                  </div>
                </div>
                <button class="btn btn-outline-danger btn-sm rounded-pill" aria-label="Remove favorite"><i class="fa-solid fa-trash" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="saved-card">
              <div class="application-header">
                <span class="status-chip contract">Contract</span>
              </div>
              <div class="application-title">
                <h4><a href="job-detail.html">Senior UX Writer</a></h4>
                <div class="application-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Austin · Hybrid</div>
                <p>NovaCloud · Experience team</p>
              </div>
              <div class="application-pill"><i class="fa-solid fa-coins" aria-hidden="true"></i> Day rate: $750</div>
              <div class="application-footer">
                <div class="application-meta">
                  <div class="meta-avatar"><img src="images/employers/emplogo6.jpg" alt="NovaCloud"></div>
                  <div>
                    <span class="meta-label">Saved Apr 09</span>
                    <span class="meta-value">Priority shortlist</span>
                  </div>
                </div>
                <a href="#." class="btn btn-outline-primary btn-sm rounded-pill">Apply</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="saved-card">
              <div class="application-header">
                <span class="status-chip fulltime">Full Time</span>
              </div>
              <div class="application-title">
                <h4><a href="job-detail.html">Head of Product Design</a></h4>
                <div class="application-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> London, UK</div>
                <p>MercuryPay · Consumer squads</p>
              </div>
              <div class="application-pill"><i class="fa-solid fa-sterling-sign" aria-hidden="true"></i> £140k – £160k</div>
              <div class="application-footer">
                <div class="application-meta">
                  <div class="meta-avatar"><img src="images/employers/emplogo3.jpg" alt="MercuryPay"></div>
                  <div>
                    <span class="meta-label">Saved Apr 01</span>
                    <span class="meta-value">Ready to share</span>
                  </div>
                </div>
                <button class="btn btn-outline-secondary btn-sm rounded-pill" aria-label="Share"><i class="fa-solid fa-share-nodes" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="saved-card">
              <div class="application-header">
                <span class="status-chip fulltime">Full Time</span>
              </div>
              <div class="application-title">
                <h4><a href="job-detail.html">Director of UX Research</a></h4>
                <div class="application-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> New York · Hybrid</div>
                <p>Atlas Health · Care Platform</p>
              </div>
              <div class="application-pill"><i class="fa-solid fa-gem" aria-hidden="true"></i> Equity + bonus</div>
              <div class="application-footer">
                <div class="application-meta">
                  <div class="meta-avatar"><img src="images/employers/emplogo8.jpg" alt="Atlas Health"></div>
                  <div>
                    <span class="meta-label">Saved Mar 28</span>
                    <span class="meta-value">Culture fit</span>
                  </div>
                </div>
                <a href="#." class="btn btn-outline-primary btn-sm rounded-pill">Apply</a>
              </div>
            </div>
          </div>
        </div>

        <div class="list-card mt-4">
          <h3>Collections</h3>
          <ul>
            <li>
              <div>
                <strong>Leadership roles</strong>
                <p class="mb-0 text-muted">6 items · US + EU</p>
              </div>
              <a href="#." class="btn btn-outline-primary btn-sm rounded-3">Open</a>
            </li>
            <li>
              <div>
                <strong>Remote-friendly</strong>
                <p class="mb-0 text-muted">8 items · Fintech focus</p>
              </div>
              <a href="#." class="btn btn-outline-primary btn-sm rounded-3">Open</a>
            </li>
            <li>
              <div>
                <strong>Shortlist</strong>
                <p class="mb-0 text-muted">3 items · Ready to apply</p>
              </div>
              <a href="#." class="btn btn-outline-secondary btn-sm rounded-3">Edit</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection