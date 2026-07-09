<x-app-layout>

{{--
    ════════════════════════════════════════════════════════════
    BUG FIX — profile/index.blade.php
    ────────────────────────────────────────────────────────────
    BUG A ({{ $user->username }} tampil literal):
      Baris lama: @{{ $user->username }}
      @{{ ... }} adalah Blade escape syntax — output LITERAL {{ ... }}.
      Fix: gunakan {{ '@'.$user->username }} untuk karakter @ + render normal.

    BUG B (Avatar tidak muncul):
      Fix: tambah cache-buster ?v=timestamp agar browser tidak pakai cache lama.
      Tambah onerror fallback ke initials jika storage:link belum ada.

    BUG C (optional()->accessor tidak trigger):
      Fix: gunakan null-safe ?-> untuk semua accessor Model.

    BUG D (Named slot title untuk app layout):
      Fix: kirim <x-slot:title> alih-alih @section('page-title').
    ════════════════════════════════════════════════════════════
--}}

{{-- BUG FIX D: kirim title via named slot, bukan @section --}}
<x-slot:title>Profil Saya</x-slot:title>

<style>
    :root {
        --primary:   #2563EB;
        --p10:       #EFF6FF;
        --p20:       #DBEAFE;
        --secondary: #22C55E;
        --s10:       #F0FDF4;
        --accent:    #F59E0B;
        --a10:       #FFFBEB;
        --danger:    #EF4444;
        --bg:        #F8FAFC;
        --surface:   #FFFFFF;
        --border:    #E5E7EB;
        --text:      #1E293B;
        --muted:     #64748B;
        --r-card:    20px;
        --shadow:    0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 8px rgba(0,0,0,0.08),0 12px 32px rgba(0,0,0,0.08);
    }

    .profile-wrap {
        max-width: 960px;
        margin: 0 auto;
        padding: 32px 24px 48px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* ─── HERO CARD ─────────────────────────────────────── */
    .profile-hero {
        background: var(--primary);
        border-radius: var(--r-card);
        overflow: hidden;
        position: relative;
        box-shadow: var(--shadow-md);
    }
    .profile-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }
    .profile-hero::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 200px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }
    .profile-hero-inner {
        position: relative;
        z-index: 1;
        padding: 36px 40px;
        display: flex;
        align-items: center;
        gap: 28px;
        flex-wrap: wrap;
    }
    .profile-avatar-hero {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.3);
        object-fit: cover;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
        color: #fff;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        overflow: hidden;
    }
    .profile-avatar-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-hero-info { flex: 1; min-width: 200px; }
    .profile-hero-name {
        font-size: 24px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.4px;
        margin: 0 0 4px;
    }
    .profile-hero-username {
        font-size: 13px;
        font-weight: 500;
        color: rgba(255,255,255,0.65);
        margin-bottom: 12px;
    }
    .profile-hero-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 600;
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(4px);
    }
    .hero-stat-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
        flex-shrink: 0;
    }
    .hero-stat {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        min-width: 80px;
        text-align: center;
        backdrop-filter: blur(8px);
    }
    .hero-stat-value {
        font-size: 20px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.4px;
        line-height: 1;
    }
    .hero-stat-label {
        font-size: 10px;
        font-weight: 600;
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .btn-edit-profile {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        background: #fff;
        color: var(--primary);
        font-size: 13px;
        font-weight: 700;
        border-radius: 10px;
        text-decoration: none;
        transition: background 0.15s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-edit-profile:hover { background: #EFF6FF; }

    /* ─── CARDS ──────────────────────────────────────────── */
    .card {
        background: var(--surface);
        border-radius: var(--r-card);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
    }
    .card-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .card-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
    }
    .card-body { padding: 20px 24px; }

    /* ─── INFO ROWS ──────────────────────────────────────── */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .info-item-full { grid-column: 1 / -1; }
    .info-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
    }
    .info-value-muted {
        font-size: 13px;
        font-weight: 500;
        color: var(--muted);
        font-style: italic;
    }

    /* ─── STATS GRID ─────────────────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        padding: 20px 24px;
    }
    .stat-box {
        background: var(--bg);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        border: 1px solid var(--border);
    }
    .stat-box-value {
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.4px;
    }
    .stat-box-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* ─── XP BAR ─────────────────────────────────────────── */
    .xp-bar-wrap { padding: 16px 24px 20px; }
    .xp-bar-row {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
        margin-bottom: 6px;
    }
    .xp-bar-row span:last-child { color: var(--text); }
    .xp-bar {
        height: 8px;
        background: var(--border);
        border-radius: 99px;
        overflow: hidden;
    }
    .xp-bar-fill {
        height: 100%;
        background: var(--secondary);
        border-radius: 99px;
        transition: width 1s cubic-bezier(0.4,0,0.2,1);
    }

    /* ─── ACHIEVEMENT LIST ───────────────────────────────── */
    .achievement-list {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .achievement-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 24px;
        border-radius: 0;
        transition: background 0.12s;
    }
    .achievement-row:hover { background: var(--bg); }
    .achievement-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .achievement-info { flex: 1; min-width: 0; }
    .achievement-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }
    .achievement-time {
        font-size: 11px;
        font-weight: 500;
        color: var(--muted);
    }
    .achievement-rarity {
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 99px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* ─── TWO-COL LAYOUT ─────────────────────────────────── */
    .profile-two-col {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
    }
    .profile-col-left { display: flex; flex-direction: column; gap: 24px; }
    .profile-col-right { display: flex; flex-direction: column; gap: 24px; }

    /* ─── EMPTY STATE ────────────────────────────────────── */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 32px 24px;
        text-align: center;
    }
    .empty-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        background: var(--bg);
        display: flex; align-items: center; justify-content: center;
        color: var(--muted);
    }
    .empty-title { font-size: 13px; font-weight: 600; color: var(--text); }
    .empty-sub   { font-size: 12px; color: var(--muted); }

    /* ─── RESPONSIVE ─────────────────────────────────────── */
    @media (max-width: 768px) {
        .profile-two-col { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .info-grid  { grid-column-count: 1; grid-template-columns: 1fr; }
        .hero-stat-row { display: none; }
        .profile-hero-inner { padding: 24px 20px; }
    }
</style>

<div class="profile-wrap">

    {{-- ── HERO ──────────────────────────────────────────── --}}
    <div class="profile-hero">
        <div class="profile-hero-inner">

            {{-- Avatar --}}
            @php
                $avatarTs = $profile?->updated_at?->timestamp ?? 0;
            @endphp
            <div class="profile-avatar-hero" @if($profile && $profile->avatar_url) style="background:transparent;backdrop-filter:none;" @endif>
                {{-- BUG FIX B: cache-bust + onerror fallback --}}
                @if($profile && $profile->avatar_url)
                    <img src="{{ Storage::url($profile->avatar_url) }}?v={{ $avatarTs }}"
                         alt="Foto profil {{ $user->name }}"
                         onerror="this.remove();this.parentElement.style.background='';this.parentElement.style.backdropFilter='';this.parentElement.innerHTML='{{ strtoupper(substr($user->name, 0, 2)) }}';">
                @else
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                @endif
            </div>

            {{-- Info --}}
            <div class="profile-hero-info">
                <div class="profile-hero-name">{{ $user->name }}</div>
                <div class="profile-hero-username">
                    {{--
                        BUG FIX A: @{{ $user->username }} menghasilkan literal {{ $user->username }}.
                        Gunakan {{ '@'.$user->username }} untuk karakter @ + render variabel.
                    --}}
                    @if($user->username)
                        {{ '@'.$user->username }}
                    @else
                        <span style="opacity:0.5;">Belum mengatur username</span>
                    @endif
                </div>
                <div class="profile-hero-badges">
                    <span class="badge-pill">
                        {{-- BUG FIX C: null-safe ?-> untuk trigger accessor --}}
                        {{ $profile?->league_emoji ?? '🥉' }}
                        {{ $profile?->league_label ?? 'Bronze League' }}
                    </span>
                    <span class="badge-pill">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Level {{ $profile?->current_level ?? 1 }}
                    </span>
                    @if(($profile?->streak_days ?? 0) > 0)
                    <span class="badge-pill" style="background:rgba(245,158,11,0.2);border-color:rgba(245,158,11,0.3);">
                        🔥 {{ $profile->streak_days }} hari streak
                    </span>
                    @endif
                </div>
            </div>

            {{-- Stats --}}
            <div class="hero-stat-row">
                <div class="hero-stat">
                    <span class="hero-stat-value">{{ number_format($profile?->xp_total ?? 0) }}</span>
                    <span class="hero-stat-label">Total XP</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-value">{{ $totalLessons }}</span>
                    <span class="hero-stat-label">Pelajaran</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-value">{{ $achievements->count() }}</span>
                    <span class="hero-stat-label">Pencapaian</span>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="btn-edit-profile">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Profil
            </a>

        </div>

        {{-- XP Progress bar — realtime dari $profile->level_progress_percent --}}
        @if($profile)
        <div style="padding: 0 40px 28px; position:relative; z-index:1;">
            <div class="xp-bar-row" style="margin-bottom:6px;">
                <span style="color:rgba(255,255,255,0.6);font-size:12px;font-weight:600;">
                    Level {{ $profile->current_level }}
                </span>
                <span style="color:rgba(255,255,255,0.9);font-size:12px;font-weight:600;">
                    {{ number_format($profile->xp_total % ($profile->current_level * 100)) }} / {{ number_format($profile->current_level * 100) }} XP
                </span>
            </div>
            <div style="height:6px;background:rgba(255,255,255,0.15);border-radius:99px;overflow:hidden;">
                {{-- BUG FIX: level_progress_percent adalah accessor realtime dari model --}}
                <div style="height:100%;background:#34D399;border-radius:99px;width:{{ $profile->level_progress_percent }}%;transition:width 1s cubic-bezier(0.4,0,0.2,1);"></div>
            </div>
        </div>
        @endif
    </div>

    {{-- ── TWO COLUMN ─────────────────────────────────────── --}}
    <div class="profile-two-col">

        {{-- LEFT COLUMN --}}
        <div class="profile-col-left">

            {{-- Informasi Akun --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon" style="background:#EFF6FF;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                            </svg>
                        </div>
                        <span class="card-title">Informasi Akun</span>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                       style="font-size:12px;font-weight:600;color:var(--primary);text-decoration:none;">
                        Ubah →
                    </a>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nama Lengkap</span>
                            <span class="info-value">{{ $user->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Username</span>
                            <span class="{{ $user->username ? 'info-value' : 'info-value-muted' }}">
                                {{-- BUG FIX A: gunakan {{ '@'.$user->username }} bukan @{{ ... }} --}}
                                {{ $user->username ? '@'.$user->username : 'Belum diatur' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $user->email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nomor Telepon</span>
                            <span class="{{ $user->phone ? 'info-value' : 'info-value-muted' }}">
                                {{ $user->phone ?? 'Belum diatur' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Bergabung Sejak</span>
                            <span class="info-value">
                                {{ $user->created_at ? $user->created_at->isoFormat('D MMMM YYYY') : '-' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Asal Negara</span>
                            <span class="{{ $profile?->country ? 'info-value' : 'info-value-muted' }}">
                                {{ $profile?->country ?? 'Belum diatur' }}
                            </span>
                        </div>
                        @if($profile?->bio)
                        <div class="info-item info-item-full">
                            <span class="info-label">Bio</span>
                            <span class="info-value" style="font-weight:400;line-height:1.6;">
                                {{ $profile->bio }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Statistik Belajar — semua dari DB via $profile dan $totalLessons --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon" style="background:#F0FDF4;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                            </svg>
                        </div>
                        <span class="card-title">Statistik Belajar</span>
                    </div>
                </div>
                <div class="stats-grid">
                    <div class="stat-box">
                        <span class="stat-box-value" style="color:var(--secondary);">{{ number_format($profile?->xp_total ?? 0) }}</span>
                        <span class="stat-box-label">Total XP</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-box-value">{{ $profile?->current_level ?? 1 }}</span>
                        <span class="stat-box-label">Level</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-box-value" style="color:var(--accent);">{{ $profile?->streak_days ?? 0 }}</span>
                        <span class="stat-box-label">Hari Streak</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-box-value">{{ $totalLessons }}</span>
                        <span class="stat-box-label">Pelajaran</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-box-value" style="color:var(--danger);">
                            {{ $profile?->hearts ?? 5 }}/{{ $profile?->hearts_max ?? 5 }}
                        </span>
                        <span class="stat-box-label">Nyawa</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-box-value" style="color:var(--accent);">{{ $profile?->gems ?? 0 }}</span>
                        <span class="stat-box-label">Berlian</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="profile-col-right">

            {{-- Tujuan Belajar — dari accessor model, bukan hardcode --}}
            @if($profile)
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon" style="background:#FFFBEB;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/>
                                <line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/>
                                <line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/>
                            </svg>
                        </div>
                        <span class="card-title">Tujuan Belajar</span>
                    </div>
                </div>
                <div class="card-body">
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        <div style="padding:12px 14px;background:var(--p10);border-radius:12px;border:1px solid var(--p20);">
                            <div style="font-size:10px;font-weight:700;color:var(--primary);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:3px;">Jenjang Pendidikan</div>
                            <div style="font-size:13px;font-weight:600;color:var(--text);">
                                {{-- BUG FIX C: accessor educational_level_label dari model --}}
                                {{ $profile->educational_level_label }}
                            </div>
                        </div>
                        <div style="padding:12px 14px;background:var(--s10);border-radius:12px;border:1px solid #BBF7D0;">
                            <div style="font-size:10px;font-weight:700;color:var(--secondary);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:3px;">Target Belajar</div>
                            <div style="font-size:13px;font-weight:600;color:var(--text);">
                                {{-- BUG FIX C: accessor learning_goal_label dari model --}}
                                {{ $profile->learning_goal_label }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Pencapaian Terbaru — realtime dari $achievements (5 terakhir dari DB) --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon" style="background:#EFF6FF;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                            </svg>
                        </div>
                        <span class="card-title">Pencapaian Terbaru</span>
                    </div>
                    <a href="{{ route('achievements.index') }}"
                       style="font-size:12px;font-weight:600;color:var(--primary);text-decoration:none;">
                        Lihat semua →
                    </a>
                </div>

                @if($achievements->count() > 0)
                <div class="achievement-list" style="padding-bottom:8px;">
                    @foreach($achievements as $ach)
                    <div class="achievement-row">
                        <div class="achievement-icon" style="background:{{ $ach->color ?? '#EFF6FF' }}20;">
                            @if($ach->icon)
                                <span style="color:{{ $ach->color ?? '#2563EB' }};">{{ $ach->icon }}</span>
                            @else
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $ach->color ?? '#2563EB' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                                </svg>
                            @endif
                        </div>
                        <div class="achievement-info">
                            <div class="achievement-title">{{ $ach->title }}</div>
                            <div class="achievement-time">
                                {{ $ach->pivot->earned_at
                                    ? \Carbon\Carbon::parse($ach->pivot->earned_at)->diffForHumans()
                                    : 'Diperoleh' }}
                            </div>
                        </div>
                        <span class="achievement-rarity"
                              style="background:{{ $ach->color ?? '#EFF6FF' }}20;color:{{ $ach->color ?? '#2563EB' }};">
                            {{ ucfirst($ach->rarity ?? 'common') }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                        </svg>
                    </div>
                    <p class="empty-title">Belum ada pencapaian</p>
                    <p class="empty-sub">Selesaikan pelajaran untuk mendapatkan badge.</p>
                </div>
                @endif
            </div>

        </div>
    </div>

</div>

</x-app-layout>