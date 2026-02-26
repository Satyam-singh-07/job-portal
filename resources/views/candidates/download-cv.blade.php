 
 
 
 @extends('layouts.app')

@section('title', 'Download &amp; Share Your CV')

@section('content')
 
 <section class="dashboard-section">
      <div class="container">
        <div class="dashboard-layout">
           
            @include('candidates.partials.sidebar')


          <div class="dashboard-main">
            <div class="dashboard-page-header">
              <div>
                <h1>Download &amp; Share Your CV</h1>
                <p>
                  Export pixel-perfect resumes, switch templates instantly, and
                  send secure share links.
                </p>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <a href="#." class="btn btn-outline-primary"
                  ><i class="fa-solid fa-file-export" aria-hidden="true"></i>
                  Download PDF</a
                >
                <a href="#." class="btn btn-primary"
                  ><i
                    class="fa-solid fa-file-arrow-down"
                    aria-hidden="true"
                  ></i>
                  Download DOCX</a
                >
              </div>
            </div>

            <div class="dashboard-actions-grid">
              <div class="action-card">
                <span class="icon-square"
                  ><i class="fa-solid fa-shield-check" aria-hidden="true"></i
                ></span>
                <h4>ATS Optimized</h4>
                <p>
                  Clean typography, zero background graphics, fully
                  machine-readable.
                </p>
                <button class="btn btn-outline-primary btn-sm">
                  Generate ATS PDF
                </button>
              </div>
              <div class="action-card">
                <span class="icon-square"
                  ><i class="fa-solid fa-star" aria-hidden="true"></i
                ></span>
                <h4>Modern Visual</h4>
                <p>
                  Use accent colors, iconography, and layout flourishes for
                  human review.
                </p>
                <button class="btn btn-outline-primary btn-sm">
                  Export modern PDF
                </button>
              </div>
              <div class="action-card">
                <span class="icon-square"
                  ><i class="fa-solid fa-link" aria-hidden="true"></i
                ></span>
                <h4>Shareable Link</h4>
                <p>Create a private URL with analytics and access controls.</p>
                <button class="btn btn-outline-primary btn-sm">
                  Create link
                </button>
              </div>
            </div>

            <div class="list-card mt-4">
              <h3>Resume Versions</h3>
              <ul>
                <li>
                  <div>
                    <strong>General Product Resume</strong>
                    <p class="mb-0 text-muted">
                      Updated Apr 10 · Default · 4 downloads
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary btn-sm rounded-3">
                      PDF
                    </button>
                    <button class="btn btn-outline-secondary btn-sm rounded-3">
                      DOCX
                    </button>
                  </div>
                </li>
                <li>
                  <div>
                    <strong>Fintech Lead Designer</strong>
                    <p class="mb-0 text-muted">
                      Updated Mar 22 · Template: Minimal
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary btn-sm rounded-3">
                      PDF
                    </button>
                    <button class="btn btn-outline-secondary btn-sm rounded-3">
                      DOCX
                    </button>
                  </div>
                </li>
                <li>
                  <div>
                    <strong>Research-heavy Case Study</strong>
                    <p class="mb-0 text-muted">
                      Updated Feb 14 · Template: Insight
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary btn-sm rounded-3">
                      PDF
                    </button>
                    <button class="btn btn-outline-secondary btn-sm rounded-3">
                      DOCX
                    </button>
                  </div>
                </li>
              </ul>
            </div>

            <div class="list-card mt-4">
              <h3>Share Links &amp; Access</h3>
              <ul>
                <li>
                  <div>
                    <strong>General resume link</strong>
                    <p class="mb-0 text-muted">
                      jobsportal.com/cv/jordan · 86 views · expires in 30 days
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary btn-sm rounded-3">
                      Copy
                    </button>
                    <button class="btn btn-outline-danger btn-sm rounded-3">
                      Disable
                    </button>
                  </div>
                </li>
                <li>
                  <div>
                    <strong>Recruiter collaboration link</strong>
                    <p class="mb-0 text-muted">
                      Requires email · analytics enabled
                    </p>
                  </div>
                  <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary btn-sm rounded-3">
                      Copy
                    </button>
                    <button class="btn btn-outline-secondary btn-sm rounded-3">
                      Settings
                    </button>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    @endsection