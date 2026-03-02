@extends('layouts.app')

@section('title', $job->title)

@section('content')

    <!-- Job Detail Hero -->
    <section class="job-detail-hero">
        <div class="container">
            <div class="job-detail-header">
                <div class="job-detail-company">
                    <div class="job-detail-logo">
                        <img src="{{ $job->user->logo_url }}" alt="{{ $job->user->company_name }}" style="
    width: 119px;
    height: 92px;
    border-radius: 10px;
"/>
                    </div>
                    <div>
                        <span class="job-detail-label">{{ $job->department ?? 'General' }}</span>
                        <h1 class="job-detail-title">
                            {{ $job->title }}
                        </h1>
                        <div class="job-detail-tags">
                            <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                {{ $job->location }}</span>
                            <span><i class="fa-solid fa-briefcase" aria-hidden="true"></i> 
                                {{ $job->employment_type }}</span>
                            @if($job->salary_range)
                                <span><i class="fa-solid fa-money-bill-wave" aria-hidden="true"></i>
                                    {{ $job->salary_range }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="job-detail-actions">
                    @if($job->external_apply_link)
                        <a href="{{ $job->external_apply_link }}" target="_blank" class="btn btn-primary">
                            <i class="fa-solid fa-external-link" aria-hidden="true"></i> Apply on Company Site
                        </a>
                    @else
                        @if(isset($hasApplied) && $hasApplied)
                            <button type="button" class="btn btn-success" disabled>
                                <i class="fa-solid fa-check-circle" aria-hidden="true"></i> Applied
                            </button>
                        @else
                            <button type="button" class="btn btn-primary" id="applyNowBtn">
                                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Apply Now
                            </button>
                        @endif
                    @endif
                    
                    <button
                        class="btn btn-outline-primary job-save {{ !empty($isFavorited) ? 'active' : '' }}"
                        id="saveJobBtn"
                        data-is-favorited="{{ !empty($isFavorited) ? '1' : '0' }}"
                        data-save-url="{{ route('candidate.jobs.favourite', $job->id) }}"
                        data-remove-url="{{ route('candidate.favourites.destroy', $job->id) }}"
                    >
                        @if(!empty($isFavorited))
                            <i class="fa-solid fa-bookmark" aria-hidden="true"></i> Saved
                        @else
                            <i class="fa-regular fa-bookmark" aria-hidden="true"></i> Save Job
                        @endif
                    </button>
                    <button class="btn btn-link job-share" id="shareJobBtn">
                        <i class="fa-solid fa-share-nodes" aria-hidden="true"></i> Share
                    </button>
                </div>
            </div>
            <div class="job-detail-meta">
                <div class="meta-item">
                    <i class="fa-solid fa-calendar" aria-hidden="true"></i>
                    <div>
                        <span class="label">Posted On</span>
                        <span class="value">{{ $job->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="meta-item">
                    <i class="fa-solid fa-user-tie" aria-hidden="true"></i>
                    <div>
                        <span class="label">Seniority</span>
                        <span class="value">{{ $job->seniority }}</span>
                    </div>
                </div>
                <div class="meta-item">
                    <i class="fa-solid fa-building" aria-hidden="true"></i>
                    <div>
                        <span class="label">Company</span>
                        <span class="value">{{ $job->user->company_name }}</span>
                    </div>
                </div>
                <div class="meta-item">
                    <i class="fa-solid fa-clock" aria-hidden="true"></i>
                    <div>
                        <span class="label">Experience</span>
                        <span class="value">{{ $job->experience }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="job-detail-body">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <article class="job-content-card">
                        <h2>Role Overview</h2>
                        <div class="job-description">
                            {!! nl2br(e($job->summary)) !!}
                        </div>
                    </article>

                    @if($job->responsibilities)
                    <article class="job-content-card">
                        <h3>What You'll Do</h3>
                        <div class="job-description">
                            {!! nl2br(e($job->responsibilities)) !!}
                        </div>
                    </article>
                    @endif

                    @if($job->skills)
                    <article class="job-content-card">
                        <h3>Skills &amp; Requirements</h3>
                        <div class="job-description">
                            {!! nl2br(e($job->skills)) !!}
                        </div>
                    </article>
                    @endif

                    <article class="job-content-card">
                        <h3>Benefits &amp; Perks</h3>
                        <div class="job-tag-cloud">
                            @if($job->visa_sponsorship)
                                <span>Visa sponsorship available</span>
                            @endif
                            @if($job->allow_quick_apply)
                                <span>Quick apply enabled</span>
                            @endif
                            <span>Annual bonus</span>
                            <span>Hybrid work flexibility</span>
                            <span>Private medical cover</span>
                            <span>Learning stipend</span>
                        </div>
                    </article>

                    <article class="job-content-card" id="applySection">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <h3>Interested in this position?</h3>
                                <p class="mb-0">
                                    Click the button to submit your application directly to {{ $job->user->company_name }}.
                                </p>
                            </div>
                            @if($job->external_apply_link)
                                <a href="{{ $job->external_apply_link }}" target="_blank" class="btn btn-primary">
                                    Apply Externally
                                </a>
                            @else
                                @if(isset($hasApplied) && $hasApplied)
                                    <button type="button" class="btn btn-success" disabled>
                                        Already Applied
                                    </button>
                                @else
                                    <button type="button" class="btn btn-primary" onclick="$('#applyNowBtn').click()">
                                        Submit Application
                                    </button>
                                @endif
                            @endif
                        </div>
                    </article>
                </div>

                <div class="col-lg-4">
                    <aside class="job-sidebar">
                        <div class="job-side-card">
                            <h3>Job Snapshot</h3>
                            <ul class="job-snapshot">
                                <li>
                                    <i class="fa-solid fa-hashtag" aria-hidden="true"></i><span>Job ID</span><strong>JP-{{ $job->id }}</strong>
                                </li>
                                <li>
                                    <i class="fa-solid fa-map-pin" aria-hidden="true"></i><span>Location</span><strong>{{ $job->location }}</strong>
                                </li>
                                @if($job->user->team_size)
                                <li>
                                    <i class="fa-solid fa-people-group" aria-hidden="true"></i><span>Team Size</span><strong>{{ $job->user->team_size }} collaborators</strong>
                                </li>
                                @endif
                                @if($job->salary_range)
                                <li>
                                    <i class="fa-solid fa-sack-dollar" aria-hidden="true"></i><span>Compensation</span><strong>{{ $job->salary_range }}</strong>
                                </li>
                                @endif
                                <li>
                                    <i class="fa-solid fa-briefcase" aria-hidden="true"></i><span>Employment</span><strong>{{ $job->employment_type }}</strong>
                                </li>
                                <li>
                                    <i class="fa-solid fa-graduation-cap" aria-hidden="true"></i><span>Experience</span><strong>{{ $job->experience }}</strong>
                                </li>
                            </ul>
                        </div>

                        <div class="job-side-card">
                            <h3>Talk to {{ $job->user->company_name }}</h3>
                            <form id="contactEmployerForm" class="job-contact-form">
                                @csrf
                                <input type="hidden" name="job_id" value="{{ $job->id }}">
                                <div class="mb-3">
                                    <label class="form-label" for="contactName">Full name</label>
                                    <input type="text" name="name" class="form-control" id="contactName" placeholder="Your name" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="contactEmail">Email address</label>
                                    <input type="email" name="email" class="form-control" id="contactEmail" placeholder="you@email.com" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="contactMessage">Message</label>
                                    <textarea name="message" class="form-control" id="contactMessage" rows="4" placeholder="Share a short note…" required></textarea>
                                </div>
                                <button type="submit" id="sendMessageBtn" class="btn btn-outline-primary w-100">
                                    Send Message
                                </button>
                            </form>
                        </div>

                        <div class="job-side-card map-card">
                            <h3>Office Location</h3>
                            <div class="ratio ratio-4x3">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126927.1294829377!2d{{ rand(0, 100) }}.12345!3d{{ rand(0, 100) }}.12345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z{{ $job->location }}!5e0!3m2!1sen!2s!4v1480401216309"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    @if($relatedJobs->count() > 0)
    <section class="job-related">
        <div class="container">
            <div class="titleTop text-center">
                <div class="subtitle">Explore More Roles</div>
                <h3>Related Opportunities</h3>
            </div>
            <div class="row g-4 job-grid">
                @foreach($relatedJobs as $rJob)
                <div class="col-md-6 col-xl-4">
                    <div class="job-board-card {{ $rJob->is_featured ? 'featured' : '' }}">
                        <div class="job-card-status">
                            <span class="job-type {{ strtolower(str_replace(' ', '', $rJob->employment_type)) }}">
                                {{ $rJob->employment_type }}
                            </span>
                        </div>
                        <h4><a href="{{ route('jobs.show', $rJob->slug) }}">{{ $rJob->title }}</a></h4>
                        @if($rJob->salary_range)
                        <div class="job-salary">
                            Salary: <strong>{{ $rJob->salary_range }}</strong>
                        </div>
                        @endif
                        <div class="job-location">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            {{ $rJob->location }}
                        </div>
                        <div class="job-card-footer">
                            <div class="job-card-company">
                                <img src="{{ $rJob->user->logo_url }}" alt="{{ $rJob->user->company_name }}" />
                                <div>
                                    <span class="label">Posted</span>
                                    <span class="value">{{ $rJob->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Apply Job Modal -->
    <div class="modal fade" id="applyJobModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apply for {{ $job->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="applyJobForm" action="{{ route('candidate.jobs.apply', $job->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Your profile resume will be shared with <strong>{{ $job->user->company_name }}</strong>.
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cover Letter (Optional)</label>
                            <textarea name="cover_letter" class="form-control" rows="6" placeholder="Briefly explain why you're a good fit for this role..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="submitApplicationBtn" class="btn btn-primary">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Share Job Modal -->
    <div class="modal fade" id="shareJobModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share this Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Copy the link below to share this opportunity:</p>
                    <div class="input-group">
                        <input type="text" class="form-control" id="shareLinkInput" value="{{ url()->current() }}" readonly>
                        <button class="btn btn-primary" onclick="copyShareLink()">
                            <i class="fa-solid fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Apply Now interaction
    $('#applyNowBtn').on('click', function() {
        @auth
            if ("{{ auth()->user()->isCandidate() }}") {
                $('#applyJobModal').modal('show');
            } else {
                showToast('Employers cannot apply for jobs.', 'error');
            }
        @else
            window.location.href = "{{ route('login') }}?redirect={{ url()->current() }}";
        @endauth
    });

    // Handle Job Application Form Submission
    $('#applyJobForm').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $btn = $('#submitApplicationBtn');
        const originalText = $btn.text();

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                $('#applyJobModal').modal('hide');
                showToast(response.message);
                $btn.prop('disabled', false).text(originalText);
                $form[0].reset();
                
                // Optionally update UI to show "Applied" status
                $('#applyNowBtn').prop('disabled', true).text('Applied').removeClass('btn-primary').addClass('btn-success');
            },
            error: function(xhr) {
                $btn.prop('disabled', false).text(originalText);
                if (xhr.status === 422) {
                    const message = xhr.responseJSON.message;
                    showToast(message, 'error');
                    if (xhr.responseJSON.redirect) {
                        setTimeout(() => {
                            window.location.href = xhr.responseJSON.redirect;
                        }, 2000);
                    }
                } else {
                    showToast(xhr.responseJSON?.message || 'Something went wrong. Please try again.', 'error');
                }
            }
        });
    });
    $('#saveJobBtn').on('click', function() {
        const $btn = $(this);

        @auth
            @if(auth()->user()->isCandidate())
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                const isFavorited = $btn.attr('data-is-favorited') === '1';
                const requestUrl = isFavorited ? $btn.data('remove-url') : $btn.data('save-url');
                const requestMethod = isFavorited ? 'DELETE' : 'POST';
                const originalHtml = $btn.html();

                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: requestUrl,
                    method: requestMethod,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        const nowFavorited = !isFavorited;
                        $btn.attr('data-is-favorited', nowFavorited ? '1' : '0');
                        $btn.toggleClass('active', nowFavorited);

                        if (nowFavorited) {
                            $btn.html('<i class="fa-solid fa-bookmark" aria-hidden="true"></i> Saved');
                        } else {
                            $btn.html('<i class="fa-regular fa-bookmark" aria-hidden="true"></i> Save Job');
                        }

                        showToast(response?.message || (nowFavorited ? 'Job saved to your favourites.' : 'Job removed from favourites.'));
                    },
                    error: function(xhr) {
                        $btn.html(originalHtml);

                        if (xhr.status === 401) {
                            window.location.href = "{{ route('login') }}?redirect={{ url()->current() }}";
                            return;
                        }

                        showToast(xhr.responseJSON?.message || 'Unable to update favourites right now.', 'error');
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                    }
                });
            @else
                showToast('Only candidates can save jobs.', 'error');
            @endif
        @else
            window.location.href = "{{ route('login') }}?redirect={{ url()->current() }}";
        @endauth
    });

    // Share Job interaction
    $('#shareJobBtn').on('click', function() {
        $('#shareJobModal').modal('show');
    });

    // Contact Employer AJAX
    $('#contactEmployerForm').on('submit', function(e) {
        e.preventDefault();
        const $btn = $('#sendMessageBtn');
        const originalText = $btn.text();
        
        $btn.prop('disabled', true).text('Sending...');

        // Placeholder for AJAX contact
        setTimeout(() => {
            showToast('Message sent successfully! The employer will contact you soon.');
            $btn.prop('disabled', false).text(originalText);
            $('#contactEmployerForm')[0].reset();
        }, 1500);
    });
});

function copyShareLink() {
    const copyText = document.getElementById("shareLinkInput");
    copyText.select();
    document.execCommand("copy");
    showToast('Link copied to clipboard!');
}

const showToast = (message, type = 'success') => {
    const $toast = $('#liveToast');
    $toast.removeClass('bg-success bg-danger bg-info').addClass(`bg-${type === 'success' ? 'success' : (type === 'error' ? 'danger' : 'info')}`);
    $toast.find('.toast-body').text(message);
    const toast = new bootstrap.Toast($toast[0]);
    toast.show();
};
</script>
@endsection
