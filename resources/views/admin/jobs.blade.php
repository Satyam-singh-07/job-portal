<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobFlow · Admin job module (platform view)</title>
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
            background: #f0f3fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1.5rem;
            color: #131e42;
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

        /* --- SIDEBAR (admin global nav) --- */
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

        /* --- MAIN CONTENT : ADMIN JOB MODULE (PLATFORM WIDE) --- */
        .main {
            background: #f8faff;
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
        .search-bar {
            background: white;
            border-radius: 40px;
            padding: 0.5rem 1rem 0.5rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.02);
            border: 1px solid #e5ecfc;
        }
        .search-bar i {
            color: #7f96cc;
        }
        .search-bar input {
            border: none;
            background: transparent;
            font-weight: 500;
            width: 240px;
            font-size: 0.95rem;
            outline: none;
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

        /* global platform stats (admin view) */
        .platform-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
        .stat-card {
            background: white;
            border-radius: 28px;
            padding: 1.4rem 1.5rem;
            border: 1px solid #edf2fd;
            box-shadow: 0 8px 18px -6px rgba(0, 20, 50, 0.04);
        }
        .stat-title {
            color: #445e93;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .stat-number {
            font-size: 2.4rem;
            font-weight: 700;
            color: #0c1a3b;
            line-height: 1.2;
        }
        .stat-trend {
            font-size: 0.8rem;
            font-weight: 600;
            color: #1f8b4c;
            background: #e1f3e8;
            padding: 0.3rem 0.9rem;
            border-radius: 30px;
            width: fit-content;
            margin-top: 0.3rem;
        }

        /* admin filter bar — companies / status / flags */
        .admin-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            background: white;
            border-radius: 40px;
            padding: 0.5rem 0.5rem 0.5rem 1.5rem;
            border: 1px solid #e3ebfc;
        }
        .company-filters {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .company-tag {
            background: #f1f5ff;
            border-radius: 40px;
            padding: 0.5rem 1.3rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: #1f3a7a;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            cursor: default;
        }
        .company-tag i {
            color: #5471c3;
        }
        .company-tag.active {
            background: #1d2d52;
            color: white;
        }
        .company-tag.active i {
            color: #b3ceff;
        }
        .admin-actions {
            display: flex;
            gap: 0.5rem;
        }
        .admin-btn {
            background: white;
            border: 1px solid #dde5fa;
            border-radius: 40px;
            padding: 0.6rem 1.4rem;
            font-weight: 600;
            color: #263e72;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .admin-btn.primary {
            background: #1d2d52;
            border-color: #1d2d52;
            color: white;
        }
        .admin-btn i {
            color: #7e9cfa;
        }

        /* cross-company job table */
        .admin-job-table {
            background: white;
            border-radius: 32px;
            border: 1px solid #ecf2fe;
            overflow: auto;
            box-shadow: 0 12px 30px -12px rgba(0,20,60,0.06);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }
        th {
            text-align: left;
            padding: 1.3rem 1.5rem;
            background: #f8fcff;
            font-weight: 600;
            font-size: 0.85rem;
            color: #36508a;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            border-bottom: 1px solid #e2ebfc;
        }
        td {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #f0f5ff;
            color: #172441;
            font-weight: 500;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .company-badge {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .company-logo {
            width: 34px;
            height: 34px;
            background: #e9efff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #17387e;
            font-weight: 700;
        }
        .job-title-admin {
            font-weight: 700;
            color: #0b1c44;
        }
        .dept-tag {
            background: #e6edfe;
            border-radius: 40px;
            padding: 0.2rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #204197;
            width: fit-content;
        }
        .status-badge {
            background: #e0f0e9;
            color: #166342;
            font-weight: 600;
            font-size: 0.8rem;
            padding: 0.3rem 1rem;
            border-radius: 30px;
            width: fit-content;
        }
        .status-badge.closed {
            background: #eceff9;
            color: #4d5b86;
        }
        .status-badge.pending {
            background: #fff1d9;
            color: #a75816;
        }
        .flag-icon {
            color: #d0a244;
            font-size: 1.2rem;
            margin-right: 0.3rem;
        }
        .action-icons i {
            color: #8095cc;
            margin: 0 0.4rem;
            font-size: 1.1rem;
            opacity: 0.7;
            transition: 0.1s;
            cursor: default;
        }
        .action-icons i:hover { opacity: 1; }

        /* admin notes & pagination */
        .admin-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }
        .bulk-actions {
            display: flex;
            gap: 1rem;
        }
        .bulk-btn {
            background: white;
            border: 1px solid #e3ebfc;
            border-radius: 40px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            color: #1d315c;
            font-size: 0.9rem;
        }
        .pagination {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        .page-circle {
            width: 40px;
            height: 40px;
            border-radius: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #2b4180;
            background: white;
            border: 1px solid #e0eafe;
        }
        .page-circle.active {
            background: #1d2d52;
            color: white;
            border-color: #1d2d52;
        }
    </style>
</head>
<body>
    <div class="admin-panel">

        <!-- SIDEBAR (admin context) -->
        <aside class="sidebar">
            <div class="logo-area">
                <div class="logo-icon"><i class="fas fa-bolt"></i></div>
                <div class="logo-text">Job<span>Flow</span></div>
            </div>
            <nav class="nav">
                <div class="nav-item"><i class="fas fa-chart-pie"></i> <span>Dashboard</span></div>
                <div class="nav-item active"><i class="fas fa-briefcase"></i> <span>Jobs (platform)</span></div>
                <div class="nav-item"><i class="fas fa-building"></i> <span>Companies</span></div>
                <div class="nav-item"><i class="fas fa-users"></i> <span>Candidates</span></div>
                <div class="nav-item"><i class="fas fa-flag"></i> <span>Reports</span></div>
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

        <!-- MAIN ADMIN JOB MODULE (platform wide) -->
        <main class="main">

            <!-- header -->
            <div class="header">
                <div class="page-title">
                    <h1>Job posts · all companies</h1>
                    <p>Oversee every job listing across the platform</p>
                </div>
                <div class="header-right">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search by job, company, ID...">
                    </div>
                    <div class="admin-profile">AR</div>
                </div>
            </div>

            <!-- global stats for admin -->
            <div class="platform-stats">
                <div class="stat-card"><div class="stat-title"><i class="fas fa-briefcase"></i> Total jobs</div><div class="stat-number">2,418</div><div class="stat-trend">+122 this month</div></div>
                <div class="stat-card"><div class="stat-title"><i class="fas fa-building"></i> Active companies</div><div class="stat-number">347</div><div class="stat-trend">+12 new</div></div>
                <div class="stat-card"><div class="stat-title"><i class="fas fa-clock"></i> Pending review</div><div class="stat-number">63</div><div class="stat-trend" style="color:#b45f1a; background:#ffedd6;">requires action</div></div>
                <div class="stat-card"><div class="stat-title"><i class="fas fa-flag"></i> Flagged</div><div class="stat-number">11</div><div class="stat-trend" style="color:#b13e3e; background:#ffe3e3;">violations</div></div>
            </div>

            <!-- admin filter row: by company / status / moderation -->
            <div class="admin-controls">
                <div class="company-filters">
                    <span class="company-tag active"><i class="fas fa-globe"></i> All companies</span>
                    <span class="company-tag"><i class="fas fa-check-circle"></i> Verified</span>
                    <span class="company-tag"><i class="fas fa-hourglass-half"></i> Pending</span>
                    <span class="company-tag"><i class="fas fa-exclamation-triangle"></i> Flagged</span>
                    <span class="company-tag"><i class="fas fa-calendar"></i> This week</span>
                </div>
                <div class="admin-actions">
                    <div class="admin-btn"><i class="fas fa-download"></i> Export</div>
                    <div class="admin-btn primary"><i class="fas fa-plus"></i> Add manual job</div>
                </div>
            </div>

            <!-- CROSS‑COMPANY JOB TABLE (admin view) -->
            <div class="admin-job-table">
                <table>
                    <thead>
                        <tr>
                            <th>Job & company</th>
                            <th>Department</th>
                            <th>Location</th>
                            <th>Applications</th>
                            <th>Status</th>
                            <th>Flags</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="company-badge">
                                    <div class="company-logo"><i class="fab fa-figma"></i></div>
                                    <div>
                                        <div class="job-title-admin">Senior Product Designer</div>
                                        <div style="font-size:0.8rem; color:#516fa3;">Figma · posted 2d ago</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="dept-tag">Design</span></td>
                            <td><i class="fas fa-map-marker-alt" style="color:#859ed0; width:20px;"></i> Remote</td>
                            <td><strong>47</strong> apps</td>
                            <td><span class="status-badge">active</span></td>
                            <td><span style="color:#c7a13b;"><i class="fas fa-flag flag-icon"></i> 1</span></td>
                            <td style="text-align:right;"><span class="action-icons"><i class="fas fa-eye"></i> <i class="fas fa-edit"></i> <i class="fas fa-ban"></i></span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="company-badge">
                                    <div class="company-logo"><i class="fab fa-google"></i></div>
                                    <div>
                                        <div class="job-title-admin">Frontend Developer (React)</div>
                                        <div style="font-size:0.8rem; color:#516fa3;">Google · posted 1w ago</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="dept-tag">Engineering</span></td>
                            <td><i class="fas fa-map-marker-alt" style="color:#859ed0;"></i> Mountain View</td>
                            <td><strong>128</strong> apps</td>
                            <td><span class="status-badge">active</span></td>
                            <td>—</td>
                            <td style="text-align:right;"><span class="action-icons"><i class="fas fa-eye"></i> <i class="fas fa-edit"></i> <i class="fas fa-ban"></i></span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="company-badge">
                                    <div class="company-logo"><i class="fas fa-chart-line"></i></div>
                                    <div>
                                        <div class="job-title-admin">Growth Marketing Lead</div>
                                        <div style="font-size:0.8rem; color:#516fa3;">Stripe · posted 5d ago</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="dept-tag">Marketing</span></td>
                            <td><i class="fas fa-map-marker-alt"></i> London / hybrid</td>
                            <td><strong>32</strong> apps</td>
                            <td><span class="status-badge pending">pending</span></td>
                            <td><span style="color:#c7a13b;"><i class="fas fa-flag"></i> 2</span></td>
                            <td style="text-align:right;"><span class="action-icons"><i class="fas fa-eye"></i> <i class="fas fa-edit"></i> <i class="fas fa-ban"></i></span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="company-badge">
                                    <div class="company-logo"><i class="fas fa-database"></i></div>
                                    <div>
                                        <div class="job-title-admin">Data Analyst</div>
                                        <div style="font-size:0.8rem; color:#516fa3;">Airbnb · posted 2w ago</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="dept-tag">Data</span></td>
                            <td><i class="fas fa-map-marker-alt"></i> Berlin</td>
                            <td><strong>71</strong> apps</td>
                            <td><span class="status-badge closed">closed</span></td>
                            <td>—</td>
                            <td style="text-align:right;"><span class="action-icons"><i class="fas fa-eye"></i> <i class="fas fa-edit"></i> <i class="fas fa-ban"></i></span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="company-badge">
                                    <div class="company-logo"><i class="fas fa-mobile-alt"></i></div>
                                    <div>
                                        <div class="job-title-admin">iOS Engineer</div>
                                        <div style="font-size:0.8rem; color:#516fa3;">Snap Inc. · posted 3d ago</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="dept-tag">Engineering</span></td>
                            <td><i class="fas fa-map-marker-alt"></i> Remote</td>
                            <td><strong>12</strong> apps</td>
                            <td><span class="status-badge">active</span></td>
                            <td><span style="color:#c13b3b;"><i class="fas fa-exclamation-triangle"></i> urgent</span></td>
                            <td style="text-align:right;"><span class="action-icons"><i class="fas fa-eye"></i> <i class="fas fa-edit"></i> <i class="fas fa-ban"></i></span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="company-badge">
                                    <div class="company-logo"><i class="fas fa-headset"></i></div>
                                    <div>
                                        <div class="job-title-admin">Customer Success Manager</div>
                                        <div style="font-size:0.8rem; color:#516fa3;">Zendesk · posted 6d ago</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="dept-tag">Support</span></td>
                            <td><i class="fas fa-map-marker-alt"></i> Austin</td>
                            <td><strong>27</strong> apps</td>
                            <td><span class="status-badge pending">pending</span></td>
                            <td>—</td>
                            <td style="text-align:right;"><span class="action-icons"><i class="fas fa-eye"></i> <i class="fas fa-edit"></i> <i class="fas fa-ban"></i></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- admin footer: bulk moderation + pagination -->
            <div class="admin-footer">
                <div class="bulk-actions">
                    <span class="bulk-btn"><i class="fas fa-check-double"></i> Bulk approve</span>
                    <span class="bulk-btn"><i class="fas fa-flag"></i> Flag selected</span>
                    <span class="bulk-btn"><i class="fas fa-archive"></i> Archive</span>
                </div>
                <div class="pagination">
                    <span class="page-circle"><i class="fas fa-chevron-left"></i></span>
                    <span class="page-circle active">1</span>
                    <span class="page-circle">2</span>
                    <span class="page-circle">3</span>
                    <span class="page-circle">4</span>
                    <span class="page-circle">...</span>
                    <span class="page-circle">12</span>
                    <span class="page-circle"><i class="fas fa-chevron-right"></i></span>
                </div>
            </div>

            <!-- admin hint -->
            <div style="font-size:0.85rem; color:#5570b3; display: flex; gap: 2rem; padding:0.5rem 0;">
                <i class="fas fa-shield-alt"></i> Platform overview · showing 187 jobs across 42 companies
            </div>
        </main>
    </div>
</body>
</html>