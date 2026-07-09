<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? config('app.name', 'MathLingo AI') }}</title>

    {{-- Inter font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --color-primary:    #2563EB;
            --color-primary-10: #EFF6FF;
            --color-primary-20: #DBEAFE;
            --color-secondary:  #22C55E;
            --color-accent:     #F59E0B;
            --color-danger:     #EF4444;
            --color-bg:         #F8FAFC;
            --color-surface:    #FFFFFF;
            --color-border:     #E5E7EB;
            --color-text:       #1E293B;
            --color-muted:      #64748B;
            --sidebar-w:        280px;
            --topbar-h:         64px;
            --radius-card:      20px;
            --shadow-card:      0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.05);
            --shadow-card-hover:0 4px 8px rgba(0,0,0,0.08), 0 12px 32px rgba(0,0,0,0.08);
        }

        html, body {
            margin: 0; padding: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--color-bg);
            color: var(--color-text);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── SIDEBAR ─────────────────────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--color-surface);
            border-right: 1px solid var(--color-border);
            display: flex;
            flex-direction: column;
            z-index: 40;
            transition: transform 0.25s cubic-bezier(0.4,0,0.2,1);
        }
        .sidebar-logo {
            display: flex; align-items: center; gap: 12px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--color-border);
            text-decoration: none;
        }
        .sidebar-logo-mark {
            width: 36px; height: 36px; border-radius: 10px;
            background: var(--color-primary);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-logo-text { display: flex; flex-direction: column; gap: 1px; }
        .sidebar-logo-name {
            font-size: 15px; font-weight: 800; color: var(--color-text);
            letter-spacing: -0.3px; line-height: 1;
        }
        .sidebar-logo-sub { font-size: 11px; font-weight: 500; color: var(--color-muted); letter-spacing: 0.2px; }

        .sidebar-nav {
            flex: 1; padding: 16px 12px; overflow-y: auto;
            display: flex; flex-direction: column; gap: 2px;
        }
        .sidebar-section-label {
            font-size: 10px; font-weight: 700; color: var(--color-muted);
            letter-spacing: 0.08em; text-transform: uppercase; padding: 12px 8px 6px;
        }
        .sidebar-section-label:first-child { padding-top: 0; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 10px;
            font-size: 14px; font-weight: 500; color: var(--color-muted);
            text-decoration: none; transition: background 0.12s, color 0.12s;
        }
        .nav-item:hover { background: #F1F5F9; color: var(--color-text); }
        .nav-item.active { background: var(--color-primary-10); color: var(--color-primary); font-weight: 600; }
        .nav-item svg { flex-shrink: 0; }

        .sidebar-footer {
            padding: 12px; border-top: 1px solid var(--color-border);
            display: flex; flex-direction: column; gap: 4px;
        }
        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px; margin-bottom: 4px;
        }
        .sidebar-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--color-primary);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 12px; font-weight: 700;
            flex-shrink: 0; overflow: hidden;
        }
        .sidebar-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-name {
            font-size: 13px; font-weight: 600; color: var(--color-text);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .sidebar-user-meta { font-size: 11px; color: var(--color-muted); font-weight: 500; }
        .btn-logout {
            display: flex; align-items: center; gap: 8px; width: 100%;
            padding: 8px 12px; border-radius: 10px;
            font-size: 13px; font-weight: 500; color: var(--color-danger);
            background: transparent; border: none; cursor: pointer;
            text-align: left; transition: background 0.12s;
        }
        .btn-logout:hover { background: #FEF2F2; }

        /* ─── TOPBAR ──────────────────────────────────────────── */
        .topbar {
            position: sticky; top: 0;
            height: var(--topbar-h);
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            display: flex; align-items: center; padding: 0 28px; gap: 16px; z-index: 30;
        }
        .topbar-title { flex: 1; font-size: 16px; font-weight: 700; color: var(--color-text); }
        .hamburger-btn {
            display: none; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 9px;
            border: 1px solid var(--color-border); background: transparent;
            cursor: pointer; color: var(--color-muted); transition: background 0.12s;
        }
        .hamburger-btn:hover { background: #F1F5F9; color: var(--color-text); }
        .topbar-search {
            display: flex; align-items: center; gap: 8px;
            background: var(--color-bg); border: 1px solid var(--color-border);
            border-radius: 10px; padding: 7px 12px; min-width: 200px; color: var(--color-muted);
        }
        .topbar-search input {
            border: none; background: transparent; font-size: 13px;
            color: var(--color-text); font-family: inherit; outline: none; width: 100%;
        }
        .topbar-search input::placeholder { color: var(--color-muted); }
        .topbar-icon-btn {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 9px;
            border: 1px solid var(--color-border); background: transparent;
            cursor: pointer; color: var(--color-muted); transition: background 0.12s, color 0.12s;
        }
        .topbar-icon-btn:hover { background: #F1F5F9; color: var(--color-text); }
        .topbar-avatar-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 5px 10px 5px 5px; border-radius: 10px;
            border: 1px solid var(--color-border); background: transparent;
            cursor: pointer; transition: background 0.12s;
        }
        .topbar-avatar-btn:hover { background: #F1F5F9; }
        .topbar-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: var(--color-primary); color: #fff;
            font-size: 11px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; overflow: hidden;
        }
        .topbar-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .topbar-avatar-name { font-size: 13px; font-weight: 600; color: var(--color-text); }
        .dropdown-menu {
            position: absolute; top: calc(100% + 8px); right: 0;
            min-width: 180px; background: var(--color-surface);
            border: 1px solid var(--color-border); border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.10); padding: 6px;
            display: none; z-index: 100;
        }
        .dropdown-menu.open { display: block; }
        .dropdown-item {
            display: block; padding: 8px 12px; border-radius: 8px;
            font-size: 13px; font-weight: 500; color: var(--color-text);
            text-decoration: none; transition: background 0.1s;
        }
        .dropdown-item:hover { background: #F1F5F9; }
        .dropdown-item.danger { color: var(--color-danger); }
        .dropdown-item.danger:hover { background: #FEF2F2; }
        .dropdown-divider { height: 1px; background: var(--color-border); margin: 4px 0; }

        /* ─── LAYOUT ──────────────────────────────────────────── */
        .main-wrapper { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .main-content { flex: 1; padding: 0; }
        .site-footer {
            padding: 16px 28px; border-top: 1px solid var(--color-border);
            display: flex; justify-content: space-between;
            font-size: 12px; color: var(--color-muted); font-weight: 500;
        }
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.3); z-index: 39;
        }
        .sidebar-overlay.open { display: block; }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .hamburger-btn { display: flex; }
            .topbar-search { display: none; }
        }
    </style>
</head>
<body>

{{-- ═══════════════════════════════════════════════
     SIDEBAR
═══════════════════════════════════════════════ --}}
<aside class="sidebar" id="sidebar">

    <a href="{{ route('dashboard') }}" class="sidebar-logo">
        <div class="sidebar-logo-mark">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
        </div>
        <div class="sidebar-logo-text">
            <span class="sidebar-logo-name">MathLingo AI</span>
            <span class="sidebar-logo-sub">Learning Platform</span>
        </div>
    </a>

    <nav class="sidebar-nav">
        <span class="sidebar-section-label">Main</span>

        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            Beranda
        </a>

        <a href="{{ route('courses.index') }}" class="nav-item {{ request()->routeIs('courses.*') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
            Kursus
        </a>

        <a href="{{ route('quiz.index') }}" class="nav-item {{ request()->routeIs('quiz.*') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="M9.09 9a3 3 0 1 1 5.82 1c0 2-3 3-3 3"/>
                <path d="M12 17h.01"/>
            </svg>
            Quiz
        </a>

        <a href="{{ route('ai-tutor.index') }}" class="nav-item {{ request()->routeIs('ai-tutor.*') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2a10 10 0 1 0 10 10"/>
                <path d="M12 8v4l3 3"/>
                <circle cx="18" cy="5" r="3"/>
                <path d="M18 2v6M15 5h6"/>
            </svg>
            AI Tutor
        </a>

        <a href="{{ route('achievements.index') }}" class="nav-item {{ request()->routeIs('achievements.*') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="6"/>
                <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
            </svg>
            Pencapaian
        </a>

        <a href="{{ route('certificates.index') }}" class="nav-item {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 21H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9l5 5v11a2 2 0 0 1-2 2z"/>
                <circle cx="10" cy="13" r="2"/>
                <path d="M14 21v-3a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v3"/>
            </svg>
            Sertifikat
        </a>

        <a href="{{ route('learning-report.index') }}" class="nav-item {{ request()->routeIs('learning-report.*') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 3v18h18"/>
                <path d="M18.7 8l-5.1 5.1-2.8-2.8L7 14"/>
            </svg>
            Learning Report
        </a>

        <span class="sidebar-section-label">Account</span>

        <a href="{{ route('profile.index') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
            Profil
        </a>
    </nav>

    <div class="sidebar-footer">
        @auth
        @php
            $authUser    = auth()->user();
            $authProfile = $authUser->profile;
            $avatarTs    = $authProfile?->updated_at?->timestamp ?? 0;
        @endphp
        <div class="sidebar-user">
            <div class="sidebar-avatar" @if($authProfile && $authProfile->avatar_url) style="background:transparent;" @endif>
                {{--
                    BUG FIX B: cache-bust dengan timestamp, onerror fallback ke initials.
                    Jika storage:link belum ada, img gagal load dan onerror menampilkan initials.
                --}}
                @if($authProfile && $authProfile->avatar_url)
                    <img src="{{ Storage::url($authProfile->avatar_url) }}?v={{ $avatarTs }}"
                         alt="{{ $authUser->name }}"
                         style="width:100%;height:100%;object-fit:cover;display:block;"
                         onerror="this.remove();this.parentElement.style.background='';this.parentElement.innerHTML='{{ strtoupper(substr($authUser->name, 0, 2)) }}';">
                @else
                    {{ strtoupper(substr($authUser->name, 0, 2)) }}
                @endif
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ $authUser->name }}</div>
                <div class="sidebar-user-meta">
                    {{-- BUG FIX C: null-safe ?-> bukan optional() agar accessor terpanggil --}}
                    Level {{ $authProfile?->current_level ?? 1 }}
                    &middot; {{ number_format($authProfile?->xp_total ?? 0) }} XP
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

{{-- ═══════════════════════════════════════════════
     MAIN WRAPPER
═══════════════════════════════════════════════ --}}
<div class="main-wrapper">

    <header class="topbar">
        <button class="hamburger-btn" id="hamburger-btn" aria-label="Open navigation">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>

        {{-- BUG FIX A: gunakan named slot $title --}}
        <div class="topbar-title">&nbsp;</div>

        <div class="topbar-search">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="search" placeholder="Search courses, topics...">
        </div>

        @auth
        <div style="position:relative;" id="notif-dropdown-wrap">
            <button class="topbar-icon-btn" id="notif-btn" aria-label="Notifications" style="position:relative;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                <span id="notif-badge" style="display:none;position:absolute;top:2px;right:2px;background:#EF4444;color:#fff;font-size:10px;font-weight:700;line-height:1;min-width:16px;height:16px;border-radius:99px;align-items:center;justify-content:center;padding:0 3px;"></span>
            </button>
            <div id="notif-panel" style="display:none;position:absolute;right:0;top:calc(100% + 10px);width:340px;max-height:420px;overflow-y:auto;background:#fff;border:1px solid var(--color-border);border-radius:14px;box-shadow:0 12px 32px rgba(15,23,42,0.14);z-index:60;">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border-bottom:1px solid var(--color-border);">
                    <span style="font-size:13.5px;font-weight:700;color:var(--color-text);">Notifikasi</span>
                    <button id="notif-mark-all" style="border:none;background:none;font-size:12px;font-weight:600;color:var(--color-primary);cursor:pointer;font-family:inherit;">Tandai semua dibaca</button>
                </div>
                <div id="notif-list"></div>
                <div id="notif-empty" style="display:none;padding:28px 16px;text-align:center;font-size:12.5px;color:var(--color-muted);">Belum ada notifikasi.</div>
            </div>
        </div>
        @endauth

        @auth
        @php
            $authUser    = auth()->user();
            $authProfile = $authUser->profile;
            $avatarTs    = $authProfile?->updated_at?->timestamp ?? 0;
        @endphp
        <div style="position:relative;" id="avatar-dropdown-wrap">
            <button class="topbar-avatar-btn" id="avatar-btn" aria-label="Account menu">
                <div class="topbar-avatar" @if($authProfile && $authProfile->avatar_url) style="background:transparent;" @endif>
                    @if($authProfile && $authProfile->avatar_url)
                        <img src="{{ Storage::url($authProfile->avatar_url) }}?v={{ $avatarTs }}"
                             alt="{{ $authUser->name }}"
                             style="width:100%;height:100%;object-fit:cover;display:block;"
                             onerror="this.remove();this.parentElement.style.background='';this.parentElement.innerHTML='{{ strtoupper(substr($authUser->name ?? 'U', 0, 2)) }}';">
                    @else
                        {{ strtoupper(substr($authUser->name ?? 'U', 0, 2)) }}
                    @endif
                </div>
                <span class="topbar-avatar-name">{{ explode(' ', $authUser->name)[0] }}</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--color-muted)">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </button>
            <div class="dropdown-menu" id="avatar-menu">
                <a href="{{ route('profile.index') }}" class="dropdown-item">My Profile</a>
                <a href="{{ route('profile.edit') }}" class="dropdown-item">Settings</a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item danger" style="width:100%;border:none;background:none;cursor:pointer;text-align:left;font-family:inherit;">
                        Sign out
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </header>

    <main class="main-content">
        {{ $slot }}
    </main>

    <footer class="site-footer">
        <span>&copy; {{ date('Y') }} MathLingo AI &mdash; Mathematics English Learning Platform</span>
        <span>v1.0.0</span>
    </footer>
</div>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<script>
(function () {
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebar-overlay');
    const hamburger = document.getElementById('hamburger-btn');
    const avatarBtn  = document.getElementById('avatar-btn');
    const avatarMenu = document.getElementById('avatar-menu');

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

    @auth
    // ── Notifikasi realtime (polling) ───────────────────────────────────
    const notifBtn    = document.getElementById('notif-btn');
    const notifPanel  = document.getElementById('notif-panel');
    const notifBadge  = document.getElementById('notif-badge');
    const notifList   = document.getElementById('notif-list');
    const notifEmpty  = document.getElementById('notif-empty');
    const notifMarkAll = document.getElementById('notif-mark-all');

    const notifIcons = {
        book: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
        achievement: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>',
        megaphone: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l18-5v12L3 13v-2z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>',
        bell: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
    };

    function renderNotifications(data) {
        const unread = data.unread_count || 0;

        if (notifBadge) {
            if (unread > 0) {
                notifBadge.style.display = 'flex';
                notifBadge.textContent = unread > 9 ? '9+' : unread;
            } else {
                notifBadge.style.display = 'none';
            }
        }

        if (!notifList) return;

        const items = data.notifications || [];
        notifList.innerHTML = '';

        if (items.length === 0) {
            if (notifEmpty) notifEmpty.style.display = 'block';
            return;
        }
        if (notifEmpty) notifEmpty.style.display = 'none';

        items.forEach(function (n) {
            const row = document.createElement('a');
            row.href = n.url || '#';
            row.style.cssText = 'display:flex;gap:10px;padding:12px 16px;border-bottom:1px solid var(--color-border);text-decoration:none;' + (n.is_read ? '' : 'background:var(--color-primary-10);');
            row.innerHTML =
                '<div style="width:32px;height:32px;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:' + n.color + '20;color:' + n.color + ';">' +
                    (notifIcons[n.icon] || notifIcons.bell) +
                '</div>' +
                '<div style="min-width:0;">' +
                    '<div style="font-size:12.5px;font-weight:700;color:var(--color-text);">' + n.title + '</div>' +
                    '<div style="font-size:12px;color:var(--color-muted);margin-top:1px;line-height:1.4;">' + n.message + '</div>' +
                    '<div style="font-size:11px;color:var(--color-muted);margin-top:4px;">' + n.created_at + '</div>' +
                '</div>';
            row.addEventListener('click', function () {
                if (!n.is_read) {
                    fetch('/notifications/' + n.id + '/read', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    });
                }
            });
            notifList.appendChild(row);
        });
    }

    function fetchNotifications() {
        fetch('{{ route("notifications.latest") }}', { headers: { 'Accept': 'application/json' } })
            .then(function (res) { return res.ok ? res.json() : null; })
            .then(function (data) { if (data) renderNotifications(data); })
            .catch(function () {});
    }

    if (notifBtn && notifPanel) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = notifPanel.style.display === 'block';
            notifPanel.style.display = isOpen ? 'none' : 'block';
            if (!isOpen) fetchNotifications();
        });
        document.addEventListener('click', function () {
            notifPanel.style.display = 'none';
        });
        notifPanel.addEventListener('click', function (e) { e.stopPropagation(); });
    }

    if (notifMarkAll) {
        notifMarkAll.addEventListener('click', function () {
            fetch('{{ route("notifications.read-all") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
            }).then(fetchNotifications);
        });
    }

    // Polling setiap 20 detik supaya perubahan dari Admin langsung terlihat.
    fetchNotifications();
    setInterval(fetchNotifications, 20000);
    @endauth
})();
</script>

@stack('scripts')

</body>
</html>