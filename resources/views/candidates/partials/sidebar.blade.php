@php
    $candidateProfile = auth()->user()->candidateProfile;
    $openToWork = $candidateProfile ? (bool) $candidateProfile->is_searchable : true;
    $applicationBalance = (int) (auth()->user()->job_application_balance ?? 0);
@endphp

<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="status-toggle">
            <div>
                <span class="status-label">Open to Work</span>
                <small class="status-note" id="openToWorkNote">{{ $openToWork ? 'Visible to recruiters' : 'Hidden from recruiters' }}</small>
            </div>
            <label class="status-switch" aria-label="Toggle open to work">
                <input
                    type="checkbox"
                    id="openToWorkToggle"
                    {{ $openToWork ? 'checked' : '' }}
                    data-url="{{ route('candidate.open-to-work') }}"
                />
                <span class="status-slider"></span>
            </label>
        </div>
        <h2>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>
        <p>{{ auth()->user()->email }}</p>
        <p><strong>Apply credits:</strong> {{ number_format($applicationBalance) }}</p>
    </div>
    <ul class="dashboard-nav">
        <li class="{{ request()->routeIs('candidate.dashboard') ? 'active' : '' }}">
            <a href="{{ route('candidate.dashboard') }}"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        </li>
        <li class="{{ request()->routeIs('candidate.edit-profile') ? 'active' : '' }}">
            <a href="{{ route('candidate.edit-profile') }}"><i class="fa-solid fa-user-pen"></i> Edit Profile</a>
        </li>
        <li class="{{ request()->routeIs('candidate.build-resume') ? 'active' : '' }}">
            <a href="{{ route('candidate.build-resume') }}"><i class="fa-solid fa-id-badge"></i> Build Resume</a>
        </li>
        <li class="{{ request()->routeIs('candidate.download-cv') ? 'active' : '' }}">
            <a href="{{ route('candidate.download-cv') }}"><i class="fa-solid fa-download"></i> Download CV</a>
        </li>
        <li class="{{ request()->routeIs('candidate.public-profile') ? 'active' : '' }}">
            <a href="{{ route('candidate.public-profile') }}"><i class="fa-solid fa-eye"></i> View Public Profile</a>
        </li>
        <li class="{{ request()->routeIs('candidate.applications') ? 'active' : '' }}">
            <a href="{{ route('candidate.applications') }}"><i class="fa-solid fa-briefcase"></i> My Job Applications</a>
        </li>
        <li class="{{ request()->routeIs('candidate.favourites') ? 'active' : '' }}">
            <a href="{{ route('candidate.favourites') }}"><i class="fa-solid fa-heart"></i> My Favourite Jobs</a>
        </li>
        <li class="{{ request()->routeIs('candidate.alerts') ? 'active' : '' }}">
            <a href="{{ route('candidate.alerts') }}"><i class="fa-solid fa-bell"></i> Job Alerts</a>
        </li>
        <li class="{{ request()->routeIs('candidate.manage-resume') ? 'active' : '' }}">
            <a href="{{ route('candidate.manage-resume') }}"><i class="fa-solid fa-file-pen"></i> Manage Resume</a>
        </li>
        <li class="{{ request()->routeIs('candidate.messages') ? 'active' : '' }}">
            <a href="{{ route('candidate.messages') }}"><i class="fa-solid fa-envelope"></i> My Messages</a>
        </li>
        <li class="{{ request()->routeIs('candidate.followings') ? 'active' : '' }}">
            <a href="{{ route('candidate.followings') }}"><i class="fa-solid fa-people-group"></i> My Followings</a>
        </li>
        <li class="{{ request()->routeIs('candidate.packages') ? 'active' : '' }}">
            <a href="{{ route('candidate.packages') }}"><i class="fa-solid fa-boxes-stacked"></i> Packages</a>
        </li>
        <li class="{{ request()->routeIs('candidate.payment-history') ? 'active' : '' }}">
            <a href="{{ route('candidate.payment-history') }}"><i class="fa-solid fa-credit-card"></i> Payment History</a>
        </li>
        <li>
            <a href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </li>
    </ul>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('openToWorkToggle');
    if (!toggle) return;

    const note = document.getElementById('openToWorkNote');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    toggle.addEventListener('change', async function () {
        const checked = toggle.checked;
        toggle.disabled = true;

        try {
            const response = await fetch(toggle.dataset.url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ open_to_work: checked ? 1 : 0 }),
            });

            const payload = await response.json();
            if (!response.ok || !payload?.status) {
                throw new Error(payload?.message || 'Unable to update Open to Work setting.');
            }

            const isOpenToWork = !!payload.open_to_work;
            toggle.checked = isOpenToWork;
            if (note) {
                note.textContent = isOpenToWork ? 'Visible to recruiters' : 'Hidden from recruiters';
            }

            if (typeof showToast === 'function') {
                showToast(payload.message || 'Open to Work updated.');
            }
        } catch (error) {
            toggle.checked = !checked;
            if (typeof showToast === 'function') {
                showToast(error.message || 'Unable to update Open to Work setting.', 'error');
            }
        } finally {
            toggle.disabled = false;
        }
    });
});
</script>
