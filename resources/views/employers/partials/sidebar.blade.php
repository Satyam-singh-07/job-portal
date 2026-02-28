 <aside class="dashboard-sidebar employer-sidebar">
                    <div class="sidebar-header">
                       
                        <h2>{{ auth()->user()->company_name }}</h2>
                        <p>{{ auth()->user()->email }}</p>
                        <span class="company-pill">Premium Employer</span>
                    </div>
                    <ul class="dashboard-nav">
                        <li class="@if (request()->routeIs('employer.dashboard')) active @endif">
                            <a href="{{ route('employer.dashboard') }}"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                        </li>
                        <li  class="@if (request()->routeIs('employer.company-profile')) active @endif">
                            <a href="{{ route('employer.company-profile') }}"><i class="fa-solid fa-user-pen"></i> Edit Company Details</a>
                        </li>
                        <li>
                            <a href="{{ route('company.show', ['username' => auth()->user()->username]) }}"><i class="fa-solid fa-building"></i> Company Public
                                Profile</a>
                        </li>
                        <li class="@if (request()->routeIs('employer.post-job')) active @endif">
                            <a href="{{ route('employer.post-job') }}"><i class="fa-solid fa-plus"></i> Post a Job</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-briefcase"></i> Manage Jobs</a>
                        </li>
                        {{-- <li>
                            <a href="#"><i class="fa-solid fa-layer-group"></i> CV Search Packages</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-credit-card"></i> Payment History</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-envelope"></i> Company Messages</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-users"></i> Company Followers</a>
                        </li> --}}
                        <li>
                            <a href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                        </li>
                    </ul>
                </aside>