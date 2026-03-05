<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobFlow · Admin company module (table view)</title>
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

        /* --- MAIN CONTENT : COMPANY MODULE (TABLE VIEW) --- */
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

        /* platform stats: companies overview */
        .company-stats {
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
        .stat-trend.warn {
            background: #ffecdc;
            color: #b45f1a;
        }

        /* filter bar: company-specific filters */
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
        .filter-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .filter-tag {
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
        .filter-tag i {
            color: #5471c3;
        }
        .filter-tag.active {
            background: #1d2d52;
            color: white;
        }
        .filter-tag.active i {
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

        /* --- COMPANIES TABLE (ADMIN VIEW) --- */
        .company-table-wrapper {
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

        .company-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .company-logo {
            width: 44px;
            height: 44px;
            background: #e9efff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1d3f8f;
            font-size: 1.4rem;
            font-weight: 600;
        }
        .company-info h4 {
            font-weight: 700;
            color: #0b1c3f;
            margin-bottom: 0.2rem;
        }
        .company-info span {
            font-size: 0.8rem;
            color: #5b73ac;
        }

        .status-badge {
            background: #e1efdf;
            color: #1f6e3f;
            font-weight: 600;
            font-size: 0.8rem;
            padding: 0.3rem 1rem;
            border-radius: 30px;
            width: fit-content;
            text-transform: capitalize;
        }
        .status-badge.pending {
            background: #fff0d9;
            color: #b65817;
        }
        .status-badge.suspended {
            background: #ffe6e6;
            color: #b13e3e;
        }

        .detail-icons {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: #4f6eb0;
            font-size: 0.9rem;
        }
        .detail-icons i {
            width: 18px;
            color: #7b97d4;
        }

        .job-count {
            font-weight: 700;
            color: #1b2f60;
            background: #f1f6ff;
            padding: 0.3rem 0.8rem;
            border-radius: 40px;
            width: fit-content;
        }

        .action-icons {
            display: flex;
            gap: 0.5rem;
        }
        .action-icon {
            color: #6f8fd4;
            background: #f1f6ff;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: default;
            transition: 0.1s;
        }
        .action-icon:hover {
            background: #e2ecfe;
            color: #1d3d9c;
        }

        /* admin footer: bulk actions + pagination */
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

        <!-- SIDEBAR (admin) -->
        <aside class="sidebar">
            <div class="logo-area">
                <div class="logo-icon"><i class="fas fa-bolt"></i></div>
                <div class="logo-text">Job<span>Flow</span></div>
            </div>
            <nav class="nav">
                <div class="nav-item"><i class="fas fa-chart-pie"></i> <span>Dashboard</span></div>
                <div class="nav-item"><i class="fas fa-briefcase"></i> <span>Jobs (platform)</span></div>
                <div class="nav-item active"><i class="fas fa-building"></i> <span>Companies</span></div>
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

        <!-- MAIN COMPANY MODULE (TABLE VIEW) -->
        <main class="main">

            <!-- header -->
            <div class="header">
                <div class="page-title">
                    <h1>Companies</h1>
                    <p>Manage all registered companies on the platform</p>
                </div>
                <div class="header-right">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search by company, industry...">
                    </div>
                    <div class="admin-profile">AR</div>
                </div>
            </div>

            <!-- platform stats for companies -->
            <div class="company-stats">
                <div class="stat-card"><div class="stat-title"><i class="fas fa-building"></i> Total companies</div><div class="stat-number">347</div><div class="stat-trend">+12 this month</div></div>
                <div class="stat-card"><div class="stat-title"><i class="fas fa-check-circle"></i> Verified</div><div class="stat-number">291</div><div class="stat-trend">84%</div></div>
                <div class="stat-card"><div class="stat-title"><i class="fas fa-hourglass-half"></i> Pending review</div><div class="stat-number">38</div><div class="stat-trend warn">requires action</div></div>
                <div class="stat-card"><div class="stat-title"><i class="fas fa-exclamation-triangle"></i> Suspended</div><div class="stat-number">18</div><div class="stat-trend" style="color:#b13e3e; background:#ffe3e3;">violations</div></div>
            </div>

            <!-- filter row: company status and industry -->
            <div class="admin-controls">
                <div class="filter-tags">
                    <span class="filter-tag active"><i class="fas fa-globe"></i> All</span>
                    <span class="filter-tag"><i class="fas fa-check-circle"></i> Verified</span>
                    <span class="filter-tag"><i class="fas fa-hourglass-half"></i> Pending</span>
                    <span class="filter-tag"><i class="fas fa-exclamation-triangle"></i> Suspended</span>
                    <span class="filter-tag"><i class="fas fa-briefcase"></i> Tech</span>
                    <span class="filter-tag"><i class="fas fa-chart-line"></i> Finance</span>
                </div>
                <div class="admin-actions">
                    <div class="admin-btn"><i class="fas fa-download"></i> Export</div>
                    <div class="admin-btn primary"><i class="fas fa-plus"></i> Add company</div>
                </div>
            </div>

            <!-- COMPANIES TABLE (ADMIN VIEW) -->
            <div class="company-table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Industry</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Jobs</th>
                            <th>Applicants</th>
                            <th>Rating</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="company-cell">
                                    <div class="company-logo"><i class="fab fa-google"></i></div>
                                    <div class="company-info">
                                        <h4>Google</h4>
                                        <span>@google · since 2018</span>
                                    </div>
                                </div>
                            </td>
                            <td><span class="detail-icons"><i class="fas fa-globe"></i> Internet</span></td>
                            <td><span class="detail-icons"><i class="fas fa-map-marker-alt"></i> Mountain View</span></td>
                            <td><span class="status-badge">verified</span></td>
                            <td><span class="job-count">12</span></td>
                            <td>1,284</td>
                            <td><span class="detail-icons"><i class="fas fa-star" style="color: #f4b740;"></i> 4.8</span></td>
                            <td>
                                <div class="action-icons">
                                    <span class="action-icon"><i class="fas fa-eye"></i></span>
                                    <span class="action-icon"><i class="fas fa-edit"></i></span>
                                    <span class="action-icon"><i class="fas fa-ban"></i></span>
                                    <span class="action-icon"><i class="fas fa-flag"></i></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="company-cell">
                                    <div class="company-logo"><i class="fab fa-meta"></i></div>
                                    <div class="company-info">
                                        <h4>Meta</h4>
                                        <span>@meta · since 2016</span>
                                    </div>
                                </div>
                            </td>
                            <td><span class="detail-icons"><i class="fas fa-share-alt"></i> Social</span></td>
                            <td><span class="detail-icons"><i class="fas fa-map-marker-alt"></i> Menlo Park</span></td>
                            <td><span class="status-badge">verified</span></td>
                            <td><span class="job-count">8</span></td>
                            <td>2,103</td>
                            <td><span class="detail-icons"><i class="fas fa-star" style="color: #f4b740;"></i> 4.6</span></td>
                            <td>
                                <div class="action-icons">
                                    <span class="action-icon"><i class="fas fa-eye"></i></span>
                                    <span class="action-icon"><i class="fas fa-edit"></i></span>
                                    <span class="action-icon"><i class="fas fa-ban"></i></span>
                                    <span class="action-icon"><i class="fas fa-flag"></i></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="company-cell">
                                    <div class="company-logo"><i class="fas fa-rocket"></i></div>
                                    <div class="company-info">
                                        <h4>SpaceX</h4>
                                        <span>@spacex · pending docs</span>
                                    </div>
                                </div>
                            </td>
                            <td><span class="detail-icons"><i class="fas fa-satellite"></i> Aerospace</span></td>
                            <td><span class="detail-icons"><i class="fas fa-map-marker-alt"></i> Hawthorne</span></td>
                            <td><span class="status-badge pending">pending</span></td>
                            <td><span class="job-count">3</span></td>
                            <td>156</td>
                            <td><span class="detail-icons">new</span></td>
                            <td>
                                <div class="action-icons">
                                    <span class="action-icon"><i class="fas fa-eye"></i></span>
                                    <span class="action-icon"><i class="fas fa-edit"></i></span>
                                    <span class="action-icon"><i class="fas fa-check-circle" style="color:#27804e;"></i></span>
                                    <span class="action-icon"><i class="fas fa-flag"></i></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="company-cell">
                                    <div class="company-logo"><i class="fas fa-credit-card"></i></div>
                                    <div class="company-info">
                                        <h4>FintechFlow</h4>
                                        <span>@fintech · policy violation</span>
                                    </div>
                                </div>
                            </td>
                            <td><span class="detail-icons"><i class="fas fa-chart-line"></i> Fintech</span></td>
                            <td><span class="detail-icons"><i class="fas fa-map-marker-alt"></i> London</span></td>
                            <td><span class="status-badge suspended">suspended</span></td>
                            <td><span class="job-count">0</span></td>
                            <td>45</td>
                            <td><span class="detail-icons"><i class="fas fa-exclamation-circle" style="color:#c13b3b;"></i> flagged</span></td>
                            <td>
                                <div class="action-icons">
                                    <span class="action-icon"><i class="fas fa-eye"></i></span>
                                    <span class="action-icon"><i class="fas fa-edit"></i></span>
                                    <span class="action-icon"><i class="fas fa-undo-alt"></i></span>
                                    <span class="action-icon"><i class="fas fa-flag"></i></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="company-cell">
                                    <div class="company-logo"><i class="fab fa-microsoft"></i></div>
                                    <div class="company-info">
                                        <h4>Microsoft</h4>
                                        <span>@microsoft · since 2015</span>
                                    </div>
                                </div>
                            </td>
                            <td><span class="detail-icons"><i class="fas fa-window-maximize"></i> Software</span></td>
                            <td><span class="detail-icons"><i class="fas fa-map-marker-alt"></i> Redmond</span></td>
                            <td><span class="status-badge">verified</span></td>
                            <td><span class="job-count">23</span></td>
                            <td>3,421</td>
                            <td><span class="detail-icons"><i class="fas fa-star" style="color: #f4b740;"></i> 4.9</span></td>
                            <td>
                                <div class="action-icons">
                                    <span class="action-icon"><i class="fas fa-eye"></i></span>
                                    <span class="action-icon"><i class="fas fa-edit"></i></span>
                                    <span class="action-icon"><i class="fas fa-ban"></i></span>
                                    <span class="action-icon"><i class="fas fa-flag"></i></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="company-cell">
                                    <div class="company-logo"><i class="fas fa-store"></i></div>
                                    <div class="company-info">
                                        <h4>ShopLocal</h4>
                                        <span>@shoplocal · under review</span>
                                    </div>
                                </div>
                            </td>
                            <td><span class="detail-icons"><i class="fas fa-shopping-bag"></i> Retail</span></td>
                            <td><span class="detail-icons"><i class="fas fa-map-marker-alt"></i> Austin</span></td>
                            <td><span class="status-badge pending">pending</span></td>
                            <td><span class="job-count">2</span></td>
                            <td>23</td>
                            <td><span class="detail-icons">new</span></td>
                            <td>
                                <div class="action-icons">
                                    <span class="action-icon"><i class="fas fa-eye"></i></span>
                                    <span class="action-icon"><i class="fas fa-edit"></i></span>
                                    <span class="action-icon"><i class="fas fa-check-circle" style="color:#27804e;"></i></span>
                                    <span class="action-icon"><i class="fas fa-flag"></i></span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- admin footer: bulk actions + pagination -->
            <div class="admin-footer">
                <div class="bulk-actions">
                    <span class="bulk-btn"><i class="fas fa-check-double"></i> Bulk verify</span>
                    <span class="bulk-btn"><i class="fas fa-envelope"></i> Contact selected</span>
                    <span class="bulk-btn"><i class="fas fa-archive"></i> Archive</span>
                </div>
                <div class="pagination">
                    <span class="page-circle"><i class="fas fa-chevron-left"></i></span>
                    <span class="page-circle active">1</span>
                    <span class="page-circle">2</span>
                    <span class="page-circle">3</span>
                    <span class="page-circle">4</span>
                    <span class="page-circle">5</span>
                    <span class="page-circle">...</span>
                    <span class="page-circle">12</span>
                    <span class="page-circle"><i class="fas fa-chevron-right"></i></span>
                </div>
            </div>

            <!-- admin hint -->
            <div style="font-size:0.85rem; color:#5570b3; display: flex; gap: 2rem; padding:0.5rem 0;">
                <i class="fas fa-shield-alt"></i> Showing 1-6 of 347 companies · Last updated 5 min ago
            </div>
        </main>
    </div>
</body>
</html>