<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Empleados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:          #F0F2F5;
            --surface:     #FFFFFF;
            --border:      #E4E7EC;
            --text:        #1A1D23;
            --text-muted:  #7C8190;
            --primary:     #3B5BDB;
            --primary-h:   #2F4AC5;
            --primary-soft:#EEF2FF;
            --success:     #2F9E44;
            --success-bg:  #EBFBEE;
            --danger:      #E03131;
            --danger-bg:   #FFF5F5;
            --radius:      12px;
            --radius-sm:   8px;
            --shadow-sm:   0 1px 2px rgba(0,0,0,.06);
            --shadow:      0 1px 4px rgba(0,0,0,.08), 0 4px 20px rgba(0,0,0,.04);
            --shadow-lg:   0 8px 32px rgba(0,0,0,.14);
            --transition:  .2s cubic-bezier(.4,0,.2,1);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 64px; height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            align-items: center; padding: 20px 0;
            gap: 6px; z-index: 100;
            box-shadow: var(--shadow-sm);
        }
        .sidebar-logo {
            width: 38px; height: 38px;
            background: var(--primary);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 22px;
            box-shadow: 0 4px 12px rgba(59,91,219,.35);
            transition: var(--transition);
            text-decoration: none;
        }
        .sidebar-logo:hover { transform: scale(1.07); box-shadow: 0 6px 18px rgba(59,91,219,.4); }
        .sidebar-logo svg { color: white; }
        .sidebar-icon {
            width: 42px; height: 42px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted); cursor: pointer;
            transition: var(--transition); text-decoration: none;
            position: relative;
        }
        .sidebar-icon::before {
            content: ''; position: absolute; left: 0; top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 3px; height: 20px; border-radius: 0 3px 3px 0;
            background: var(--primary); transition: var(--transition);
        }
        .sidebar-icon:hover  { background: var(--primary-soft); color: var(--primary); }
        .sidebar-icon.active { background: var(--primary-soft); color: var(--primary); }
        .sidebar-icon.active::before { transform: translateY(-50%) scaleY(1); }

        /* ── TOPBAR ── */
        .topbar {
            position: fixed; top: 0; left: 64px; right: 0; height: 64px;
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 32px; gap: 16px; z-index: 99;
        }
        .topbar h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem; font-weight: 800; flex: 1; letter-spacing: -.01em;
        }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #7048e8);
            color: white; display: flex; align-items: center; justify-content: center;
            font-size: .78rem; font-weight: 600; cursor: pointer;
            box-shadow: 0 2px 8px rgba(59,91,219,.3); transition: var(--transition);
        }
        .avatar:hover { transform: scale(1.08); }
        .icon-btn {
            width: 36px; height: 36px; border-radius: var(--radius-sm);
            border: 1px solid var(--border); background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--text-muted); transition: var(--transition);
        }
        .icon-btn:hover { background: var(--primary-soft); color: var(--primary); border-color: transparent; }

        /* ── MAIN ── */
        .main { margin-left: 64px; padding-top: 64px; flex: 1; padding: 64px 32px 48px 96px; }
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 28px 0 22px;
        }
        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.55rem; font-weight: 800; letter-spacing: -.02em;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif; font-size: .875rem;
            font-weight: 500; cursor: pointer; border: none;
            text-decoration: none; transition: var(--transition);
        }
        .btn-primary {
            background: var(--primary); color: #fff;
            box-shadow: 0 2px 8px rgba(59,91,219,.28);
        }
        .btn-primary:hover {
            background: var(--primary-h);
            box-shadow: 0 4px 14px rgba(59,91,219,.38);
            transform: translateY(-1px);
        }
        .btn-primary:active { transform: translateY(0); }
        .btn-ghost {
            background: transparent; color: var(--text-muted);
            border: 1px solid var(--border);
        }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }
        .btn-danger-ghost {
            background: transparent; color: var(--danger); border: 1px solid #FFCDD2;
        }
        .btn-danger-ghost:hover { background: var(--danger-bg); }
        .btn-sm { padding: 6px 13px; font-size: .8rem; }

        /* ── CARD ── */
        .card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius); box-shadow: var(--shadow);
        }

        /* ── STATS ── */
        .stats-row {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 16px; margin-bottom: 22px;
        }
        .stat-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 20px 22px;
            box-shadow: var(--shadow);
            transition: box-shadow var(--transition), transform var(--transition);
        }
        .stat-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
        .stat-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--primary-soft);
            display: flex; align-items: center; justify-content: center;
            color: var(--primary); margin-bottom: 14px; transition: var(--transition);
        }
        .stat-card:hover .stat-icon { background: var(--primary); color: white; }
        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 1.8rem; font-weight: 800; line-height: 1;
        }
        .stat-label { font-size: .78rem; color: var(--text-muted); margin-top: 5px; }

        /* ── TABLE ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            text-align: left; padding: 11px 16px;
            font-size: .72rem; font-weight: 600; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: .06em;
            border-bottom: 1px solid var(--border); background: #FAFBFC;
        }
        tbody tr { transition: background var(--transition); animation: rowIn .3s ease both; }
        tbody tr:nth-child(1)  { animation-delay: .03s; }
        tbody tr:nth-child(2)  { animation-delay: .06s; }
        tbody tr:nth-child(3)  { animation-delay: .09s; }
        tbody tr:nth-child(4)  { animation-delay: .12s; }
        tbody tr:nth-child(5)  { animation-delay: .15s; }
        tbody tr:nth-child(6)  { animation-delay: .18s; }
        tbody tr:nth-child(7)  { animation-delay: .21s; }
        tbody tr:nth-child(8)  { animation-delay: .24s; }
        tbody tr:nth-child(9)  { animation-delay: .27s; }
        tbody tr:nth-child(10) { animation-delay: .30s; }
        @keyframes rowIn {
            from { opacity: 0; transform: translateX(-6px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        tbody tr:hover { background: #F5F7FF; }
        tbody td {
            padding: 13px 16px; font-size: .875rem;
            border-bottom: 1px solid var(--border);
        }
        tbody tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 20px;
            font-size: .72rem; font-weight: 600;
        }
        .badge-blue { background: var(--primary-soft); color: var(--primary); }

        /* ── TOOLBAR ── */
        .toolbar { display: flex; align-items: center; gap: 12px; padding: 16px 16px 0; }
        .search-wrap { flex: 1; position: relative; }
        .search-wrap svg {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); pointer-events: none; transition: color var(--transition);
        }
        .search-wrap:focus-within svg { color: var(--primary); }
        .search-input {
            width: 100%; padding: 9px 14px 9px 38px;
            border: 1px solid var(--border); border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif; font-size: .875rem;
            background: var(--bg); color: var(--text); outline: none; transition: var(--transition);
        }
        .search-input:focus {
            border-color: var(--primary); background: var(--surface);
            box-shadow: 0 0 0 3px rgba(59,91,219,.1);
        }

        /* ── ALERTS ── */
        .alert {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; border-radius: var(--radius-sm);
            font-size: .875rem; margin-bottom: 20px;
            animation: slideDown .3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert-success { background: var(--success-bg); color: var(--success); border: 1px solid #B2F2BB; }
        .alert-error   { background: var(--danger-bg);  color: var(--danger);  border: 1px solid #FFCDD2; }

        /* ── FORM ── */
        .form-card { padding: 28px 32px; max-width: 560px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: .82rem; font-weight: 500; margin-bottom: 6px; color: var(--text-muted); }
        .form-control {
            width: 100%; padding: 10px 14px;
            border: 1px solid var(--border); border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif; font-size: .9rem;
            color: var(--text); background: var(--surface); outline: none; transition: var(--transition);
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59,91,219,.1); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-actions { display: flex; gap: 10px; margin-top: 28px; }

        /* ── TABLE FOOTER ── */
        .table-footer {
            padding: 13px 16px; color: var(--text-muted); font-size: .78rem;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; gap: 6px;
        }
        .live-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--success); animation: livePulse 2s infinite;
        }
        @keyframes livePulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: .45; transform: scale(.75); }
        }

        /* ── MODAL ── */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(15,20,35,.5); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
            z-index: 200; align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: var(--surface); border-radius: 16px; padding: 32px;
            max-width: 400px; width: 90%; box-shadow: var(--shadow-lg); text-align: center;
            animation: modalIn .25s cubic-bezier(.34,1.56,.64,1);
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(.9) translateY(16px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-icon {
            width: 54px; height: 54px; border-radius: 50%;
            background: var(--danger-bg); color: var(--danger);
            display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
        }
        .modal h3 { font-family: 'Syne', sans-serif; font-size: 1.1rem; margin-bottom: 8px; }
        .modal p  { font-size: .875rem; color: var(--text-muted); margin-bottom: 24px; line-height: 1.6; }
        .modal-actions { display: flex; gap: 10px; justify-content: center; }

        /* ── ROW ACTIONS ── */
        .row-actions { display: flex; gap: 6px; justify-content: flex-end; }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animated    { animation: fadeUp .35s ease both; }
        .animated-d1 { animation: fadeUp .35s .07s ease both; }
        .animated-d2 { animation: fadeUp .35s .14s ease both; }
        .animated-d3 { animation: fadeUp .35s .21s ease both; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d0d5de; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #b0b5c0; }
    </style>
</head>
<body>

<aside class="sidebar">
    <a href="index.php?action=index" class="sidebar-logo">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
        </svg>
    </a>
    <a href="index.php?action=index" class="sidebar-icon active" title="Empleados">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
    </a>
    <a href="index.php?action=create" class="sidebar-icon" title="Nuevo empleado">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
    </a>
</aside>

<header class="topbar">
    <h1>Sistema de Empleados</h1>
    <div class="topbar-actions">
        <div class="icon-btn" title="Notificaciones">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <div class="avatar" title="Pablo Del Rio">PD</div>
    </div>
</header>

<main class="main">
