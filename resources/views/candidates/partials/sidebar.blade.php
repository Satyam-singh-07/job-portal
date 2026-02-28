<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="status-toggle">
            <div>
                <span class="status-label">Open to Work</span>
                <small class="status-note">Visible to recruiters</small>
            </div>
            <label class="status-switch" aria-label="Toggle open to work">
                <input type="checkbox" checked />
                <span class="status-slider"></span>
            </label>
        </div>
        <h2>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>
        <p>{{ auth()->user()->email }}</p>
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
