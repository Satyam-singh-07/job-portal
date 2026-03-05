<div class="header">
    <div class="mobile-menu-overlay"></div>

    <nav class="navbar navbar-expand-lg navbar-light main-navbar">
        <div class="container">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="navbar-brand logo d-flex align-items-center">
                <img src="{{ asset('images/jobs-portal-logo.png') }}" alt="Logo">
            </a>

            <button class="navbar-toggler mobile-menu-toggle" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse mobile-menu" id="navMain">

                <button class="mobile-menu-close" type="button">
                    <i class="fa fa-times"></i>
                </button>

                <ul class="navbar-nav mx-auto align-items-lg-center main-menu">

                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            Home
                        </a>
                    </li>

                    <!-- Jobs -->
                    <li class="nav-item ">
                        <a class="nav-link  {{ request()->routeIs('jobs.*') ? 'active' : '' }}"
                            href="{{ route('jobs.index') }}" >
                            Jobs
                        </a>

                        
                    </li>

                    <!-- Employer -->
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('employers.*') || request()->routeIs('employer.*') ? 'active' : '' }}"
                            href="#" data-bs-toggle="dropdown">
                            Employer
                        </a>

                        <ul class="dropdown-menu dropdown-menu-lg">

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('employers.index') ? 'active' : '' }}"
                                    href="{{ route('employers.index') }}">
                                    Employer List
                                </a>
                            </li> --}}

                            {{-- <li>
                                <a class="dropdown-item {{ request()->routeIs('company.show') ? 'active' : '' }}"
                                    href="{{ route('company.show') }}">
                                    Company Detail
                                </a>
                            </li> --}}

                            {{-- <li>
                                <a class="dropdown-item {{ request()->routeIs('employer.dashboard') ? 'active' : '' }}"
                                    href="{{ route('employer.dashboard') }}">
                                    Employer Dashboard
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('employer.post-job') ? 'active' : '' }}"
                                    href="{{ route('employer.post-job') }}">
                                    Post Job
                                </a>
                            </li>

                        </ul>
                    </li> --}}

                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('candidate.*') ? 'active' : '' }}"
                            href="#" id="candidateDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Candidate
                        </a>

                        <ul class="dropdown-menu dropdown-menu-lg" aria-labelledby="candidateDropdown">

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.index') ? 'active' : '' }}"
                                    href="{{ route('candidate.index') }}">
                                    Candidate List
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.grid') ? 'active' : '' }}"
                                    href="#">
                                    Candidate Grid View
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.show') ? 'active' : '' }}"
                                    href="{{ route('candidate.show') }}">
                                    Candidate Single
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.dashboard') ? 'active' : '' }}"
                                    href="{{ route('candidate.dashboard') }}">
                                    Candidate Dashboard
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.edit-profile') ? 'active' : '' }}"
                                    href="{{ route('candidate.edit-profile') }}">
                                    Edit Profile
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.build-resume') ? 'active' : '' }}"
                                    href="{{ route('candidate.build-resume') }}">
                                    Build Resume
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.download-cv') ? 'active' : '' }}"
                                    href="{{ route('candidate.download-cv') }}">
                                    Download CV
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.public-profile') ? 'active' : '' }}"
                                    href="{{ route('candidate.public-profile') }}">
                                    View Public Profile
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.applications') ? 'active' : '' }}"
                                    href="{{ route('candidate.applications') }}">
                                    My Job Applications
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.favourites') ? 'active' : '' }}"
                                    href="{{ route('candidate.favourites') }}">
                                    My Favourite Jobs
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.alerts') ? 'active' : '' }}"
                                    href="{{ route('candidate.alerts') }}">
                                    Job Alerts
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.manage-resume') ? 'active' : '' }}"
                                    href="{{ route('candidate.manage-resume') }}">
                                    Manage Resume
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.messages') ? 'active' : '' }}"
                                    href="{{ route('candidate.messages') }}">
                                    My Messages
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.followings') ? 'active' : '' }}"
                                    href="{{ route('candidate.followings') }}">
                                    My Followings
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.packages') ? 'active' : '' }}"
                                    href="{{ route('candidate.packages') }}">
                                    Packages
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('candidate.payment-history') ? 'active' : '' }}"
                                    href="{{ route('candidate.payment-history') }}">
                                    Payment History
                                </a>
                            </li>

                        </ul>
                    </li> --}}

                    <!-- Contact -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Contact Us
                        </a>
                    </li>

                </ul>

                <!-- Right Side -->
                <div class="navbar-actions d-flex align-items-center gap-2">
                     
                   {{-- @if (
                    !auth()->user()->isCandidate()
                    ) --}}
                    <a href="{{ route('login') }}" class="btn btn-primary register-btn">
                            Free Job Post
                        </a>
{{-- @endif  --}}
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary signin-btn">
                            Sign in
                        </a>

                        <a href="{{ route('register') }}" class="btn btn-primary register-btn">
                            Register
                        </a>
                    @endguest

                    @auth
                        @php
                            $authUser = auth()->user();
                            $isCandidateUser = $authUser->isCandidate();
                            $unreadNotificationCount = $isCandidateUser ? $authUser->unreadNotifications()->count() : 0;
                            $latestNotifications = $isCandidateUser ? $authUser->notifications()->latest()->limit(5)->get() : collect();
                        @endphp

                        @if($isCandidateUser)
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary position-relative" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
                                    <i class="fa-regular fa-bell"></i>
                                    @if($unreadNotificationCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}
                                            <span class="visually-hidden">unread notifications</span>
                                        </span>
                                    @endif
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end notification-menu">
                                    <li class="px-3 py-2 d-flex justify-content-between align-items-center">
                                        <strong>Notifications</strong>
                                        @if($unreadNotificationCount > 0)
                                            <form method="POST" action="{{ route('candidate.notifications.read-all') }}">
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0 text-decoration-none small">
                                                    Mark all read
                                                </button>
                                            </form>
                                        @endif
                                    </li>

                                    <li><hr class="dropdown-divider"></li>

                                    @forelse($latestNotifications as $notification)
                                        @php
                                            $notificationData = $notification->data ?? [];
                                            $notificationMessage = $notificationData['message'] ?? 'You have a new notification.';
                                        @endphp
                                        <li>
                                            <a class="dropdown-item {{ is_null($notification->read_at) ? 'fw-semibold' : '' }}"
                                                href="{{ route('candidate.notifications.read', ['notification' => $notification->id]) }}">
                                                {{ \Illuminate\Support\Str::limit($notificationMessage, 70) }}
                                            </a>
                                        </li>
                                    @empty
                                        <li>
                                            <span class="dropdown-item-text text-muted small">
                                                No notifications yet.
                                            </span>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        @endif

                        <div class="dropdown user-dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <img src="{{ asset('images/candidates/01.jpg') }}" alt="Profile" width="35">
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ $isCandidateUser ? route('candidate.dashboard') : route('employer.dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>

                                <li>
                                    
                                        
                                        <a href="{{ route('logout') }}" class="dropdown-item">
                                            Logout
                                        </a>
                                </li>
                            </ul>
                        </div>
                    @endauth

                </div>

            </div>
        </div>
    </nav>
</div>
