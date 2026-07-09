<x-app-layout>

@section('page-title', 'Pencapaian')

<style>
/* ═══════════════════════════════════════════════════════════════════════════
   DESIGN TOKENS
═══════════════════════════════════════════════════════════════════════════ */
:root {
    --primary:    #2563EB;
    --p10:        #EFF6FF;
    --p20:        #DBEAFE;
    --success:    #10B981;
    --s10:        #ECFDF5;
    --warning:    #F59E0B;
    --w10:        #FFFBEB;
    --danger:     #EF4444;
    --d10:        #FEF2F2;
    --purple:     #8B5CF6;
    --pur10:      #F5F3FF;
    --bg:         #F8FAFC;
    --surface:    #FFFFFF;
    --border:     #E5E7EB;
    --text:       #111827;
    --muted:      #6B7280;
    --r-card:     20px;
    --shadow:     0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.05);
    --shadow-md:  0 4px 8px rgba(0,0,0,0.08), 0 12px 32px rgba(0,0,0,0.08);
}

/* ═══════════════════════════════════════════════════════════════════════════
   HERO HEADER
═══════════════════════════════════════════════════════════════════════════ */
.ach-hero {
    background: var(--primary);
    border-radius: var(--r-card);
    padding: 36px 40px 28px;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
}
.ach-hero::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    pointer-events: none;
}
.ach-hero::after {
    content: '';
    position: absolute;
    bottom: -60px; left: 240px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    pointer-events: none;
}
.ach-hero-inner {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 32px;
    align-items: center;
    position: relative;
    z-index: 1;
}
.ach-hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 600;
    color: rgba(255,255,255,0.65);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 10px;
}
.ach-hero-title {
    font-size: 30px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.5px;
    line-height: 1.15;
    margin: 0 0 8px;
}
.ach-hero-sub {
    font-size: 14px;
    color: rgba(255,255,255,0.72);
    line-height: 1.6;
    margin-bottom: 24px;
    max-width: 420px;
}

/* Progress ring di hero */
.hero-progress-ring-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
.hero-ring-svg { transform: rotate(-90deg); }
.hero-ring-track { fill: none; stroke: rgba(255,255,255,0.15); }
.hero-ring-fill {
    fill: none;
    stroke: #34D399;
    stroke-linecap: round;
    transition: stroke-dashoffset 1.2s cubic-bezier(0.4,0,0.2,1);
}
.hero-ring-center {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}
.hero-ring-pct {
    font-size: 24px;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    letter-spacing: -0.5px;
}
.hero-ring-lbl {
    font-size: 10px;
    font-weight: 600;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.hero-ring-outer {
    position: relative;
    width: 100px;
    height: 100px;
}
.hero-ring-name {
    font-size: 12px;
    font-weight: 600;
    color: rgba(255,255,255,0.75);
    text-align: center;
}

/* Mini stat badges in hero */
.hero-stat-row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
    margin-top: 4px;
}
.hero-stat-badge {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 12px;
    padding: 12px 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
    min-width: 80px;
    text-align: center;
    backdrop-filter: blur(8px);
}
.hero-stat-badge-val {
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    letter-spacing: -0.5px;
}
.hero-stat-badge-lbl {
    font-size: 10px;
    font-weight: 600;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    white-space: nowrap;
}

/* ═══════════════════════════════════════════════════════════════════════════
   STAT CARDS (baris kedua)
═══════════════════════════════════════════════════════════════════════════ */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 14px;
    margin-bottom: 28px;
}
.stat-card {
    background: var(--surface);
    border-radius: 16px;
    padding: 18px 16px;
    box-shadow: var(--shadow);
    display: flex;
    flex-direction: column;
    gap: 6px;
    transition: box-shadow 0.2s, transform 0.2s;
}
.stat-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}
.stat-card-icon-wrap {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 2px;
}
.stat-card-val {
    font-size: 22px;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.5px;
    line-height: 1;
}
.stat-card-lbl {
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

/* ═══════════════════════════════════════════════════════════════════════════
   FILTER BAR
═══════════════════════════════════════════════════════════════════════════ */
.filter-bar {
    background: var(--surface);
    border-radius: var(--r-card);
    box-shadow: var(--shadow);
    padding: 18px 24px;
    margin-bottom: 24px;
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}
.filter-search {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #F8FAFC;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 9px 14px;
    flex: 1;
    min-width: 200px;
}
.filter-search input {
    border: none;
    background: transparent;
    outline: none;
    font-size: 14px;
    font-family: inherit;
    color: var(--text);
    width: 100%;
}
.filter-search input::placeholder { color: var(--muted); }
.filter-select {
    appearance: none;
    background: #F8FAFC url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 12px center;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 9px 36px 9px 14px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text);
    cursor: pointer;
    outline: none;
    min-width: 140px;
    transition: border-color 0.15s;
}
.filter-select:focus { border-color: var(--primary); }
.filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: background 0.15s;
}
.filter-btn:hover { background: #1D4ED8; }
.filter-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 16px;
    background: #F8FAFC;
    color: var(--muted);
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    font-family: inherit;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.15s;
}
.filter-btn-ghost:hover { background: #F1F5F9; color: var(--text); }

/* ═══════════════════════════════════════════════════════════════════════════
   ACHIEVEMENT GRID
═══════════════════════════════════════════════════════════════════════════ */
.ach-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}
.ach-section-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text);
}
.ach-section-count {
    font-size: 13px;
    color: var(--muted);
    font-weight: 500;
}
.ach-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

/* ── Achievement Card ─────────────────────────────────────────────────── */
.ach-card {
    background: var(--surface);
    border-radius: var(--r-card);
    box-shadow: var(--shadow);
    overflow: hidden;
    position: relative;
    transition: box-shadow 0.25s, transform 0.25s;
    cursor: pointer;
    text-decoration: none;
    display: block;
    color: inherit;
}
.ach-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-4px);
}
.ach-card.locked { opacity: 0.72; }
.ach-card.locked:hover { opacity: 0.9; }

.ach-card-top {
    height: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.ach-card-icon {
    font-size: 38px;
    line-height: 1;
    position: relative;
    z-index: 1;
    filter: drop-shadow(0 2px 8px rgba(0,0,0,0.15));
}
.ach-card-rarity-badge {
    position: absolute;
    top: 10px;
    right: 12px;
    font-size: 10px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 99px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    z-index: 2;
}
.ach-card-unlock-badge {
    position: absolute;
    top: 10px;
    left: 12px;
    background: rgba(255,255,255,0.85);
    border-radius: 8px;
    padding: 3px 7px;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 4px;
}
.ach-card-unlock-badge svg { color: #10B981; }
.ach-card-unlock-badge span {
    font-size: 10px;
    font-weight: 700;
    color: #10B981;
}

/* Locked overlay */
.ach-card-locked-overlay {
    position: absolute;
    inset: 0;
    background: rgba(17,24,39,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 5;
    backdrop-filter: blur(1px);
    border-radius: var(--r-card);
    opacity: 0;
    transition: opacity 0.2s;
}
.ach-card.locked:hover .ach-card-locked-overlay { opacity: 1; }
.ach-card-locked-overlay span {
    font-size: 12px;
    font-weight: 700;
    color: #fff;
    background: rgba(0,0,0,0.5);
    border-radius: 8px;
    padding: 6px 14px;
}

.ach-card-body { padding: 16px 18px 18px; }
.ach-card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}
.ach-card-cat {
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.ach-card-xp {
    font-size: 12px;
    font-weight: 700;
    color: var(--warning);
    background: var(--w10);
    padding: 2px 8px;
    border-radius: 99px;
    display: flex;
    align-items: center;
    gap: 3px;
}
.ach-card-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 5px;
    line-height: 1.3;
}
.ach-card-desc {
    font-size: 12.5px;
    color: var(--muted);
    line-height: 1.55;
    margin-bottom: 14px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.ach-card-req {
    font-size: 11px;
    color: var(--muted);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.ach-card-req strong { color: var(--text); }

/* Progress bar */
.ach-progress-wrap { margin-bottom: 8px; }
.ach-progress-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 5px;
}
.ach-progress-label { font-size: 11px; font-weight: 600; color: var(--muted); }
.ach-progress-pct { font-size: 11px; font-weight: 700; color: var(--text); }
.ach-progress-bar {
    height: 6px;
    background: #F1F5F9;
    border-radius: 99px;
    overflow: hidden;
}
.ach-progress-fill {
    height: 100%;
    border-radius: 99px;
    transition: width 0.8s cubic-bezier(0.4,0,0.2,1);
}

/* Unlock date */
.ach-card-footer {
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: var(--success);
    font-weight: 600;
}
.ach-card-footer-locked {
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
}

/* ═══════════════════════════════════════════════════════════════════════════
   EMPTY STATE
═══════════════════════════════════════════════════════════════════════════ */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 24px;
    background: var(--surface);
    border-radius: var(--r-card);
    box-shadow: var(--shadow);
}
.empty-icon {
    width: 64px; height: 64px;
    border-radius: 16px;
    background: #F8FAFC;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    color: var(--muted);
}
.empty-title { font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
.empty-sub   { font-size: 13px; color: var(--muted); margin-bottom: 20px; }

/* ═══════════════════════════════════════════════════════════════════════════
   PAGINATION
═══════════════════════════════════════════════════════════════════════════ */
.pagination-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
}
.pagination-wrap .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px; height: 36px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
    background: var(--surface);
    border: 1px solid var(--border);
    text-decoration: none;
    transition: all 0.15s;
}
.pagination-wrap .page-link:hover { background: var(--p10); color: var(--primary); border-color: var(--p20); }
.pagination-wrap .page-link.active { background: var(--primary); color: #fff; border-color: var(--primary); }
.pagination-wrap .page-dots { color: var(--muted); font-size: 14px; padding: 0 4px; }

/* ═══════════════════════════════════════════════════════════════════════════
   FLASH MESSAGE
═══════════════════════════════════════════════════════════════════════════ */
.flash-success {
    background: var(--s10);
    border: 1px solid #A7F3D0;
    border-radius: 12px;
    padding: 12px 18px;
    font-size: 14px;
    font-weight: 500;
    color: #065F46;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ═══════════════════════════════════════════════════════════════════════════
   ADMIN BUTTON
═══════════════════════════════════════════════════════════════════════════ */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    background: var(--primary);
    color: #fff;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.15s;
}
.btn-primary:hover { background: #1D4ED8; }

/* ═══════════════════════════════════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════════════════════════════════ */
@media (max-width: 1100px) {
    .stat-grid { grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 768px) {
    .ach-hero { padding: 24px 22px 20px; }
    .ach-hero-inner { grid-template-columns: 1fr; gap: 20px; }
    .hero-progress-ring-wrap { display: none; }
    .ach-hero-title { font-size: 22px; }
    .stat-grid { grid-template-columns: repeat(2, 1fr); }
    .filter-bar { flex-direction: column; align-items: stretch; }
    .filter-search { min-width: unset; }
    .ach-grid { grid-template-columns: 1fr; }
}

/* ── Animasi fade masuk ────────────────────────────────────────────────── */
.fade-in { animation: fadeIn 0.4s ease both; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.d1 { animation-delay: 0.05s; }
.d2 { animation-delay: 0.10s; }
.d3 { animation-delay: 0.15s; }
.d4 { animation-delay: 0.20s; }
</style>

<div style="padding: 28px 32px;">

    {{-- Flash message --}}
    @if(session('success'))
    <div class="flash-success fade-in">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════════
         HERO HEADER
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="ach-hero fade-in d1">
        <div class="ach-hero-inner">
            <div>
                <div class="ach-hero-tag">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                    </svg>
                    Sistem Pencapaian
                </div>
                <h1 class="ach-hero-title">Pencapaian Kamu 🏆</h1>
                <p class="ach-hero-sub">
                    Raih achievement untuk membuktikan dedikasi belajarmu dan kumpulkan XP sebanyak mungkin.
                    Setiap pencapaian adalah bukti kerja kerasmu!
                </p>

                <div class="hero-stat-row">
                    <div class="hero-stat-badge">
                        <div class="hero-stat-badge-val">{{ $unlockedCount }}</div>
                        <div class="hero-stat-badge-lbl">Terbuka</div>
                    </div>
                    <div class="hero-stat-badge">
                        <div class="hero-stat-badge-val">{{ $lockedCount }}</div>
                        <div class="hero-stat-badge-lbl">Terkunci</div>
                    </div>
                    <div class="hero-stat-badge">
                        <div class="hero-stat-badge-val">{{ number_format($xpCollected) }}</div>
                        <div class="hero-stat-badge-lbl">XP Dikumpul</div>
                    </div>
                    <div class="hero-stat-badge">
                        <div class="hero-stat-badge-val">{{ $profile?->streak_days ?? 0 }}</div>
                        <div class="hero-stat-badge-lbl">Streak Hari</div>
                    </div>
                    <div class="hero-stat-badge">
                        <div class="hero-stat-badge-val">{{ $learningRank }}</div>
                        <div class="hero-stat-badge-lbl">Peringkat</div>
                    </div>
                </div>
            </div>

            {{-- Progress ring --}}
            <div class="hero-progress-ring-wrap">
                @php
                    $radius = 42;
                    $circumference = 2 * pi() * $radius;
                    $offset = $circumference - ($overallPct / 100) * $circumference;
                @endphp
                <div class="hero-ring-outer">
                    <svg class="hero-ring-svg" width="100" height="100" viewBox="0 0 100 100">
                        <circle class="hero-ring-track" cx="50" cy="50" r="{{ $radius }}" stroke-width="8"/>
                        <circle
                            class="hero-ring-fill"
                            cx="50" cy="50" r="{{ $radius }}"
                            stroke-width="8"
                            stroke-dasharray="{{ $circumference }}"
                            stroke-dashoffset="{{ $offset }}"
                            id="hero-ring-fill"
                        />
                    </svg>
                    <div class="hero-ring-center">
                        <div class="hero-ring-pct">{{ $overallPct }}%</div>
                        <div class="hero-ring-lbl">Selesai</div>
                    </div>
                </div>
                <div class="hero-ring-name">Penyelesaian<br>Keseluruhan</div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         STAT CARDS
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="stat-grid fade-in d2">
        {{-- Terbuka --}}
        <div class="stat-card">
            <div class="stat-card-icon-wrap" style="background:#ECFDF5;">🔓</div>
            <div class="stat-card-val">{{ $unlockedCount }}</div>
            <div class="stat-card-lbl">Terbuka</div>
        </div>
        {{-- Terkunci --}}
        <div class="stat-card">
            <div class="stat-card-icon-wrap" style="background:#F8FAFC;">🔒</div>
            <div class="stat-card-val">{{ $lockedCount }}</div>
            <div class="stat-card-lbl">Terkunci</div>
        </div>
        {{-- Legendary --}}
        <div class="stat-card">
            <div class="stat-card-icon-wrap" style="background:#FFFBEB;">👑</div>
            <div class="stat-card-val">{{ $rarityUnlocked->get('legendary', 0) }}/{{ $rarityStats->get('legendary', 0) }}</div>
            <div class="stat-card-lbl">Legendaris</div>
        </div>
        {{-- Epic --}}
        <div class="stat-card">
            <div class="stat-card-icon-wrap" style="background:#F5F3FF;">⚡</div>
            <div class="stat-card-val">{{ $rarityUnlocked->get('epic', 0) }}/{{ $rarityStats->get('epic', 0) }}</div>
            <div class="stat-card-lbl">Epik</div>
        </div>
        {{-- Rare --}}
        <div class="stat-card">
            <div class="stat-card-icon-wrap" style="background:#EFF6FF;">💎</div>
            <div class="stat-card-val">{{ $rarityUnlocked->get('rare', 0) }}/{{ $rarityStats->get('rare', 0) }}</div>
            <div class="stat-card-lbl">Langka</div>
        </div>
        {{-- Common --}}
        <div class="stat-card">
            <div class="stat-card-icon-wrap" style="background:#ECFDF5;">⭐</div>
            <div class="stat-card-val">{{ $rarityUnlocked->get('common', 0) }}/{{ $rarityStats->get('common', 0) }}</div>
            <div class="stat-card-lbl">Umum</div>
        </div>
        {{-- Total XP --}}
        <div class="stat-card">
            <div class="stat-card-icon-wrap" style="background:#FFFBEB;">🏅</div>
            <div class="stat-card-val">{{ number_format($xpCollected) }}</div>
            <div class="stat-card-lbl">Total XP</div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         FILTER BAR
    ═══════════════════════════════════════════════════════════════════════ --}}
    <form method="GET" action="{{ route('achievements.index') }}">
    <div class="filter-bar fade-in d3">
        <div class="filter-search">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input
                type="text"
                name="search"
                placeholder="Cari achievement..."
                value="{{ request('search') }}"
            >
        </div>

        <select name="category" class="filter-select">
            <option value="">Semua Kategori</option>
            @foreach(\App\Models\Achievement::categories() as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <select name="rarity" class="filter-select">
            <option value="">Semua Rarity</option>
            <option value="legendary" {{ request('rarity') === 'legendary' ? 'selected' : '' }}>👑 Legendaris</option>
            <option value="epic"      {{ request('rarity') === 'epic'      ? 'selected' : '' }}>⚡ Epik</option>
            <option value="rare"      {{ request('rarity') === 'rare'      ? 'selected' : '' }}>💎 Langka</option>
            <option value="common"    {{ request('rarity') === 'common'    ? 'selected' : '' }}>⭐ Umum</option>
        </select>

        <select name="status" class="filter-select">
            <option value="">Semua Status</option>
            <option value="unlocked" {{ request('status') === 'unlocked' ? 'selected' : '' }}>🔓 Sudah Dibuka</option>
            <option value="locked"   {{ request('status') === 'locked'   ? 'selected' : '' }}>🔒 Terkunci</option>
        </select>

        <select name="sort" class="filter-select">
            <option value="newest"  {{ request('sort', 'newest') === 'newest'  ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest"  {{ request('sort') === 'oldest'            ? 'selected' : '' }}>Terlama</option>
            <option value="xp_high" {{ request('sort') === 'xp_high'          ? 'selected' : '' }}>XP Tertinggi</option>
            <option value="xp_low"  {{ request('sort') === 'xp_low'           ? 'selected' : '' }}>XP Terendah</option>
            <option value="az"      {{ request('sort') === 'az'               ? 'selected' : '' }}>A–Z</option>
            <option value="za"      {{ request('sort') === 'za'               ? 'selected' : '' }}>Z–A</option>
        </select>

        <button type="submit" class="filter-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            </svg>
            Filter
        </button>

        @if(request()->hasAny(['search','category','rarity','status','sort']))
        <a href="{{ route('achievements.index') }}" class="filter-btn-ghost">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
            Reset
        </a>
        @endif
    </div>
    </form>

    {{-- ═══════════════════════════════════════════════════════════════════
         ACHIEVEMENT GRID
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="fade-in d4">
        <div class="ach-section-header">
            <div class="ach-section-title">Semua Pencapaian</div>
            <div class="ach-section-count">{{ $achievements->total() }} pencapaian ditemukan</div>
        </div>

        <div class="ach-grid">
            @forelse($achievements as $ach)
            @php
                $isUnlocked  = $earnedIds->has($ach->id);
                $earnedAt    = $earnedIds->get($ach->id);
                // Progress dummy (real hanya di show page; di index kita hanya tahu terkunci/tidak)
                $pct         = $isUnlocked ? 100 : 0;
            @endphp

            <a href="{{ route('achievements.show', $ach) }}"
               class="ach-card {{ $isUnlocked ? 'unlocked' : 'locked' }}">

                {{-- Locked overlay on hover --}}
                @if(!$isUnlocked)
                <div class="ach-card-locked-overlay">
                    <span>🔒 Lihat Detail</span>
                </div>
                @endif

                {{-- Top gradient area --}}
                <div class="ach-card-top" style="background: {{ $ach->gradient }};">

                    {{-- Rarity badge --}}
                    <span class="ach-card-rarity-badge"
                          style="background: {{ $ach->rarityBg }}; color: {{ $ach->rarityColor }};">
                        {{ $ach->rarityLabel }}
                    </span>

                    {{-- Unlocked badge --}}
                    @if($isUnlocked)
                    <div class="ach-card-unlock-badge">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        <span>Terbuka</span>
                    </div>
                    @endif

                    {{-- Icon --}}
                    <div class="ach-card-icon">
                        {{ $ach->icon ?? $ach->badge_icon ?? '🏅' }}
                    </div>
                </div>

                {{-- Body --}}
                <div class="ach-card-body">
                    <div class="ach-card-meta">
                        <span class="ach-card-cat">{{ $ach->categoryLabel }}</span>
                        <span class="ach-card-xp">⭐ {{ number_format($ach->xp_reward) }} XP</span>
                    </div>

                    <div class="ach-card-title">{{ $ach->title }}</div>
                    <div class="ach-card-desc">{{ $ach->description }}</div>

                    @if($ach->requirement_type && $ach->requirement_value)
                    <div class="ach-card-req">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        Syarat: <strong>{{ number_format($ach->requirement_value) }}</strong>
                        {{ str_replace('_', ' ', $ach->requirement_type) }}
                    </div>
                    @endif

                    {{-- Progress bar --}}
                    <div class="ach-progress-wrap">
                        <div class="ach-progress-top">
                            <span class="ach-progress-label">
                                {{ $isUnlocked ? 'Selesai' : 'Progress' }}
                            </span>
                            <span class="ach-progress-pct">{{ $pct }}%</span>
                        </div>
                        <div class="ach-progress-bar">
                            <div class="ach-progress-fill"
                                 style="width: {{ $pct }}%; background: {{ $isUnlocked ? '#10B981' : '#2563EB' }};"
                                 data-pct="{{ $pct }}">
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    @if($isUnlocked && $earnedAt)
                    <div class="ach-card-footer">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Diraih {{ \Carbon\Carbon::parse($earnedAt)->translatedFormat('d M Y') }}
                    </div>
                    @else
                    <div class="ach-card-footer-locked">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        Belum terbuka
                    </div>
                    @endif
                </div>
            </a>
            @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                    </svg>
                </div>
                <p class="empty-title">Tidak ada achievement ditemukan</p>
                <p class="empty-sub">Coba ubah filter atau kata kunci pencarian kamu.</p>
                <a href="{{ route('achievements.index') }}" class="btn-primary">
                    Lihat Semua Achievement
                </a>
            </div>
            @endforelse
        </div>

        {{-- ── Pagination ─────────────────────────────────────────────── --}}
        @if($achievements->hasPages())
        <div class="pagination-wrap">
            {{-- Previous --}}
            @if($achievements->onFirstPage())
                <span class="page-link" style="opacity:0.4; cursor:not-allowed;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                </span>
            @else
                <a href="{{ $achievements->previousPageUrl() }}" class="page-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
            @endif

            {{-- Pages --}}
            @foreach($achievements->getUrlRange(1, $achievements->lastPage()) as $page => $url)
                @if($page == $achievements->currentPage())
                    <span class="page-link active">{{ $page }}</span>
                @elseif($page == 1 || $page == $achievements->lastPage() || abs($page - $achievements->currentPage()) <= 2)
                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                @elseif(abs($page - $achievements->currentPage()) == 3)
                    <span class="page-dots">…</span>
                @endif
            @endforeach

            {{-- Next --}}
            @if($achievements->hasMorePages())
                <a href="{{ $achievements->nextPageUrl() }}" class="page-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            @else
                <span class="page-link" style="opacity:0.4; cursor:not-allowed;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </span>
            @endif
        </div>
        @endif

    </div>{{-- /fade-in --}}

</div>{{-- /page padding --}}

<script>
// Animasi progress bar setelah halaman load
document.addEventListener('DOMContentLoaded', function () {
    const fills = document.querySelectorAll('.ach-progress-fill');
    fills.forEach(function (el) {
        const pct = el.getAttribute('data-pct') || '0';
        el.style.width = '0%';
        setTimeout(function () {
            el.style.width = pct + '%';
        }, 200);
    });
});
</script>

</x-app-layout>