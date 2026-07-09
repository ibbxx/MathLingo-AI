<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Panel' }} — MathLingo AI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --color-primary:     #2563EB;
            --color-primary-10:  #EFF6FF;
            --color-primary-20:  #DBEAFE;
            --color-primary-dark:#1D4ED8;
            --color-secondary:   #22C55E;
            --color-accent:      #F59E0B;
            --color-danger:      #EF4444;
            --color-warning:     #F97316;
            --color-purple:      #8B5CF6;
            --color-bg:          #F1F5F9;
            --color-surface:     #FFFFFF;
            --color-border:      #E2E8F0;
            --color-text:        #0F172A;
            --color-muted:       #64748B;
            --admin-sidebar-w:   260px;
            --admin-topbar-h:    60px;
            --radius-card:       16px;
            --shadow-card:       0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.05);
            --shadow-card-hover: 0 4px 12px rgba(0,0,0,0.08), 0 16px 40px rgba(0,0,0,0.07);
        }

        html, body {
            margin: 0; padding: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--color-bg);
            color: var(--color-text);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* ═══════════════════════════════════════
           ADMIN SIDEBAR
        ═══════════════════════════════════════ */
        .admin-sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--admin-sidebar-w);
            background: #0F172A;
            display: flex;
            flex-direction: column;
            z-index: 40;
            transition: transform 0.25s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
        }

        /* Logo area */
        .admin-sidebar-logo {
            display: flex; align-items: center; gap: 10px;
            padding: 18px 16px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            text-decoration: none;
            flex-shrink: 0;
        }
        .admin-logo-mark {
            width: 34px; height: 34px; border-radius: 9px;
            background: var(--color-primary);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .admin-logo-text { display: flex; flex-direction: column; gap: 1px; }
        .admin-logo-name { font-size: 14px; font-weight: 800; color: #fff; letter-spacing: -0.3px; line-height: 1; }
        .admin-logo-badge {
            display: inline-flex; align-items: center;
            background: rgba(37,99,235,0.25); color: #93C5FD;
            font-size: 9px; font-weight: 700; letter-spacing: 0.07em;
            text-transform: uppercase; padding: 1px 6px; border-radius: 4px;
            margin-top: 3px; width: fit-content;
        }

        /* Nav scroll area */
        .admin-sidebar-nav {
            flex: 1; padding: 12px 10px;
            overflow-y: auto; overflow-x: hidden;
            display: flex; flex-direction: column; gap: 1px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.1) transparent;
        }
        .admin-sidebar-nav::-webkit-scrollbar { width: 4px; }
        .admin-sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .admin-nav-section {
            font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.3);
            letter-spacing: 0.09em; text-transform: uppercase;
            padding: 14px 8px 5px;
        }
        .admin-nav-section:first-child { padding-top: 4px; }

        .admin-nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: 9px;
            font-size: 13.5px; font-weight: 500; color: rgba(255,255,255,0.55);
            text-decoration: none;
            transition: background 0.12s, color 0.12s;
        }
        .admin-nav-item:hover {
            background: rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.9);
        }
        .admin-nav-item.active {
            background: var(--color-primary);
            color: #fff;
            font-weight: 600;
        }
        .admin-nav-item svg { flex-shrink: 0; opacity: 0.7; }
        .admin-nav-item.active svg, .admin-nav-item:hover svg { opacity: 1; }

        /* Sidebar footer */
        .admin-sidebar-footer {
            padding: 10px; border-top: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }
        .admin-sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 10px; border-radius: 9px;
            margin-bottom: 4px;
        }
        .admin-sidebar-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--color-primary);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 12px; font-weight: 700;
            flex-shrink: 0; overflow: hidden;
        }
        .admin-sidebar-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .admin-sidebar-user-info { flex: 1; min-width: 0; }
        .admin-sidebar-user-name {
            font-size: 13px; font-weight: 600; color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .admin-sidebar-user-role { font-size: 11px; color: #93C5FD; font-weight: 500; }

        .admin-btn-logout {
            display: flex; align-items: center; gap: 8px; width: 100%;
            padding: 8px 10px; border-radius: 9px;
            font-size: 13px; font-weight: 500;
            color: rgba(255,255,255,0.45);
            background: transparent; border: none; cursor: pointer;
            text-align: left; transition: background 0.12s, color 0.12s;
            font-family: inherit;
        }
        .admin-btn-logout:hover {
            background: rgba(239,68,68,0.12);
            color: #FCA5A5;
        }

        /* ═══════════════════════════════════════
           TOPBAR
        ═══════════════════════════════════════ */
        .admin-topbar {
            position: sticky; top: 0;
            height: var(--admin-topbar-h);
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            display: flex; align-items: center;
            padding: 0 24px; gap: 12px;
            z-index: 30;
        }
        .admin-hamburger {
            display: none; align-items: center; justify-content: center;
            width: 34px; height: 34px; border-radius: 8px;
            border: 1px solid var(--color-border); background: transparent;
            cursor: pointer; color: var(--color-muted);
            transition: background 0.12s;
        }
        .admin-hamburger:hover { background: #F1F5F9; }

        .admin-topbar-brand {
            display: flex; align-items: center; gap: 8px;
            font-size: 14px; font-weight: 700; color: var(--color-text);
        }
        .admin-topbar-brand-badge {
            background: var(--color-primary-10); color: var(--color-primary);
            font-size: 10px; font-weight: 700; letter-spacing: 0.05em;
            padding: 2px 7px; border-radius: 5px; text-transform: uppercase;
        }

        .admin-topbar-search {
            flex: 1; max-width: 340px; margin-left: 8px;
            display: flex; align-items: center; gap: 8px;
            background: var(--color-bg); border: 1px solid var(--color-border);
            border-radius: 9px; padding: 7px 12px; color: var(--color-muted);
        }
        .admin-topbar-search input {
            border: none; background: transparent; font-size: 13px;
            color: var(--color-text); font-family: inherit;
            outline: none; width: 100%;
        }
        .admin-topbar-search input::placeholder { color: var(--color-muted); }

        .admin-topbar-actions { display: flex; align-items: center; gap: 8px; margin-left: auto; }

        .admin-icon-btn {
            display: flex; align-items: center; justify-content: center;
            width: 34px; height: 34px; border-radius: 8px;
            border: 1px solid var(--color-border); background: transparent;
            cursor: pointer; color: var(--color-muted);
            transition: background 0.12s, color 0.12s;
            position: relative;
        }
        .admin-icon-btn:hover { background: #F1F5F9; color: var(--color-text); }
        .admin-notif-badge {
            position: absolute; top: 5px; right: 5px;
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--color-danger);
            border: 1.5px solid var(--color-surface);
        }

        .admin-topbar-avatar-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 5px 10px 5px 5px; border-radius: 9px;
            border: 1px solid var(--color-border); background: transparent;
            cursor: pointer; transition: background 0.12s;
        }
        .admin-topbar-avatar-btn:hover { background: #F1F5F9; }
        .admin-topbar-avatar {
            width: 28px; height: 28px; border-radius: 50%;
            background: var(--color-primary); color: #fff;
            font-size: 11px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; overflow: hidden;
        }
        .admin-topbar-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .admin-topbar-avatar-info { text-align: left; }
        .admin-topbar-avatar-name { font-size: 12px; font-weight: 600; color: var(--color-text); line-height: 1.2; }
        .admin-topbar-avatar-role { font-size: 10px; color: var(--color-muted); font-weight: 500; }

        .admin-dropdown {
            position: absolute; top: calc(100% + 8px); right: 0;
            min-width: 188px; background: var(--color-surface);
            border: 1px solid var(--color-border); border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.10); padding: 6px;
            display: none; z-index: 100;
        }
        .admin-dropdown.open { display: block; }
        .admin-dropdown-header {
            padding: 8px 12px 10px;
            border-bottom: 1px solid var(--color-border);
            margin-bottom: 4px;
        }
        .admin-dropdown-header-name { font-size: 13px; font-weight: 600; color: var(--color-text); }
        .admin-dropdown-header-email { font-size: 11px; color: var(--color-muted); margin-top: 1px; }
        .admin-dropdown-item {
            display: flex; align-items: center; gap: 8px;
            padding: 7px 12px; border-radius: 8px;
            font-size: 13px; font-weight: 500; color: var(--color-text);
            text-decoration: none; transition: background 0.1s;
            cursor: pointer;
        }
        .admin-dropdown-item:hover { background: #F1F5F9; }
        .admin-dropdown-item.danger { color: var(--color-danger); }
        .admin-dropdown-item.danger:hover { background: #FEF2F2; }
        .admin-dropdown-divider { height: 1px; background: var(--color-border); margin: 4px 0; }

        /* ═══════════════════════════════════════
           MAIN LAYOUT
        ═══════════════════════════════════════ */
        .admin-wrapper {
            margin-left: var(--admin-sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        .admin-content { flex: 1; }
        .admin-footer {
            padding: 14px 24px;
            border-top: 1px solid var(--color-border);
            display: flex; justify-content: space-between; align-items: center;
            font-size: 11.5px; color: var(--color-muted); font-weight: 500;
            background: var(--color-surface);
        }

        /* Overlay */
        .admin-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.4); z-index: 39;
        }
        .admin-overlay.open { display: block; }

        /* ═══════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 1024px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.open { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,0.3); }
            .admin-wrapper { margin-left: 0; }
            .admin-hamburger { display: flex; }
            .admin-topbar-search { display: none; }
        }
        @media (max-width: 640px) {
            .admin-topbar { padding: 0 16px; }
            .admin-topbar-avatar-info { display: none; }
            .admin-topbar-brand-badge { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ══════════════════════════════════════
     SIDEBAR
══════════════════════════════════════ --}}
<aside class="admin-sidebar" id="admin-sidebar">

    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-logo">
        <div class="admin-logo-mark">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
        </div>
        <div class="admin-logo-text">
            <span class="admin-logo-name">MathLingo AI</span>
            <span class="admin-logo-badge">Admin Panel</span>
        </div>
    </a>

    <nav class="admin-sidebar-nav">

        <span class="admin-nav-section">Utama</span>

        <a href="{{ route('admin.dashboard') }}"
           class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
        </a>

        <span class="admin-nav-section">Manajemen</span>

        <a href="{{ route('admin.users.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Manajemen Pengguna
        </a>

        <a href="{{ route('admin.courses.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
            Manajemen Kursus
        </a>

        <a href="{{ route('admin.lessons.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.lessons.*') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
            Manajemen Pelajaran
        </a>

        <a href="{{ route('admin.vocabulary.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.vocabulary.*') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="4 7 4 4 20 4 20 7"/>
                <line x1="9" y1="20" x2="15" y2="20"/>
                <line x1="12" y1="4" x2="12" y2="20"/>
            </svg>
            Manajemen Kosakata
        </a>
        <a href="{{ route('admin.quizzes.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.quizzes.*') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Manajemen Quiz
        </a>

        <span class="admin-nav-section">Fitur</span>

        <a href="{{ route('admin.achievements.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="6"/>
                <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
            </svg>
            Pencapaian
        </a>

        <a href="{{ route('admin.notifications.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            Notifikasi
        </a>

        <span class="admin-nav-section">Analitik</span>

        <a href="{{ route('admin.statistics.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"/>
                <line x1="12" y1="20" x2="12" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            Statistik
        </a>

        <span class="admin-nav-section">Sistem</span>

        <a href="{{ route('admin.settings.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
            Pengaturan
        </a>

        <a href="{{ route('admin.profile.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
            Profil Admin
        </a>

    </nav>

    <div class="admin-sidebar-footer">
        @auth
        <div class="admin-sidebar-user">
            <div class="admin-sidebar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="admin-sidebar-user-info">
                <div class="admin-sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="admin-sidebar-user-role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="admin-btn-logout">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Keluar
            </button>
        </form>
        @endauth
    </div>
</aside>

{{-- ══════════════════════════════════════
     MAIN WRAPPER
══════════════════════════════════════ --}}
<div class="admin-wrapper">

    {{-- TOPBAR --}}
    <header class="admin-topbar">
        <button class="admin-hamburger" id="admin-hamburger" aria-label="Buka navigasi">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>

        <div class="admin-topbar-brand">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
            MathLingo AI
            <span class="admin-topbar-brand-badge">Admin</span>
        </div>

        <div class="admin-topbar-search">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="search" placeholder="Cari pengguna, kursus, pelajaran...">
        </div>

        <div class="admin-topbar-actions">
            <button class="admin-icon-btn" aria-label="Notifikasi">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                <span class="admin-notif-badge"></span>
            </button>

            @auth
            <div style="position:relative;" id="admin-avatar-wrap">
                <button class="admin-topbar-avatar-btn" id="admin-avatar-btn" aria-label="Menu akun">
                    <div class="admin-topbar-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="admin-topbar-avatar-info">
                        <div class="admin-topbar-avatar-name">{{ explode(' ', auth()->user()->name)[0] }}</div>
                        <div class="admin-topbar-avatar-role">Administrator</div>
                    </div>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--color-muted)">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>

                <div class="admin-dropdown" id="admin-avatar-menu">
                    <div class="admin-dropdown-header">
                        <div class="admin-dropdown-header-name">{{ auth()->user()->name }}</div>
                        <div class="admin-dropdown-header-email">{{ auth()->user()->email }}</div>
                    </div>
                    <a href="{{ route('admin.profile.index') }}" class="admin-dropdown-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                        Profil Saya
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="admin-dropdown-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                        </svg>
                        Pengaturan
                    </a>
                    <div class="admin-dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="admin-dropdown-item danger"
                                style="width:100%;border:none;background:none;cursor:pointer;text-align:left;font-family:inherit;font-size:13px;font-weight:500;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="admin-content">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="admin-footer">
        <span>&copy; {{ date('Y') }} MathLingo AI — Admin Panel</span>
        <span>Phase 1 — v1.0.0</span>
    </footer>
</div>

{{-- Overlay mobile --}}
<div class="admin-overlay" id="admin-overlay"></div>

<script>
(function () {
    const sidebar   = document.getElementById('admin-sidebar');
    const overlay   = document.getElementById('admin-overlay');
    const hamburger = document.getElementById('admin-hamburger');
    const avatarBtn  = document.getElementById('admin-avatar-btn');
    const avatarMenu = document.getElementById('admin-avatar-menu');

    function openSidebar()  { sidebar.classList.add('open');    overlay.classList.add('open'); }
    function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('open'); }

    if (hamburger) hamburger.addEventListener('click', openSidebar);
    if (overlay)   overlay.addEventListener('click', closeSidebar);

    if (avatarBtn && avatarMenu) {
        avatarBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            avatarMenu.classList.toggle('open');
        });
        document.addEventListener('click', function () {
            avatarMenu.classList.remove('open');
        });
    }
})();
</script>

@stack('scripts')
</body>
</html>