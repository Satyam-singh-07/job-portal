@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

    <section class="dashboard-section profile-settings">
        <div class="container">
            <div class="dashboard-layout">

                @include('candidates.partials.sidebar')

                <div class="dashboard-main">

                    <div class="settings-header">
                        <div class="avatar-upload">
                            <img id="candidatePhoto" src="{{ $user->logo_url }}" alt="{{ $user->first_name }}" />
                            <label class="upload-label">
                                <input type="file" id="photoInput" class="d-none" accept="image/*" />
                                <i class="fa-solid fa-arrow-up-from-bracket" aria-hidden="true"></i>
                                Update Photo
                            </label>
                            <div id="photoLoader" class="small text-muted mt-2 d-none">
                                Uploading...
                            </div>
                        </div>
                        <div class="settings-header-content">
                            <span>Candidate Profile</span>
                            <h2>{{ $user->first_name }} {{ $user->last_name }} 
                                @if($profile->title)
                                    <span class="fs-6 text-muted fw-normal">| {{ $profile->title }}</span>
                                @endif
                            </h2>
                            <p>
                                Keep your information fresh so hiring teams understand your
                                intent, availability and the type of roles you’re excited
                                about.
                            </p>
                            <div class="settings-header-meta">
                                @if ($profile->title)
                                    <span><i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                                        {{ $profile->title }}</span>
                                @endif
                                @if ($profile->location)
                                    <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                        {{ $profile->location }}</span>
                                @endif
                                <span><i class="fa-solid fa-clock" aria-hidden="true"></i>
                                    Updated {{ $profile->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <form class="settings-form" action="{{ route('candidate.edit-profile.update') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Profile
                                    </p>
                                    <h3>Personal Information</h3>
                                    <p>
                                        These details power your public profile and application
                                        cards.
                                    </p>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    @if ($profile->resume)
                                        <a href="{{ Storage::url($profile->resume) }}" target="_blank"
                                            class="btn btn-outline-secondary btn-sm rounded-3">
                                            <i class="fa-solid fa-file-pdf"></i> View Resume
                                        </a>
                                    @endif
                                    <label class="btn btn-outline-primary btn-sm rounded-3 mb-0" style="cursor: pointer;">
                                        <i class="fa-solid fa-file-arrow-up" aria-hidden="true"></i>
                                        Upload résumé
                                        <input type="file" name="resume" class="d-none">
                                    </label>
                                </div>
                            </div>
                            <div class="settings-grid">
                                <div>
                                    <label for="firstName" class="form-label">First name</label>
                                    <input type="text" name="first_name" class="form-control" id="firstName"
                                        placeholder="Jordan" value="{{ old('first_name', $user->first_name) }}" />
                                    @error('first_name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="lastName" class="form-label">Last name</label>
                                    <input type="text" name="last_name" class="form-control" id="lastName"
                                        placeholder="Blake" value="{{ old('last_name', $user->last_name) }}" />
                                    @error('last_name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="profileTitle" class="form-label">Professional title</label>
                                    <input type="text" name="title" class="form-control" id="profileTitle"
                                        placeholder="Lead Product Designer" value="{{ old('title', $profile->title) }}" />
                                </div>
                                <div>
                                    <label for="profileEmail" class="form-label">Email address</label>
                                    <input type="email" name="email" class="form-control" id="profileEmail"
                                        placeholder="you@company.com" value="{{ old('email', $user->email) }}" />
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="profilePhone" class="form-label">Phone</label>
                                    <input type="tel" name="phone" class="form-control" id="profilePhone"
                                        placeholder="+1 234 567 890" value="{{ old('phone', $profile->phone) }}" />
                                </div>
                                <div>
                                    <label for="profileLocation" class="form-label">Primary location</label>
                                    <input type="text" name="location" class="form-control" id="profileLocation"
                                        placeholder="Seattle, USA" value="{{ old('location', $profile->location) }}" />
                                </div>
                                <div>
                                    <label for="profilePreferredLocation" class="form-label">Preferred locations</label>
                                    <input type="text" name="preferred_locations" class="form-control"
                                        id="profilePreferredLocation" placeholder="Remote · San Francisco · Berlin"
                                        value="{{ old('preferred_locations', $profile->preferred_locations) }}" />
                                </div>
                                <div>
                                    <label for="profileWebsite" class="form-label">Website</label>
                                    <input type="url" name="website" class="form-control" id="profileWebsite"
                                        placeholder="https://www.personal-site.com/"
                                        value="{{ old('website', $user->website) }}" />
                                </div>
                                <div>
                                    <label for="profilePortfolio" class="form-label">Portfolio / Case study</label>
                                    <input type="url" name="portfolio_url" class="form-control"
                                        id="profilePortfolio" placeholder="https://dribbble.com/jordan"
                                        value="{{ old('portfolio_url', $profile->portfolio_url) }}" />
                                </div>
                                <div class="grid-span-2">
                                    <label for="profileSummary" class="form-label">About you</label>
                                    <textarea name="summary" class="form-control" id="profileSummary"
                                        placeholder="Summarize your superpowers, recent wins, and what you’re looking for next.">{{ old('summary', $user->summary) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Career
                                    </p>
                                    <h3>Professional Snapshot</h3>
                                    <p>Showcase your current standing and ideal role.</p>
                                </div>
                            </div>
                            <div class="settings-grid">
                                <div>
                                    <label for="experienceLevel" class="form-label">Experience level</label>
                                    <select name="experience_level" class="form-select" id="experienceLevel">
                                        <option value="">Select Level</option>
                                        <option value="10+ years" @selected(old('experience_level', $profile->experience_level) == '10+ years')>10+ years</option>
                                        <option value="8-10 years" @selected(old('experience_level', $profile->experience_level) == '8-10 years')>8-10 years</option>
                                        <option value="5-7 years" @selected(old('experience_level', $profile->experience_level) == '5-7 years')>5-7 years</option>
                                        <option value="2-4 years" @selected(old('experience_level', $profile->experience_level) == '2-4 years')>2-4 years</option>
                                        <option value="Entry level" @selected(old('experience_level', $profile->experience_level) == 'Entry level')>Entry level</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="currentCompany" class="form-label">Current company</label>
                                    <input type="text" name="current_company" class="form-control"
                                        id="currentCompany" placeholder="Skyline Digital"
                                        value="{{ old('current_company', $profile->current_company) }}" />
                                </div>
                                <div>
                                    <label for="noticePeriod" class="form-label">Notice period</label>
                                    <select name="notice_period" class="form-select" id="noticePeriod">
                                        <option value="">Select Notice Period</option>
                                        <option value="2 weeks" @selected(old('notice_period', $profile->notice_period) == '2 weeks')>2 weeks</option>
                                        <option value="1 week" @selected(old('notice_period', $profile->notice_period) == '1 week')>1 week</option>
                                        <option value="30 days" @selected(old('notice_period', $profile->notice_period) == '30 days')>30 days</option>
                                        <option value="45 days" @selected(old('notice_period', $profile->notice_period) == '45 days')>45 days</option>
                                        <option value="Immediately available" @selected(old('notice_period', $profile->notice_period) == 'Immediately available')>Immediately
                                            available</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="employmentType" class="form-label">Desired employment</label>
                                    <select name="desired_employment_type" class="form-select" id="employmentType">
                                        <option value="">Select Type</option>
                                        <option value="Full-time" @selected(old('desired_employment_type', $profile->desired_employment_type) == 'Full-time')>Full-time</option>
                                        <option value="Contract" @selected(old('desired_employment_type', $profile->desired_employment_type) == 'Contract')>Contract</option>
                                        <option value="Freelance" @selected(old('desired_employment_type', $profile->desired_employment_type) == 'Freelance')>Freelance</option>
                                        <option value="Internship" @selected(old('desired_employment_type', $profile->desired_employment_type) == 'Internship')>Internship</option>
                                        <option value="Part-time" @selected(old('desired_employment_type', $profile->desired_employment_type) == 'Part-time')>Part-time</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="salaryRange" class="form-label">Salary expectation</label>
                                    <input type="text" name="salary_expectation" class="form-control"
                                        id="salaryRange" placeholder="USD 120k – 150k / year"
                                        value="{{ old('salary_expectation', $profile->salary_expectation) }}" />
                                </div>
                                <div>
                                    <label for="workPreference" class="form-label">Work preference</label>
                                    <select name="work_preference" class="form-select" id="workPreference">
                                        <option value="">Select Preference</option>
                                        <option value="Remote friendly" @selected(old('work_preference', $profile->work_preference) == 'Remote friendly')>Remote friendly
                                        </option>
                                        <option value="On-site only" @selected(old('work_preference', $profile->work_preference) == 'On-site only')>On-site only</option>
                                        <option value="Hybrid" @selected(old('work_preference', $profile->work_preference) == 'Hybrid')>Hybrid</option>
                                    </select>
                                </div>
                                <div class="grid-span-2">
                                    <label for="dreamRoles" class="form-label">Target roles</label>
                                    <textarea name="target_roles" class="form-control" id="dreamRoles"
                                        placeholder="Principal Product Designer, Product Design Manager, Design Lead">{{ old('target_roles', $profile->target_roles) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Skills
                                    </p>
                                    <h3>Skills &amp; Tools</h3>
                                    <p>Highlight stacks, frameworks, and certifications (separate by comma or tap below).</p>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-2">Selected Skills</label>
                                <div id="selectedSkillsContainer" class="skill-tags mb-3">
                                    {{-- Selected skills will appear here as tags --}}
                                </div>
                                <input type="text" id="skillInputField" class="form-control mb-2"
                                    placeholder="Type a skill and press Enter or click suggestions below" />
                                <input type="hidden" name="skills_input" id="hiddenSkillsInput" 
                                    value="{{ old('skills_input', is_array($profile->skills) ? implode(', ', $profile->skills) : '') }}" />
                            </div>

                            <div>
                                <label class="form-label text-muted small mb-2">Suggested Skills</label>
                                <div class="skill-tags">
                                    @php
                                        $suggestedSkills = ['Product Strategy', 'Design Systems', 'Figma', 'React', 'UX Research', 'Python', 'Node.js', 'SQL', 'Project Management', 'AWS', 'Docker', 'Agile'];
                                    @endphp
                                    @foreach($suggestedSkills as $suggested)
                                        <span class="skill-tag suggested-skill" style="cursor: pointer; opacity: 0.8;" data-skill="{{ $suggested }}">
                                            <i class="fa-solid fa-plus small"></i> {{ $suggested }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div>
                                    <p class="text-uppercase text-muted small fw-semibold mb-1">
                                        Links
                                    </p>
                                    <h3>Social &amp; Contact Links</h3>
                                    <p>
                                        Share channels where hiring teams can follow your work.
                                    </p>
                                </div>
                            </div>
                            <div class="settings-grid">
                                <div>
                                    <label for="linkLinkedIn" class="form-label">LinkedIn</label>
                                    <input type="url" name="social_links[linkedin]" class="form-control"
                                        id="linkLinkedIn" placeholder="https://www.linkedin.com/in/username"
                                        value="{{ old('social_links.linkedin', $profile->social_links['linkedin'] ?? '') }}" />
                                </div>
                                <div>
                                    <label for="linkDribbble" class="form-label">Dribbble</label>
                                    <input type="url" name="social_links[dribbble]" class="form-control"
                                        id="linkDribbble" placeholder="https://dribbble.com/username"
                                        value="{{ old('social_links.dribbble', $profile->social_links['dribbble'] ?? '') }}" />
                                </div>
                                <div>
                                    <label for="linkGithub" class="form-label">GitHub / Code</label>
                                    <input type="url" name="social_links[github]" class="form-control"
                                        id="linkGithub" placeholder="https://github.com/username"
                                        value="{{ old('social_links.github', $profile->social_links['github'] ?? '') }}" />
                                </div>
                                <div>
                                    <label for="linkTwitter" class="form-label">Twitter / X</label>
                                    <input type="url" name="social_links[twitter]" class="form-control"
                                        id="linkTwitter" placeholder="https://twitter.com/username"
                                        value="{{ old('social_links.twitter', $profile->social_links['twitter'] ?? '') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('candidate.dashboard') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Photo Upload
            const input = document.getElementById('photoInput');
            const photo = document.getElementById('candidatePhoto');
            const loader = document.getElementById('photoLoader');

            if (input) {
                input.addEventListener('change', async function() {
                    if (!this.files.length) return;
                    const formData = new FormData();
                    formData.append('photo', this.files[0]);
                    loader.classList.remove('d-none');
                    try {
                        const response = await fetch("{{ route('candidate.edit-profile.photo') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        });
                        const data = await response.json();
                        loader.classList.add('d-none');
                        if (data.status) {
                            photo.src = data.photo_url + '?' + Date.now();
                        }
                    } catch (error) {
                        console.error('Error uploading photo:', error);
                        loader.classList.add('d-none');
                    }
                });
            }

            // Skills Management
            const selectedSkillsContainer = document.getElementById('selectedSkillsContainer');
            const skillInputField = document.getElementById('skillInputField');
            const hiddenSkillsInput = document.getElementById('hiddenSkillsInput');
            const suggestedSkills = document.querySelectorAll('.suggested-skill');

            let skills = hiddenSkillsInput.value ? hiddenSkillsInput.value.split(',').map(s => s.trim()).filter(s => s !== "") : [];

            function renderSkills() {
                selectedSkillsContainer.innerHTML = '';
                skills.forEach((skill, index) => {
                    const tag = document.createElement('span');
                    tag.className = 'skill-tag';
                    tag.innerHTML = `${skill} <i class="fa-solid fa-xmark ms-2 remove-skill" style="cursor: pointer;" data-index="${index}"></i>`;
                    selectedSkillsContainer.appendChild(tag);
                });
                hiddenSkillsInput.value = skills.join(', ');
            }

            function addSkill(skill) {
                skill = skill.trim();
                if (skill && !skills.includes(skill)) {
                    skills.push(skill);
                    renderSkills();
                }
                skillInputField.value = '';
            }

            selectedSkillsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-skill')) {
                    const index = e.target.getAttribute('data-index');
                    skills.splice(index, 1);
                    renderSkills();
                }
            });

            skillInputField.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addSkill(this.value);
                }
            });

            suggestedSkills.forEach(btn => {
                btn.addEventListener('click', function() {
                    addSkill(this.getAttribute('data-skill'));
                });
            });

            // Initial render
            renderSkills();
        });
    </script>
@endsection
