<aside class="sidebar">
    <div class="logo-area">
        <div class="logo-icon"><i class="fas fa-bolt"></i></div>
        <div class="logo-text">Job<span>Flow</span></div>
    </div>

    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-pie"></i> <span>Dashboard</span></a>
        <a class="nav-item {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}" href="{{ route('admin.jobs.index') }}"><i class="fas fa-briefcase"></i> <span>Jobs</span></a>
        <a class="nav-item {{ request()->routeIs('admin.companies.*') ? 'active' : '' }}" href="{{ route('admin.companies.index') }}"><i class="fas fa-building"></i> <span>Companies</span></a>
        <a class="nav-item {{ request()->routeIs('admin.candidates.*') ? 'active' : '' }}" href="{{ route('admin.candidates.index') }}"><i class="fas fa-users"></i> <span>Candidates</span></a>
        <a class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}"><i class="fas fa-flag"></i> <span>Reports</span></a>
        <a class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}"><i class="fas fa-gear"></i> <span>Settings</span></a>
    </nav>

    <div class="sidebar-footer">
        <div class="company-switch">
            <i class="fas fa-building" style="font-size: 1.4rem;"></i>
            <div class="info">
                <div class="company-name">Admin Control</div>
                <div class="company-role">{{ number_format($stats['total_users'] ?? 0) }} users</div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" style="background:transparent;border:none;color:#5f7bbf;cursor:pointer;">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
