@extends('layouts.app')

@section('title', 'Edit Job')

@section('content')

    <div class="employer-hero">
        <div class="container">
            <div class="employer-hero-content">
                <div>
                    <span class="company-pill">{{ auth()->user()->company_name }}</span>
                    <h1>Edit job posting</h1>
                    <p>
                        Update role details, requirements, and perks for <strong>{{ $job->title }}</strong>.
                    </p>
                </div>
                <a href="{{ route('employer.manage-jobs') }}" class="btn btn-outline-primary">Back to Manage Jobs</a>
            </div>
        </div>
    </div>
    <section class="dashboard-section employer-dashboard post-job-dashboard">
        <div class="container mt-4">
            <div class="dashboard-layout">
                
                @include('employers.partials.sidebar')

                <div class="dashboard-main">
                    <section class="post-job-panel">
                        <div class="panel-heading">
                            <h3>Job details</h3>
                            <span class="panel-note">Fields marked * are required</span>
                        </div>
                        <form id="editJobForm" action="{{ route('employer.jobs.update', $job->id) }}" method="POST" class="post-job-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" id="formAction" value="publish">
                            
                            <div class="form-section">
                                <h4>Role basics</h4>
                                <div class="form-grid two-col">
                                    <label class="form-field">
                                        <span>Job title *</span>
                                        <input type="text" name="title" value="{{ old('title', $job->title) }}" placeholder="e.g. Senior Product Designer" required />
                                        @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                    <label class="form-field">
                                        <span>Department</span>
                                        <input type="text" name="department" value="{{ old('department', $job->department) }}" placeholder="Design Systems" />
                                        @error('department') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                    <label class="form-field">
                                        <span>Location *</span>
                                        <input type="text" name="location" value="{{ old('location', $job->location) }}" placeholder="Hybrid · Seattle, USA" required />
                                        @error('location') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                    <label class="form-field">
                                        <span>Employment type *</span>
                                        <select name="employment_type" required>
                                            <option value="">Select type</option>
                                            <option value="Full Time" {{ old('employment_type', $job->employment_type) == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                            <option value="Part Time" {{ old('employment_type', $job->employment_type) == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                            <option value="Contract" {{ old('employment_type', $job->employment_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                                            <option value="Freelance" {{ old('employment_type', $job->employment_type) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                        </select>
                                        @error('employment_type') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                    <label class="form-field">
                                        <span>Salary range</span>
                                        <input type="text" name="salary_range" value="{{ old('salary_range', $job->salary_range) }}" placeholder="$90k - $120k / year" />
                                        @error('salary_range') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                    <label class="form-field">
                                        <span>Seniority *</span>
                                        <select name="seniority" required>
                                            <option value="">Select seniority</option>
                                            <option value="Lead / Principal" {{ old('seniority', $job->seniority) == 'Lead / Principal' ? 'selected' : '' }}>Lead / Principal</option>
                                            <option value="Senior" {{ old('seniority', $job->seniority) == 'Senior' ? 'selected' : '' }}>Senior</option>
                                            <option value="Mid Level" {{ old('seniority', $job->seniority) == 'Mid Level' ? 'selected' : '' }}>Mid Level</option>
                                            <option value="Entry Level" {{ old('seniority', $job->seniority) == 'Entry Level' ? 'selected' : '' }}>Entry Level</option>
                                        </select>
                                        @error('seniority') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4>Candidate preferences</h4>
                                <div class="form-grid three-col">
                                    <label class="form-field">
                                        <span>Experience *</span>
                                        <select name="experience" required>
                                            <option value="">Select experience</option>
                                            <option value="5+ years" {{ old('experience', $job->experience) == '5+ years' ? 'selected' : '' }}>5+ years</option>
                                            <option value="3+ years" {{ old('experience', $job->experience) == '3+ years' ? 'selected' : '' }}>3+ years</option>
                                            <option value="1-2 years" {{ old('experience', $job->experience) == '1-2 years' ? 'selected' : '' }}>1-2 years</option>
                                            <option value="Graduate" {{ old('experience', $job->experience) == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                                        </select>
                                        @error('experience') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                    <label class="form-field">
                                        <span>Open roles *</span>
                                        <input type="number" name="open_roles" value="{{ old('open_roles', $job->open_roles) }}" placeholder="1" min="1" required />
                                        @error('open_roles') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                    <label class="form-field">
                                        <span>Visa sponsorship</span>
                                        <select name="visa_sponsorship">
                                            <option value="0" {{ old('visa_sponsorship', $job->visa_sponsorship) == '0' ? 'selected' : '' }}>Not available</option>
                                            <option value="1" {{ old('visa_sponsorship', $job->visa_sponsorship) == '1' ? 'selected' : '' }}>Available</option>
                                        </select>
                                        @error('visa_sponsorship') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4>Role description</h4>
                                <label class="form-field">
                                    <span>Summary *</span>
                                    <textarea name="summary" rows="4" placeholder="Describe the mission for this role..." required>{{ old('summary', $job->summary) }}</textarea>
                                    @error('summary') <span class="text-danger small">{{ $message }}</span> @enderror
                                </label>
                                <div class="form-grid two-col">
                                    <label class="form-field">
                                        <span>Responsibilities</span>
                                        <textarea name="responsibilities" rows="4" placeholder="Use bullet points or short sentences">{{ old('responsibilities', $job->responsibilities) }}</textarea>
                                        @error('responsibilities') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                    <label class="form-field">
                                        <span>Must-have skills</span>
                                        <textarea name="skills" rows="4" placeholder="List skills separated by commas">{{ old('skills', $job->skills) }}</textarea>
                                        @error('skills') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4>Publishing</h4>
                                <div class="form-grid two-col">
                                    <label class="form-field">
                                        <span>Application email</span>
                                        <input type="email" name="application_email" value="{{ old('application_email', $job->application_email) }}" placeholder="talent@northwind.com" />
                                        @error('application_email') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                    <label class="form-field">
                                        <span>External apply link</span>
                                        <input type="url" name="external_apply_link" value="{{ old('external_apply_link', $job->external_apply_link) }}" placeholder="https://northwind.com/careers/designer" />
                                        @error('external_apply_link') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </label>
                                </div>
                                <label class="form-field checkbox">
                                    <input type="checkbox" name="allow_quick_apply" value="1" {{ old('allow_quick_apply', $job->allow_quick_apply) ? 'checked' : '' }} />
                                    <span>Allow quick apply inside Jobs Portal</span>
                                </label>
                            </div>

                            <div class="form-actions">
                                <button type="submit" id="updateBtn" class="btn btn-primary">
                                    Update Job
                                </button>
                                <a href="{{ route('employer.manage-jobs') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const $form = $('#editJobForm');
    const $updateBtn = $('#updateBtn');

    const showToast = (message, type = 'success') => {
        const $toast = $('#liveToast');
        $toast.removeClass('bg-success bg-danger').addClass(`bg-${type === 'success' ? 'success' : 'danger'}`);
        $toast.find('.toast-body').text(message);
        const toast = new bootstrap.Toast($toast[0]);
        toast.show();
    };

    const toggleLoading = (isLoading) => {
        if (isLoading) {
            $updateBtn.prop('disabled', true);
            $updateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
        } else {
            $updateBtn.prop('disabled', false);
            $updateBtn.html('Update Job');
        }
    };

    $form.on('submit', function(e) {
        e.preventDefault();
        
        toggleLoading(true);

        // Clear previous errors
        $('.text-danger.small').remove();
        $('.form-field input, .form-field select, .form-field textarea').removeClass('is-invalid');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                if (response.success) {
                    showToast(response.message);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1500);
                }
            },
            error: function(xhr) {
                toggleLoading(false);
                
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(key => {
                        const $field = $(`[name="${key}"]`);
                        $field.addClass('is-invalid');
                        $field.after(`<span class="text-danger small">${errors[key][0]}</span>`);
                    });
                    showToast('Please fix the errors below.', 'error');
                } else {
                    showToast(xhr.responseJSON?.message || 'Something went wrong. Please try again.', 'error');
                }
            }
        });
    });
});
</script>
@endsection
