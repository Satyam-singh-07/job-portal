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
                <h1>Following</h1>
                <p>
                  Keep tabs on companies you admire and get nudged when they
                  post new roles.
                </p>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <a href="#." class="btn btn-outline-primary"
                  ><i class="fa-solid fa-bell" aria-hidden="true"></i> Notify
                  me</a
                >
                <a href="job-listing.html" class="btn btn-primary"
                  ><i
                    class="fa-solid fa-magnifying-glass"
                    aria-hidden="true"
                  ></i>
                  Discover companies</a
                >
              </div>
            </div>

            <div class="row g-3">
              <div class="col-md-6 col-xl-4">
                <div class="following-card h-100">
                  <h4>Skyline Digital</h4>
                  <p>
                    Product &amp; Engineering · San Francisco · Remote friendly
                  </p>
                  <span>3 Open Jobs</span>
                </div>
              </div>
              <div class="col-md-6 col-xl-4">
                <div class="following-card h-100">
                  <h4>Northwind Commerce</h4>
                  <p>Ecommerce Platform · Toronto · Hybrid</p>
                  <span>5 Open Jobs</span>
                </div>
              </div>
              <div class="col-md-6 col-xl-4">
                <div class="following-card h-100">
                  <h4>Atlas Health</h4>
                  <p>Healthcare Technology · New York · Hybrid</p>
                  <span>2 Open Jobs</span>
                </div>
              </div>
              <div class="col-md-6 col-xl-4">
                <div class="following-card h-100">
                  <h4>Mova Robotics</h4>
                  <p>Robotics &amp; AI · Berlin · Flexible</p>
                  <span>4 Open Jobs</span>
                </div>
              </div>
              <div class="col-md-6 col-xl-4">
                <div class="following-card h-100">
                  <h4>NovaCloud</h4>
                  <p>Cloud Infrastructure · Austin · Remote friendly</p>
                  <span>6 Open Jobs</span>
                </div>
              </div>
              <div class="col-md-6 col-xl-4">
                <div class="following-card h-100">
                  <h4>Bright Labs</h4>
                  <p>Fintech Platform · Berlin · Remote EU</p>
                  <span>3 Open Jobs</span>
                </div>
              </div>
            </div>

            <div class="list-card mt-4">
              <h3>Smart Suggestions</h3>
              <ul>
                <li>
                  <div>
                    <strong>Companies hiring for Lead Product roles</strong>
                    <p class="mb-0 text-muted">
                      Based on your saved jobs and search history.
                    </p>
                  </div>
                  <a href="#." class="btn btn-outline-primary btn-sm rounded-3"
                    >Follow all</a
                  >
                </li>
                <li>
                  <div>
                    <strong>Studios expanding remote design teams</strong>
                    <p class="mb-0 text-muted">
                      14 companies align with your preferences.
                    </p>
                  </div>
                  <a
                    href="#."
                    class="btn btn-outline-secondary btn-sm rounded-3"
                    >Review</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>


@endsection