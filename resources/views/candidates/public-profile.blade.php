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
                            <button type="button" class="btn btn-outline-primary" id="copyProfileLink">
                                <i class="fa-solid fa-link" aria-hidden="true"></i> Copy link
                            </button>
                            <a href="#." class="btn btn-primary">
                                <i class="fa-solid fa-eye" aria-hidden="true"></i> View live profile
                            </a>
                        </div>
                    </div>

                    <div class="dashboard-cover-card mb-4">
                        {{-- <div class="dashboard-cover-media">
                            <img src="{{ asset('images/dashboard-cover.html') }}" alt="Profile cover" />
                        </div> --}}
                        <div class="dashboard-cover-profile">
                            <div class="cover-avatar">
                                <img src="{{ $user->logo_url }}" alt="{{ $user->first_name }}" />
                            </div>
                            <div>
                                <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                                <p>
                                    @if ($profile->title)
                                        {{ $profile->title }} ·
                                    @endif
                                    {{ $profile->work_preference ?? 'Remote friendly' }} ·
                                    {{ Str::limit($user->summary, 100) }}
                                </p>
                                <ul>
                                    <li>
                                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                        {{ $profile->location ?? 'Location not set' }}
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                                        {{ $profile->experience_level ?? 'Experience not set' }}
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-globe" aria-hidden="true"></i>
                                        {{ config('app.url') }}/candidate/{{ $user->username }}
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
                                    <input type="checkbox" class="visibility-toggle" data-field="is_searchable"
                                        {{ $profile->is_searchable ? 'checked' : '' }} />
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
                                    <input type="checkbox" class="visibility-toggle" data-field="is_public_link_active"
                                        {{ $profile->is_public_link_active ? 'checked' : '' }} />
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
                                    <input type="checkbox" class="visibility-toggle"
                                        data-field="is_indexed_by_search_engines"
                                        {{ $profile->is_indexed_by_search_engines ? 'checked' : '' }} />
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
                                        Visible · Last edited {{ $user->updated_at->diffForHumans() }}
                                    </p>
                                </div>
                                <a href="{{ route('candidate.edit-profile') }}"
                                    class="btn btn-outline-primary btn-sm rounded-3">Edit</a>
                            </li>
                            <li>
                                <div>
                                    <strong>Experience & Education</strong>
                                    <p class="mb-0 text-muted">
                                        Last edited {{ $profile->updated_at->diffForHumans() }}
                                    </p>
                                </div>
                                <a href="{{ route('candidate.edit-profile') }}"
                                    class="btn btn-outline-primary btn-sm rounded-3">Edit</a>
                            </li>
                            <li>
                                <div>
                                    <strong>Skills</strong>
                                    <p class="mb-0 text-muted">
                                        {{ is_array($profile->skills) ? count($profile->skills) : 0 }} skills listed
                                    </p>
                                </div>
                                <a href="{{ route('candidate.edit-profile') }}"
                                    class="btn btn-outline-primary btn-sm rounded-3">Manage</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        document.getElementById('copyProfileLink')?.addEventListener('click', function() {
            const url = "{{ config('app.url') }}/candidate/{{ $user->username }}";
            navigator.clipboard.writeText(url).then(() => {
                alert('Profile link copied to clipboard!');
            });
        });

        document.querySelectorAll('.visibility-toggle').forEach(toggle => {
            toggle.addEventListener('change', async function() {
                const field = this.getAttribute('data-field');
                const value = this.checked ? 1 : 0;

                try {
                    const response = await fetch("{{ route('candidate.edit-profile.visibility') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            field,
                            value
                        })
                    });

                    const data = await response.json();
                    if (!data.status) {
                        this.checked = !this.checked; // Revert if failed
                        alert('Failed to update visibility setting.');
                    }
                } catch (error) {
                    this.checked = !this.checked; // Revert if error
                    console.error('Error updating visibility:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        });
    </script>
@endsection
