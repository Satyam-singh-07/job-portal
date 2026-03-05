<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobFlow · Admin reports & analytics</title>
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

        /* --- MAIN CONTENT : REPORTS & ANALYTICS --- */
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
        .date-range {
            background: white;
            border-radius: 40px;
            padding: 0.5rem 1rem 0.5rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            border: 1px solid #e5ecfc;
            font-weight: 500;
            color: #1d3a7a;
        }
        .date-range i {
            color: #7f96cc;
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

        /* KPI cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
        .kpi-card {
            background: white;
            border-radius: 28px;
            padding: 1.4rem 1.5rem;
            border: 1px solid #edf2fd;
            box-shadow: 0 8px 18px -6px rgba(0, 20, 50, 0.04);
        }
        .kpi-title {
            color: #445e93;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .kpi-number {
            font-size: 2.4rem;
            font-weight: 700;
            color: #0c1a3b;
            line-height: 1.2;
        }
        .kpi-trend {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #1f8b4c;
            background: #e1f3e8;
            padding: 0.3rem 0.9rem;
            border-radius: 30px;
            width: fit-content;
            margin-top: 0.5rem;
        }
        .kpi-trend.down {
            color: #b13e3e;
            background: #ffe3e3;
        }

        /* charts row */
        .charts-row {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 1.5rem;
        }
        .chart-card {
            background: white;
            border-radius: 28px;
            padding: 1.5rem;
            border: 1px solid #edf2fd;
            box-shadow: 0 8px 18px -6px rgba(0, 20, 50, 0.04);
        }
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.2rem;
        }
        .chart-header h3 {
            font-weight: 700;
            color: #0b1c3f;
        }
        .chart-header select {
            background: #f1f6ff;
            border: 1px solid #dce5fc;
            border-radius: 30px;
            padding: 0.4rem 1rem;
            font-weight: 500;
            color: #1d3a7a;
            outline: none;
        }

        /* visit bars (mock) */
        .visit-bars {
            display: flex;
            align-items: flex-end;
            gap: 1rem;
            height: 180px;
            margin: 1.5rem 0 1rem 0;
        }
        .bar-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        .bar-container {
            width: 100%;
            background: #eaf0fe;
            border-radius: 12px 12px 6px 6px;
            height: 140px;
            position: relative;
        }
        .bar-fill {
            background: #2e5fd7;
            width: 100%;
            position: absolute;
            bottom: 0;
            border-radius: 12px 12px 6px 6px;
            transition: 0.2s;
        }
        .bar-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: #4f6290;
        }

        /* traffic sources */
        .source-list {
            margin-top: 1rem;
        }
        .source-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #f0f5ff;
        }
        .source-item:last-child {
            border-bottom: none;
        }
        .source-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .source-icon {
            width: 36px;
            height: 36px;
            background: #e9f0ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1d3f8f;
        }
        .source-details h4 {
            font-weight: 700;
            font-size: 0.95rem;
            color: #0b1c3f;
        }
        .source-details span {
            font-size: 0.75rem;
            color: #5b73ac;
        }
        .source-value {
            font-weight: 700;
            color: #1b2f60;
        }
        .source-percent {
            background: #f1f6ff;
            padding: 0.2rem 0.8rem;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* analytics grid (bottom) */
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }
        .analytics-card {
            background: white;
            border-radius: 28px;
            padding: 1.5rem;
            border: 1px solid #edf2fd;
        }
        .analytics-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .analytics-header h3 {
            font-weight: 700;
            color: #0b1c3f;
        }
        .analytics-header i {
            color: #7f96cc;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 1px solid #f0f5ff;
        }
        .stat-row:last-child {
            border-bottom: none;
        }
        .stat-label {
            color: #4f6eb0;
        }
        .stat-value {
            font-weight: 700;
            color: #0b1c3f;
        }

        .pages-list {
            margin-top: 0.5rem;
        }
        .page-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.6rem 0;
            border-bottom: 1px solid #f0f5ff;
        }
        .page-url {
            font-size: 0.9rem;
            color: #1d3f8f;
        }
        .page-stats {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .page-visits {
            font-weight: 700;
            color: #0b1c3f;
        }
        .page-trend {
            color: #1f8b4c;
            font-size: 0.8rem;
        }

        .device-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.6rem 0;
        }
        .device-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .device-bar {
            width: 100px;
            height: 6px;
            background: #eaf0fe;
            border-radius: 10px;
        }
        .device-bar-fill {
            height: 6px;
            background: #2e5fd7;
            border-radius: 10px;
        }

        .export-btn {
            background: white;
            border: 1px solid #dde5fa;
            border-radius: 40px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            color: #1d315c;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: fit-content;
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
                <div class="nav-item active"><i class="fas fa-flag"></i> <span>Reports</span></div>
                <div class="nav-item"><i class="fas fa-cog"></i> <span>Settings</span></div>
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

        <!-- MAIN REPORTS & ANALYTICS -->
        <main class="main">

            <!-- header with date range -->
            <div class="header">
                <div class="page-title">
                    <h1>Reports & Analytics</h1>
                    <p>Platform performance, traffic, and engagement metrics</p>
                </div>
                <div class="header-right">
                    <div class="date-range">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Oct 1 - Oct 31, 2024</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="admin-profile">AR</div>
                </div>
            </div>

            <!-- KPI cards -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-title"><i class="fas fa-eye"></i> Page views</div>
                    <div class="kpi-number">284.3K</div>
                    <div class="kpi-trend"><i class="fas fa-arrow-up"></i> +12.3%</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-title"><i class="fas fa-users"></i> Unique visitors</div>
                    <div class="kpi-number">127.8K</div>
                    <div class="kpi-trend"><i class="fas fa-arrow-up"></i> +8.1%</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-title"><i class="fas fa-file-signature"></i> Applications</div>
                    <div class="kpi-number">18,432</div>
                    <div class="kpi-trend"><i class="fas fa-arrow-up"></i> +24.5%</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-title"><i class="fas fa-clock"></i> Avg. session</div>
                    <div class="kpi-number">4m 32s</div>
                    <div class="kpi-trend down"><i class="fas fa-arrow-down"></i> -0.8%</div>
                </div>
            </div>

            <!-- charts row: website visits + traffic sources -->
            <div class="charts-row">
                <!-- website visits chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Website visits (last 7 days)</h3>
                        <select>
                            <option>Daily</option>
                            <option>Weekly</option>
                            <option>Monthly</option>
                        </select>
                    </div>
                    <div class="visit-bars">
                        <div class="bar-group"><div class="bar-container"><div class="bar-fill" style="height: 110px;"></div></div><span class="bar-label">Mon</span></div>
                        <div class="bar-group"><div class="bar-container"><div class="bar-fill" style="height: 85px;"></div></div><span class="bar-label">Tue</span></div>
                        <div class="bar-group"><div class="bar-container"><div class="bar-fill" style="height: 130px;"></div></div><span class="bar-label">Wed</span></div>
                        <div class="bar-group"><div class="bar-container"><div class="bar-fill" style="height: 145px;"></div></div><span class="bar-label">Thu</span></div>
                        <div class="bar-group"><div class="bar-container"><div class="bar-fill" style="height: 120px;"></div></div><span class="bar-label">Fri</span></div>
                        <div class="bar-group"><div class="bar-container"><div class="bar-fill" style="height: 70px;"></div></div><span class="bar-label">Sat</span></div>
                        <div class="bar-group"><div class="bar-container"><div class="bar-fill" style="height: 55px;"></div></div><span class="bar-label">Sun</span></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: #5570b3; font-size:0.8rem;">
                        <span>↗️ Peak: 14.5K (Thursday)</span>
                        <span>Total: 84.2K visits</span>
                    </div>
                </div>

                <!-- traffic sources -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Traffic sources</h3>
                        <i class="fas fa-ellipsis-h"></i>
                    </div>
                    <div class="source-list">
                        <div class="source-item">
                            <div class="source-info">
                                <div class="source-icon"><i class="fas fa-search"></i></div>
                                <div class="source-details">
                                    <h4>Organic Search</h4>
                                    <span>Google, Bing</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span class="source-value">48.2K</span>
                                <span class="source-percent">38%</span>
                            </div>
                        </div>
                        <div class="source-item">
                            <div class="source-info">
                                <div class="source-icon"><i class="fas fa-mouse-pointer"></i></div>
                                <div class="source-details">
                                    <h4>Direct</h4>
                                    <span>Direct traffic</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span class="source-value">32.1K</span>
                                <span class="source-percent">25%</span>
                            </div>
                        </div>
                        <div class="source-item">
                            <div class="source-info">
                                <div class="source-icon"><i class="fab fa-linkedin"></i></div>
                                <div class="source-details">
                                    <h4>Social Media</h4>
                                    <span>LinkedIn, Twitter</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span class="source-value">21.5K</span>
                                <span class="source-percent">17%</span>
                            </div>
                        </div>
                        <div class="source-item">
                            <div class="source-info">
                                <div class="source-icon"><i class="fas fa-envelope"></i></div>
                                <div class="source-details">
                                    <h4>Email Campaigns</h4>
                                    <span>Newsletters</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span class="source-value">15.3K</span>
                                <span class="source-percent">12%</span>
                            </div>
                        </div>
                        <div class="source-item">
                            <div class="source-info">
                                <div class="source-icon"><i class="fas fa-ad"></i></div>
                                <div class="source-details">
                                    <h4>Paid Ads</h4>
                                    <span>Google, LinkedIn</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span class="source-value">10.7K</span>
                                <span class="source-percent">8%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- bottom analytics grid -->
            <div class="analytics-grid">
                <!-- page visits -->
                <div class="analytics-card">
                    <div class="analytics-header">
                        <h3>Top pages</h3>
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="pages-list">
                        <div class="page-item">
                            <span class="page-url">/jobs</span>
                            <div class="page-stats">
                                <span class="page-visits">42.1K</span>
                                <span class="page-trend">+12%</span>
                            </div>
                        </div>
                        <div class="page-item">
                            <span class="page-url">/companies</span>
                            <div class="page-stats">
                                <span class="page-visits">28.3K</span>
                                <span class="page-trend">+8%</span>
                            </div>
                        </div>
                        <div class="page-item">
                            <span class="page-url">/candidates</span>
                            <div class="page-stats">
                                <span class="page-visits">19.7K</span>
                                <span class="page-trend">+5%</span>
                            </div>
                        </div>
                        <div class="page-item">
                            <span class="page-url">/job-detail</span>
                            <div class="page-stats">
                                <span class="page-visits">15.2K</span>
                                <span class="page-trend">+18%</span>
                            </div>
                        </div>
                        <div class="page-item">
                            <span class="page-url">/dashboard</span>
                            <div class="page-stats">
                                <span class="page-visits">8.9K</span>
                                <span class="page-trend">-2%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- user demographics -->
                <div class="analytics-card">
                    <div class="analytics-header">
                        <h3>User demographics</h3>
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">🇺🇸 United States</span>
                        <span class="stat-value">42%</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">🇬🇧 United Kingdom</span>
                        <span class="stat-value">18%</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">🇨🇦 Canada</span>
                        <span class="stat-value">12%</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">🇩🇪 Germany</span>
                        <span class="stat-value">8%</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">🇦🇺 Australia</span>
                        <span class="stat-value">6%</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Others</span>
                        <span class="stat-value">14%</span>
                    </div>
                </div>

                <!-- devices & engagement -->
                <div class="analytics-card">
                    <div class="analytics-header">
                        <h3>Devices & engagement</h3>
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="device-item">
                        <div class="device-info">
                            <i class="fas fa-mobile-alt"></i>
                            <span>Mobile</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="device-bar"><div class="device-bar-fill" style="width: 65px;"></div></div>
                            <span class="stat-value">65%</span>
                        </div>
                    </div>
                    <div class="device-item">
                        <div class="device-info">
                            <i class="fas fa-laptop"></i>
                            <span>Desktop</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="device-bar"><div class="device-bar-fill" style="width: 30px;"></div></div>
                            <span class="stat-value">30%</span>
                        </div>
                    </div>
                    <div class="device-item">
                        <div class="device-info">
                            <i class="fas fa-tablet-alt"></i>
                            <span>Tablet</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="device-bar"><div class="device-bar-fill" style="width: 5px;"></div></div>
                            <span class="stat-value">5%</span>
                        </div>
                    </div>
                    <div style="margin-top: 1.5rem;">
                        <div class="stat-row">
                            <span class="stat-label">Bounce rate</span>
                            <span class="stat-value">34.2%</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">New vs returning</span>
                            <span class="stat-value">42% / 58%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- export and additional insights -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                <div class="export-btn">
                    <i class="fas fa-download"></i> Export full report (PDF)
                </div>
                <div style="display: flex; gap: 1.5rem; color: #5570b3; font-size:0.9rem;">
                    <span><i class="fas fa-sync-alt"></i> Updated 5 min ago</span>
                    <span><i class="fas fa-chart-pie"></i> Compare to previous period</span>
                </div>
            </div>

        </main>
    </div>
</body>
</html>