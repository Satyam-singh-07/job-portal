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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('jobs.*') ? 'active' : '' }}"
                            href="#" data-bs-toggle="dropdown">
                            Jobs
                        </a>

                        <ul class="dropdown-menu dropdown-menu-lg">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('jobs.index') ? 'active' : '' }}"
                                    href="{{ route('jobs.index') }}">
                                    Jobs List
                                </a>
                            </li>

                            {{-- <li>
                                <a class="dropdown-item {{ request()->routeIs('jobs.show') ? 'active' : '' }}"
                                    href="{{ route('jobs.show') }}">
                                    Job Detail
                                </a>
                            </li> --}}
                        </ul>
                    </li>

                    <!-- Employer -->
                    <li class="nav-item dropdown">
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
                            </li>

                            {{-- <li>
                                <a class="dropdown-item {{ request()->routeIs('company.show') ? 'active' : '' }}"
                                    href="{{ route('company.show') }}">
                                    Company Detail
                                </a>
                            </li> --}}

                            <li>
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
                    </li>

                    <li class="nav-item dropdown">
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
                    </li>

                    <!-- Contact -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Contact Us
                        </a>
                    </li>

                </ul>

                <!-- Right Side -->
                <div class="navbar-actions d-flex align-items-center gap-2">

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary signin-btn">
                            Sign in
                        </a>

                        <a href="{{ route('register') }}" class="btn btn-primary register-btn">
                            Register
                        </a>
                    @endguest

                    @auth
                        <div class="dropdown user-dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <img src="{{ asset('images/candidates/01.jpg') }}" alt="Profile" width="35">
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ auth()->user()->role === 'candidate' ? route('candidate.dashboard') : route('employer.dashboard') }}">
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
