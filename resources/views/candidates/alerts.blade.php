
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
                <h1>Job Alerts</h1>
                <p>
                  Create targeted notifications by role, location, and
                  compensation so you never miss a fit.
                </p>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <a href="#." class="btn btn-outline-primary"
                  ><i class="fa-solid fa-bell" aria-hidden="true"></i> Pause
                  all</a
                >
                <a href="#newAlert" class="btn btn-primary"
                  ><i class="fa-solid fa-plus" aria-hidden="true"></i> New
                  alert</a
                >
              </div>
            </div>

            <div class="list-card">
              <h3>Active Alerts</h3>
              <ul>
                <li>
                  <div>
                    <strong>Design leadership · Remote US</strong>
                    <p class="mb-0 text-muted">
                      Keywords: “Head of Design, Design Manager” · Salary 150k+
                    </p>
                  </div>
                  <label class="toggle-switch">
                    <input type="checkbox" checked />
                    <span class="toggle-slider"></span>
                  </label>
                </li>
                <li>
                  <div>
                    <strong>Fintech product designer · Europe</strong>
                    <p class="mb-0 text-muted">
                      Berlin, Amsterdam, Remote EU · Weekly digest
                    </p>
                  </div>
                  <label class="toggle-switch">
                    <input type="checkbox" checked />
                    <span class="toggle-slider"></span>
                  </label>
                </li>
                <li>
                  <div>
                    <strong>Short contracts · UX research</strong>
                    <p class="mb-0 text-muted">
                      Contract length &lt; 6 months · Rate 600+/day
                    </p>
                  </div>
                  <label class="toggle-switch">
                    <input type="checkbox" />
                    <span class="toggle-slider"></span>
                  </label>
                </li>
              </ul>
            </div>

            <div id="newAlert" class="settings-card mt-4">
              <div class="settings-card-header">
                <div>
                  <p class="text-uppercase text-muted small fw-semibold mb-1">
                    Create Alert
                  </p>
                  <h3>Alert Builder</h3>
                  <p>
                    Combine filters to match the exact opportunities you want in
                    your inbox.
                  </p>
                </div>
              </div>
              <div class="settings-grid">
                <div>
                  <label class="form-label" for="alertRole"
                    >Role keywords</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="alertRole"
                    placeholder="Product Designer, UX Lead"
                  />
                </div>
                <div>
                  <label class="form-label" for="alertLocation"
                    >Locations</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="alertLocation"
                    placeholder="Remote · Seattle · Berlin"
                  />
                </div>
                <div>
                  <label class="form-label" for="alertType">Job type</label>
                  <select class="form-select" id="alertType">
                    <option selected>Full-time</option>
                    <option>Contract</option>
                    <option>Freelance</option>
                    <option>Internship</option>
                  </select>
                </div>
                <div>
                  <label class="form-label" for="alertFrequency"
                    >Frequency</label
                  >
                  <select class="form-select" id="alertFrequency">
                    <option selected>Daily</option>
                    <option>Weekly</option>
                    <option>Instant</option>
                  </select>
                </div>
                <div>
                  <label class="form-label" for="alertSalary"
                    >Minimum salary</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="alertSalary"
                    placeholder="USD 140,000"
                  />
                </div>
                <div>
                  <label class="form-label" for="alertChannel">Delivery</label>
                  <select class="form-select" id="alertChannel">
                    <option selected>Email</option>
                    <option>In-app</option>
                    <option>SMS</option>
                  </select>
                </div>
                <div class="grid-span-2">
                  <label class="form-label" for="alertNotes">Notes</label>
                  <textarea
                    class="form-control"
                    id="alertNotes"
                    placeholder="Add reminder about contract preferences, companies to exclude, etc."
                  ></textarea>
                </div>
              </div>
              <div class="form-actions mt-3">
                <button type="button" class="btn btn-outline-secondary">
                  Reset
                </button>
                <button type="button" class="btn btn-primary">
                  Save alert
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>

@endsection