<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobFlow · Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; background: #f3f5f9; color: #171c28;height: 100vh; }
        .dashboard { width: 100%; background: #fff; box-shadow: 0 30px 60px rgba(0, 10, 30, 0.12); display: grid; grid-template-columns: 280px 1fr; overflow: hidden; }
        .sidebar { background: #0b132b; padding: 2rem 1.5rem; display: flex; flex-direction: column; gap: 2.5rem;     height: 100vh; }
        .logo-area { display: flex; align-items: center; gap: 0.75rem; padding-left: 0.5rem; }
        .logo-icon { background: #4f9cf7; width: 36px; height: 36px; border-radius: 12px; display:flex; align-items:center; justify-content:center; font-size:1.4rem; color:#fff; box-shadow:0 8px 16px -4px #1f4f9f33; }
        .logo-text { font-weight:700; font-size:1.5rem; letter-spacing:-0.02em; color:#fff; }
        .logo-text span { color: #6aa9ff; font-weight: 500; }
        .nav { display:flex; flex-direction:column; gap:0.6rem; }
        .nav-item { display:flex; align-items:center; gap:1rem; padding:0.85rem 1.2rem; border-radius:16px; font-weight:500; font-size:1rem; color:#b2bfe0; transition:all .2s; text-decoration:none; }
        .nav-item i { width:24px; font-size:1.3rem; color:#6b81b4; }
        .nav-item.active { background:#1f2942; color:#fff; }
        .nav-item.active i { color:#6aa9ff; }
        .nav-item:not(.active):hover { background:#151f38; color:#d6e1ff; }
        .sidebar-footer { margin-top:auto; border-top:1px solid #1e2940; padding-top:1.8rem; }
        .company-switch { background:#101a30; border-radius:20px; padding:1rem 1.2rem; display:flex; align-items:center; gap:.8rem; }
        .company-switch .info { flex:1; }
        .company-name { color:#fff; font-weight:600; font-size:.95rem; }
        .company-role { color:#778fcb; font-size:.8rem; }
        .main { background:#f9fafd; padding:1.8rem 2.2rem 2.2rem 2.2rem; display:flex; flex-direction:column; gap:2rem; }
        .header { display:flex; justify-content:space-between; align-items:center; }
        .page-title h1 { font-size:1.9rem; font-weight:700; letter-spacing:-.02em; color:#0e1b36; }
        .page-title p { color:#5a6e97; font-size:.95rem; margin-top:4px; font-weight:500; }
        .header-right { display:flex; align-items:center; gap:2rem; }
        .search-bar { background:#fff; border-radius:40px; padding:.5rem 1rem .5rem 1.5rem; display:flex; align-items:center; gap:.6rem; box-shadow:0 4px 12px rgba(0,0,0,.02); border:1px solid #eaeef5; }
        .search-bar i { color:#8799c7; font-size:1rem; }
        .search-bar input { border:none; background:transparent; font-weight:500; width:200px; font-size:.95rem; outline:none; }
        .profile-pic { width:48px; height:48px; background:linear-gradient(145deg,#1f3a6b,#0f2342); border-radius:30px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:600; font-size:1.2rem; }
        .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; }
        .stat-card { background:#fff; border-radius:28px; padding:1.5rem 1.3rem; box-shadow:0 8px 22px -8px rgba(0,20,40,.06); border:1px solid #f0f3fa; display:flex; flex-direction:column; gap:1rem; }
        .stat-title { color:#3c4d73; font-size:.95rem; font-weight:600; text-transform:uppercase; letter-spacing:.02em; display:flex; align-items:center; gap:.5rem; }
        .stat-value { font-size:2.6rem; font-weight:700; color:#0b1c3a; line-height:1; }
        .stat-trend { display:flex; align-items:center; gap:.4rem; font-size:.85rem; font-weight:600; color:#1b823f; background:#e7f6ec; padding:.35rem .8rem; border-radius:30px; width:fit-content; }
        .stat-trend.neutral { color:#6f6f89; background:#eaeef5; }
        .insight-panels { display:grid; grid-template-columns:1.2fr .9fr; gap:1.5rem; }
        .panel { background:#fff; border-radius:30px; padding:1.5rem 1.2rem 1.2rem 1.5rem; box-shadow:0 8px 26px rgba(0,0,0,.02); border:1px solid #f0f2f8; }
        .panel-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; }
        .panel-header h3 { font-weight:700; font-size:1.25rem; color:#1a2647; }
        .panel-header a { color:#517bcb; font-size:.9rem; font-weight:600; text-decoration:none; }
        .job-item { display:flex; align-items:center; justify-content:space-between; padding:.9rem 0; border-bottom:1px solid #f1f4fd; }
        .job-item:last-child { border-bottom:none; }
        .job-info { display:flex; align-items:center; gap:1rem; }
        .job-icon { width:44px; height:44px; background:#ecf2ff; border-radius:16px; display:flex; align-items:center; justify-content:center; color:#2f57b3; font-size:1.2rem; }
        .job-details h4 { font-weight:700; font-size:1rem; color:#151f36; }
        .job-meta { display:flex; align-items:center; gap:.8rem; font-size:.8rem; color:#5b6f9a; margin-top:4px; }
        .job-meta span { background:#f0f4fe; padding:.2rem .6rem; border-radius:40px; font-weight:600; }
        .job-status { padding:.3rem 1rem; border-radius:40px; font-weight:600; font-size:.8rem; background:#e6ecfe; color:#294fb1; }
        .job-status.closed { background:#edf0f8; color:#6b7392; }
        .chart-bars { display:flex; align-items:flex-end; gap:.9rem; height:170px; margin:1rem 0 1.5rem 0; }
        .bar-item { flex:1; display:flex; flex-direction:column; align-items:center; gap:.5rem; }
        .bar { width:100%; background:#dbe4fd; border-radius:14px 14px 6px 6px; height:140px; position:relative; }
        .bar.fill { background:#2e5fd7; width:100%; position:absolute; bottom:0; border-radius:14px 14px 6px 6px; }
        .bar-label { font-size:.7rem; font-weight:600; color:#4f6290; }
        .legend { display:flex; justify-content:space-between; background:#f7f9ff; padding:.8rem 1rem; border-radius:22px; font-size:.8rem; font-weight:500; }
        .applicant-row { display:flex; align-items:center; justify-content:space-between; padding:.8rem 0; border-bottom:1px solid #f0f4fd; }
        .applicant-info { display:flex; align-items:center; gap:1rem; }
        .avatar { width:40px; height:40px; border-radius:40px; background:#cbd9ff; display:flex; align-items:center; justify-content:center; font-weight:600; color:#102a61; }
        .applicant-details h4 { font-size:.95rem; font-weight:700; color:#121f3f; }
        .applicant-details p { font-size:.75rem; color:#60709b; }
        .badge { background:#e0e8fe; padding:.2rem .9rem; border-radius:40px; font-size:.7rem; font-weight:700; color:#1f4191; }
        .actions { display:flex; gap:1rem; margin-top:.5rem; flex-wrap:wrap; }
        .action-btn { background:#fff; border:1px solid #e2e9fa; border-radius:20px; padding:.75rem 1.5rem; display:flex; align-items:center; gap:.6rem; font-weight:600; color:#17223b; text-decoration:none; transition:.2s; }
        .action-btn i { color:#3b64c2; }
        .action-btn:hover { background:#f1f6ff; border-color:#b7ceff; }
        .users-panel { margin-top:.5rem; }
        .user-row { display:flex; align-items:center; justify-content:space-between; padding:.8rem 0; border-bottom:1px solid #f0f4fd; }
        .user-row:last-child { border-bottom:none; }
        .user-meta { font-size:.78rem; color:#60709b; }
        .activity-list { margin-top:.3rem; }
        .activity-row { display:grid; grid-template-columns:2fr .8fr .9fr; gap:.8rem; align-items:center; padding:.72rem 0; border-bottom:1px solid #f0f4fd; }
        .activity-row:last-child { border-bottom:none; }
        .activity-name { font-size:.9rem; font-weight:600; color:#121f3f; word-break:break-word; }
        .activity-meta { font-size:.78rem; color:#60709b; word-break:break-word; }
        .toolbar { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; }
        .filters-form { background:#fff; border:1px solid #e8edf8; border-radius:20px; padding:1rem; display:grid; grid-template-columns:2fr 1fr 1fr 1fr 1fr auto; gap:.7rem; }
        .input, .select { width:100%; border:1px solid #dde5f6; border-radius:12px; padding:.55rem .7rem; font-size:.88rem; color:#1d2a49; background:#fff; }
        .btn { border:1px solid #d8e2f8; background:#fff; border-radius:12px; padding:.55rem .9rem; font-size:.86rem; font-weight:600; color:#213763; text-decoration:none; cursor:pointer; }
        .btn.primary { background:#2f57b3; color:#fff; border-color:#2f57b3; }
        .btn.danger { background:#fff5f5; color:#b12727; border-color:#f3cccc; }
        .table-wrap { background:#fff; border:1px solid #ecf1fb; border-radius:20px; overflow:hidden; }
        .data-table { width:100%; border-collapse:collapse; font-size:.86rem; }
        .data-table th { text-align:left; background:#f8faff; color:#405680; padding:.8rem; border-bottom:1px solid #edf2fc; font-size:.78rem; text-transform:uppercase; letter-spacing:.02em; }
        .data-table td { padding:.9rem .8rem; border-bottom:1px solid #f0f4fd; vertical-align:middle; color:#1c2a49; }
        .data-table tr:last-child td { border-bottom:none; }
        .muted { color:#6479a4; font-size:.78rem; }
        .pill { padding:.2rem .6rem; border-radius:999px; font-size:.72rem; font-weight:700; display:inline-block; }
        .pill.published { background:#e8f6ed; color:#1f8b4c; }
        .pill.draft { background:#eef2fb; color:#4f5d7f; }
        .pill.closed { background:#fdecec; color:#b13636; }
        .inline-actions { display:flex; gap:.45rem; flex-wrap:wrap; }
        .pagination-wrap { margin-top:1rem; display:flex; justify-content:flex-end; }
        hr { border:none; border-top:2px solid #edf2fc; margin:1.2rem 0 1rem 0; }
        @media (max-width: 1280px) { .filters-form { grid-template-columns:1fr 1fr; } }
        @media (max-width: 1100px) { .dashboard { grid-template-columns:1fr; } .sidebar { display:none; } .insight-panels,.stats-grid { grid-template-columns:1fr; } .filters-form { grid-template-columns:1fr; } }
    </style>
</head>
