<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobFlow · Admin settings & limits</title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #eef2f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1.5rem;
            color: #121e42;
        }

        /* main admin panel card */
        .admin-panel {
            max-width: 1600px;
            width: 100%;
            background: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 30px 70px rgba(0, 10, 40, 0.18);
            display: grid;
            grid-template-columns: 280px 1fr;
            overflow: hidden;
        }

        /* --- SIDEBAR (consistent admin nav) --- */
        .sidebar {
            background: #0c1428;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-left: 0.5rem;
        }

        .logo-icon {
            background: #4f9cf7;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: white;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.02em;
            color: white;
        }
        .logo-text span {
            color: #6aa9ff;
        }

        .nav {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.85rem 1.2rem;
            border-radius: 16px;
            font-weight: 500;
            font-size: 1rem;
            color: #b2bfe0;
            transition: all 0.2s;
            cursor: default;
        }

        .nav-item i {
            width: 24px;
            font-size: 1.3rem;
            color: #6b81b4;
        }

        .nav-item.active {
            background: #1f2942;
            color: white;
        }
        .nav-item.active i {
            color: #6aa9ff;
        }
        .nav-item:not(.active):hover {
            background: #19213b;
            color: #d6e1ff;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid #1f2a44;
            padding-top: 1.8rem;
        }

        .admin-badge {
            background: #101b36;
            border-radius: 20px;
            padding: 1rem 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .admin-badge .info {
            flex: 1;
        }
        .admin-name {
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .admin-role {
            color: #778fcb;
            font-size: 0.8rem;
        }
        .admin-badge i {
            color: #5f7bbf;
        }

        /* --- MAIN CONTENT : SETTINGS & LIMITS --- */
        .main {
            background: #f9fcff;
            padding: 1.8rem 2.2rem 2.2rem 2.2rem;
            display: flex;
            flex-direction: column;
            gap: 1.8rem;
        }

        /* header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-title h1 {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #0b1730;
        }
        .page-title p {
            color: #4f6592;
            font-size: 0.95rem;
            margin-top: 6px;
            font-weight: 500;
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        .admin-profile {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #172c56, #0b1a3a);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
            border: 2px solid #eef3ff;
        }

        /* settings navigation tabs */
        .settings-tabs {
            display: flex;
            gap: 1rem;
            border-bottom: 1px solid #e2ebfc;
            padding-bottom: 0.5rem;
        }
        .tab {
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            color: #4f6eb0;
            border-radius: 30px;
            cursor: default;
        }
        .tab.active {
            background: #1d2d52;
            color: white;
        }

        /* settings grid */
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.8rem;
        }

        /* settings cards */
        .settings-card {
            background: white;
            border-radius: 28px;
            padding: 1.8rem;
            border: 1px solid #edf2fd;
            box-shadow: 0 8px 18px -6px rgba(0, 20, 50, 0.04);
        }
        .card-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }
        .card-icon {
            width: 48px;
            height: 48px;
            background: #e9f0ff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1d3f8f;
            font-size: 1.4rem;
        }
        .card-header h2 {
            font-weight: 700;
            color: #0b1c3f;
        }
        .card-header p {
            color: #5b73ac;
            font-size: 0.85rem;
            margin-top: 2px;
        }

        /* limit setting rows */
        .limit-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f5ff;
        }
        .limit-row:last-child {
            border-bottom: none;
        }
        .limit-info h3 {
            font-weight: 600;
            font-size: 1rem;
            color: #0b1c3f;
            margin-bottom: 0.2rem;
        }
        .limit-info span {
            font-size: 0.8rem;
            color: #5b73ac;
        }
        .limit-control {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .limit-input {
            width: 90px;
            padding: 0.5rem 0.8rem;
            border: 1px solid #dde5fa;
            border-radius: 20px;
            font-weight: 600;
            color: #0b1c3f;
            background: #f8fcff;
            text-align: center;
        }
        .toggle-switch {
            width: 48px;
            height: 24px;
            background: #cbd6f0;
            border-radius: 40px;
            position: relative;
            cursor: default;
        }
        .toggle-switch.active {
            background: #2e5fd7;
        }
        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: 0.2s;
        }
        .toggle-switch.active::after {
            left: 26px;
        }

        /* plan selector */
        .plan-selector {
            display: flex;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        .plan-option {
            flex: 1;
            border: 2px solid #e2ebfc;
            border-radius: 20px;
            padding: 1.2rem;
            text-align: center;
            cursor: default;
        }
        .plan-option.active {
            border-color: #2e5fd7;
            background: #f0f6ff;
        }
        .plan-name {
            font-weight: 700;
            color: #0b1c3f;
            margin-bottom: 0.3rem;
        }
        .plan-limit {
            font-size: 0.8rem;
            color: #4f6eb0;
        }

        .input-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .input-group input {
            flex: 1;
            padding: 0.8rem 1rem;
            border: 1px solid #dde5fa;
            border-radius: 20px;
            font-weight: 500;
            color: #0b1c3f;
            background: #f8fcff;
        }

        .save-section {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2ebfc;
        }
        .btn-primary {
            background: #1d2d52;
            border: none;
            border-radius: 40px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            cursor: default;
        }
        .btn-secondary {
            background: white;
            border: 1px solid #dde5fa;
            border-radius: 40px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            color: #1d315c;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            cursor: default;
        }

        .info-box {
            background: #f0f6ff;
            border-radius: 20px;
            padding: 1rem;
            margin: 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .info-box i {
            color: #2e5fd7;
            font-size: 1.2rem;
        }

        /* feature flags */
        .feature-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 0;
        }
    </style>
</head>
<body>
    <div class="admin-panel">

        <!-- SIDEBAR (admin) -->
        <aside class="sidebar">
            <div class="logo-area">
                <div class="logo-icon"><i class="fas fa-bolt"></i></div>
                <div class="logo-text">Job<span>Flow</span></div>
            </div>
            <nav class="nav">
                <div class="nav-item"><i class="fas fa-chart-pie"></i> <span>Dashboard</span></div>
                <div class="nav-item"><i class="fas fa-briefcase"></i> <span>Jobs</span></div>
                <div class="nav-item"><i class="fas fa-building"></i> <span>Companies</span></div>
                <div class="nav-item"><i class="fas fa-users"></i> <span>Candidates</span></div>
                <div class="nav-item"><i class="fas fa-flag"></i> <span>Reports</span></div>
                <div class="nav-item active"><i class="fas fa-cog"></i> <span>Settings</span></div>
            </nav>
            <div class="sidebar-footer">
                <div class="admin-badge">
                    <i class="fas fa-user-shield" style="font-size: 1.5rem;"></i>
                    <div class="info">
                        <div class="admin-name">Alex Rivera</div>
                        <div class="admin-role">Super Admin</div>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </aside>

        <!-- MAIN SETTINGS & LIMITS -->
        <main class="main">

            <!-- header -->
            <div class="header">
                <div class="page-title">
                    <h1>Settings</h1>
                    <p>Configure platform limits, quotas, and global rules</p>
                </div>
                <div class="header-right">
                    <div class="admin-profile">AR</div>
                </div>
            </div>

            <!-- settings tabs -->
            <div class="settings-tabs">
                <span class="tab active">General</span>
                <span class="tab">Limits & quotas</span>
                <span class="tab">Features</span>
                <span class="tab">Email</span>
                <span class="tab">Integrations</span>
                <span class="tab">Billing</span>
            </div>

            <!-- settings grid (two columns) -->
            <div class="settings-grid">

                <!-- LEFT COLUMN -->
                <div style="display: flex; flex-direction: column; gap: 1.8rem;">
                    <!-- Company job posting limits -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon"><i class="fas fa-building"></i></div>
                            <div>
                                <h2>Company job posting limits</h2>
                                <p>Set maximum job posts per company</p>
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Free plan</h3>
                                <span>Unverified companies, trial accounts</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="3" placeholder="Max jobs">
                                <span style="color:#5b73ac;">/ month</span>
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Basic plan</h3>
                                <span>Verified companies, standard</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="10" placeholder="Max jobs">
                                <span style="color:#5b73ac;">/ month</span>
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Premium plan</h3>
                                <span>Enterprise, featured listings</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="50" placeholder="Max jobs">
                                <span style="color:#5b73ac;">/ month</span>
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Custom plan</h3>
                                <span>Negotiated contracts</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="100" placeholder="Max jobs">
                                <span style="color:#5b73ac;">/ month</span>
                            </div>
                        </div>

                        <div class="info-box">
                            <i class="fas fa-info-circle"></i>
                            <span>Companies exceeding limits will be notified and prompted to upgrade.</span>
                        </div>
                    </div>

                    <!-- Candidate application limits -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon"><i class="fas fa-users"></i></div>
                            <div>
                                <h2>Candidate application limits</h2>
                                <p>Daily and monthly apply caps</p>
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Daily applications per candidate</h3>
                                <span>Maximum jobs a candidate can apply to in 24h</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="10">
                                <span style="color:#5b73ac;">jobs/day</span>
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Monthly applications per candidate</h3>
                                <span>Total applications allowed per month</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="50">
                                <span style="color:#5b73ac;">jobs/month</span>
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Applications to same company</h3>
                                <span>Max applications to one company per month</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="3">
                                <span style="color:#5b73ac;">per company</span>
                            </div>
                        </div>

                        <div class="feature-row">
                            <div>
                                <h3 style="font-weight:600;">Allow unlimited for verified</h3>
                                <span style="font-size:0.8rem; color:#5b73ac;">Premium candidates get higher limits</span>
                            </div>
                            <div class="toggle-switch active"></div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div style="display: flex; flex-direction: column; gap: 1.8rem;">
                    <!-- Global platform limits -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon"><i class="fas fa-globe"></i></div>
                            <div>
                                <h2>Global platform limits</h2>
                                <p>System-wide restrictions</p>
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Max active jobs per company (all plans)</h3>
                                <span>Hard limit, overrides plan settings</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="200">
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Job posting cooldown</h3>
                                <span>Minutes between posts from same company</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="5">
                                <span style="color:#5b73ac;">min</span>
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Max file size for resumes</h3>
                                <span>Per candidate upload</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="10">
                                <span style="color:#5b73ac;">MB</span>
                            </div>
                        </div>

                        <div class="limit-row">
                            <div class="limit-info">
                                <h3>Simultaneous logins</h3>
                                <span>Sessions per user</span>
                            </div>
                            <div class="limit-control">
                                <input class="limit-input" type="text" value="3">
                            </div>
                        </div>
                    </div>

                    <!-- Feature toggles & moderation -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon"><i class="fas fa-toggle-on"></i></div>
                            <div>
                                <h2>Feature controls</h2>
                                <p>Enable/disable platform features</p>
                            </div>
                        </div>

                        <div class="feature-row">
                            <div>
                                <h3 style="font-weight:600;">Job approval required</h3>
                                <span style="font-size:0.8rem; color:#5b73ac;">Admin must approve new jobs</span>
                            </div>
                            <div class="toggle-switch active"></div>
                        </div>

                        <div class="feature-row">
                            <div>
                                <h3 style="font-weight:600;">Company verification required</h3>
                                <span style="font-size:0.8rem; color:#5b73ac;">Before posting jobs</span>
                            </div>
                            <div class="toggle-switch active"></div>
                        </div>

                        <div class="feature-row">
                            <div>
                                <h3 style="font-weight:600;">Candidate email verification</h3>
                                <span style="font-size:0.8rem; color:#5b73ac;">Require email confirmation</span>
                            </div>
                            <div class="toggle-switch active"></div>
                        </div>

                        <div class="feature-row">
                            <div>
                                <h3 style="font-weight:600;">Allow multiple applications</h3>
                                <span style="font-size:0.8rem; color:#5b73ac;">To same job (duplicate check)</span>
                            </div>
                            <div class="toggle-switch"></div>
                        </div>

                        <div class="feature-row">
                            <div>
                                <h3 style="font-weight:600;">AI skill matching</h3>
                                <span style="font-size:0.8rem; color:#5b73ac;">Recommend candidates to companies</span>
                            </div>
                            <div class="toggle-switch active"></div>
                        </div>
                    </div>

                    <!-- Company tier defaults -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon"><i class="fas fa-tags"></i></div>
                            <div>
                                <h2>Default company tier</h2>
                                <p>For new registrations</p>
                            </div>
                        </div>

                        <div class="plan-selector">
                            <div class="plan-option active">
                                <div class="plan-name">Free</div>
                                <div class="plan-limit">3 jobs/month</div>
                            </div>
                            <div class="plan-option">
                                <div class="plan-name">Basic</div>
                                <div class="plan-limit">10 jobs/month</div>
                            </div>
                            <div class="plan-option">
                                <div class="plan-name">Premium</div>
                                <div class="plan-limit">50 jobs/month</div>
                            </div>
                        </div>

                        <div class="input-group">
                            <input type="text" placeholder="Custom trial period (days)" value="14">
                            <span style="color:#5b73ac;">days</span>
                        </div>

                        <div class="feature-row" style="margin-top:1rem;">
                            <div>
                                <h3 style="font-weight:600;">Auto-upgrade after trial</h3>
                                <span style="font-size:0.8rem; color:#5b73ac;">To Basic plan</span>
                            </div>
                            <div class="toggle-switch active"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save buttons -->
            <div class="save-section">
                <div class="btn-secondary"><i class="fas fa-undo-alt"></i> Reset to defaults</div>
                <div class="btn-primary"><i class="fas fa-save"></i> Save changes</div>
            </div>

            <!-- Audit log note -->
            <div style="font-size:0.85rem; color:#5570b3; display: flex; gap: 2rem; padding:0.5rem 0;">
                <i class="fas fa-history"></i> Last configuration change: 2 hours ago by Alex Rivera
            </div>

        </main>
    </div>
</body>
</html>