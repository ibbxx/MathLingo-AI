<x-app-layout>

@section('page-title', 'Kursus')

<style>
    /* ─── DESIGN TOKENS (same as Dashboard) ───────────────── */
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

    /* ─── PAGE ANIMATION ──────────────────────────────────── */
    .section-fade { opacity:0; animation:fadeUp 0.45s cubic-bezier(0.22,1,0.36,1) forwards; }
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(18px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .d1{animation-delay:0.05s;} .d2{animation-delay:0.12s;} .d3{animation-delay:0.19s;}
    .d4{animation-delay:0.26s;} .d5{animation-delay:0.33s;} .d6{animation-delay:0.40s;}

    /* ─── PAGE HEADER ─────────────────────────────────────── */
    .page-hero {
        background: var(--primary);
        border-radius: var(--r-card);
        padding: 32px 36px;
        position: relative;
        overflow: hidden;
    }
    .breadcrumb {
        display:flex; align-items:center; gap:6px;
        font-size:13px; font-weight:500; color:rgba(255,255,255,0.6);
        margin-bottom:10px; position:relative; z-index:1;
    }
    .breadcrumb a { color:rgba(255,255,255,0.6); text-decoration:none; }
    .breadcrumb a:hover { color:#fff; }
    .breadcrumb svg { flex-shrink:0; }
    .page-hero-title {
        font-size:26px; font-weight:800; color:#fff;
        letter-spacing:-0.4px; line-height:1.2;
        margin:0 0 6px; position:relative; z-index:1;
    }
    .page-hero-sub {
        font-size:14px; color:rgba(255,255,255,0.75);
        line-height:1.6; margin:0; position:relative; z-index:1;
    }

    /* ─── STAT STRIP ──────────────────────────────────────── */
    .stat-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
    }
    .stat-tile {
        background: var(--surface);
        border-radius: 16px;
        padding: 18px 20px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .stat-tile-icon {
        width: 40px; height: 40px;
        border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-tile-body { flex:1; min-width:0; }
    .stat-tile-value {
        font-size: 22px; font-weight: 800;
        color: var(--text); letter-spacing: -0.5px; line-height: 1;
        margin-bottom: 2px;
    }
    .stat-tile-label {
        font-size: 12px; font-weight: 600;
        color: var(--muted); text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    /* ─── CARD (shared) ───────────────────────────────────── */
    .card {
        background: var(--surface);
        border-radius: var(--r-card);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 22px 24px 16px;
    }
    .card-header-left { display:flex; align-items:center; gap:10px; }
    .card-icon {
        width:34px; height:34px; border-radius:9px;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .card-title { font-size:15px; font-weight:700; color:var(--text); letter-spacing:-0.2px; }
    .card-link {
        font-size:13px; font-weight:600; color:var(--primary);
        text-decoration:none; display:flex; align-items:center; gap:4px;
        transition:opacity 0.15s;
    }
    .card-link:hover { opacity:0.75; }
    .card-body { padding:0 24px 24px; }

    /* ─── SEARCH & FILTER BAR ─────────────────────────────── */
    .filter-bar {
        background: var(--surface);
        border-radius: var(--r-card);
        box-shadow: var(--shadow);
        padding: 18px 24px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }
    .search-wrap {
        flex: 1; min-width: 220px;
        position: relative;
    }
    .search-wrap svg {
        position:absolute; left:13px; top:50%; transform:translateY(-50%);
        color:var(--muted); pointer-events:none;
    }
    .search-input {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        color: var(--text);
        background: var(--bg);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .search-input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(37,99,235,0.1); }
    .search-input::placeholder { color:var(--muted); }

    .filter-select {
        padding: 9px 32px 9px 12px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        font-family: inherit;
        color: var(--text);
        background: var(--bg);
        outline: none;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        transition: border-color 0.15s;
        min-width: 140px;
    }
    .filter-select:focus { border-color:var(--primary); outline:none; }

    .btn-filter-submit {
        display:inline-flex; align-items:center; gap:6px;
        padding:9px 18px;
        background:var(--primary); color:#fff;
        font-size:13px; font-weight:600; font-family:inherit;
        border-radius:10px; border:none; cursor:pointer;
        transition:opacity 0.15s;
    }
    .btn-filter-submit:hover { opacity:0.88; }

    .btn-reset {
        display:inline-flex; align-items:center; gap:6px;
        padding:9px 14px;
        background:var(--bg); color:var(--muted);
        font-size:13px; font-weight:500; font-family:inherit;
        border-radius:10px; border:1.5px solid var(--border); cursor:pointer;
        text-decoration:none;
        transition:border-color 0.15s, color 0.15s;
    }
    .btn-reset:hover { border-color:var(--primary); color:var(--primary); }

    /* ─── SECTION LABEL ───────────────────────────────────── */
    .section-label {
        font-size:12px; font-weight:700; color:var(--muted);
        letter-spacing:0.06em; text-transform:uppercase;
        margin-bottom:14px;
    }

    /* ─── CONTINUE LEARNING ROW ───────────────────────────── */
    .continue-list { display:flex; flex-direction:column; }
    .continue-item {
        display:flex; align-items:center; gap:14px;
        padding:14px 24px; text-decoration:none; color:inherit;
        transition:background 0.12s;
    }
    .continue-item:hover { background:var(--bg); }
    .continue-thumb {
        width:44px; height:44px; border-radius:11px;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0;
    }
    .continue-meta { flex:1; min-width:0; }
    .continue-name {
        font-size:14px; font-weight:600; color:var(--text);
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        margin-bottom:2px;
    }
    .continue-sub {
        font-size:12px; color:var(--muted); margin-bottom:6px;
    }
    .prog-track {
        height:5px; background:#F1F5F9; border-radius:99px; overflow:hidden;
    }
    .prog-fill {
        height:100%; border-radius:99px;
        transition:width 0.8s cubic-bezier(0.4,0,0.2,1);
    }
    .continue-pct {
        font-size:12px; font-weight:700; color:var(--muted); flex-shrink:0;
    }
    .badge {
        font-size:11px; font-weight:600; padding:2px 8px; border-radius:99px;
    }
    .badge-muted { background:#F1F5F9; color:var(--muted); }

    /* ─── COURSE CARD GRID ────────────────────────────────── */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 16px;
    }

    .course-card {
        background: var(--surface);
        border-radius: var(--r-card);
        box-shadow: var(--shadow);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s, transform 0.2s;
        text-decoration: none;
        color: inherit;
    }
    .course-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    /* Thumbnail / Color Band */
    .course-card-thumb {
        height: 8px;
        flex-shrink: 0;
    }

    /* Card Body */
    .course-card-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    /* Top Row: difficulty badge */
    .course-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .difficulty-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 99px;
        letter-spacing: 0.03em;
        text-transform: capitalize;
    }
    .diff-beginner     { background:#F0FDF4; color:#15803D; }
    .diff-intermediate { background:#FFFBEB; color:#92400E; }
    .diff-advanced     { background:#FEF2F2; color:#991B1B; }

    .course-card-icon-wrap {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* Title & Description */
    .course-card-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -0.2px;
        margin: 0 0 6px;
        line-height: 1.35;
    }
    .course-card-desc {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.55;
        margin: 0 0 14px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Meta row */
    .course-card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
    }

    /* Progress */
    .course-card-progress { margin-bottom: 16px; }
    .course-card-progress-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    .course-card-progress-label {
        font-size: 12px; font-weight: 600; color: var(--muted);
    }
    .course-card-progress-pct {
        font-size: 12px; font-weight: 700; color: var(--text);
    }
    .prog-track-card {
        height: 6px;
        background: #F1F5F9;
        border-radius: 99px;
        overflow: hidden;
    }
    .prog-fill-card {
        height: 100%;
        border-radius: 99px;
        transition: width 0.8s cubic-bezier(0.4,0,0.2,1);
    }

    /* Footer CTA */
    .course-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 14px;
        border-top: 1px solid var(--border);
        margin-top: auto;
    }
    .btn-course-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 700;
        font-family: inherit;
        border-radius: 9px;
        text-decoration: none;
        transition: opacity 0.15s;
        flex: 1;
        justify-content: center;
    }
    .btn-course-primary {
        background: var(--primary);
        color: #fff;
    }
    .btn-course-primary:hover { opacity: 0.88; }
    .btn-course-outline {
        background: var(--p10);
        color: var(--primary);
        border: 1.5px solid var(--p20);
    }
    .btn-course-outline:hover { background: var(--p20); }

    .xp-tag {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: 12px;
        font-weight: 700;
        color: var(--accent);
        background: var(--a10);
        padding: 4px 10px;
        border-radius: 99px;
        flex-shrink: 0;
    }

    /* ─── RECOMMENDED CARDS (horizontal strip) ────────────── */
    .rec-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 14px;
    }
    .rec-card {
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        color: inherit;
        transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    }
    .rec-card:hover {
        border-color: var(--p20);
        background: var(--p10);
        box-shadow: 0 2px 8px rgba(37,99,235,0.08);
    }
    .rec-card-thumb {
        width: 44px; height: 44px;
        border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .rec-card-body { flex:1; min-width:0; }
    .rec-card-title {
        font-size: 13px; font-weight: 700; color: var(--text);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: 3px;
    }
    .rec-card-meta {
        font-size: 12px; color: var(--muted);
    }
    .rec-card-arrow { color:var(--muted); flex-shrink:0; }

    /* ─── EMPTY STATE ─────────────────────────────────────── */
    .empty-state {
        padding: 48px 24px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .empty-icon {
        width: 52px; height: 52px;
        border-radius: 14px; background: var(--bg);
        display: flex; align-items: center; justify-content: center;
        color: var(--muted);
    }
    .empty-title { font-size:15px; font-weight:700; color:var(--text); }
    .empty-sub   { font-size:13px; color:var(--muted); max-width:280px; }
    .btn-primary {
        display:inline-flex; align-items:center; gap:6px;
        padding:9px 18px; background:var(--primary); color:#fff;
        font-size:13px; font-weight:600; border-radius:9px;
        text-decoration:none; transition:opacity 0.15s; margin-top:4px;
    }
    .btn-primary:hover { opacity:0.88; }

    /* ─── PAGINATION ──────────────────────────────────────── */
    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 8px;
    }
    .pagination-info { font-size:13px; color:var(--muted); font-weight:500; }
    .pagination-links { display:flex; align-items:center; gap:4px; }
    .pagination-links a,
    .pagination-links span {
        display:inline-flex; align-items:center; justify-content:center;
        width:34px; height:34px; border-radius:9px;
        font-size:13px; font-weight:600; text-decoration:none;
        color:var(--muted); background:var(--bg);
        border:1.5px solid var(--border);
        transition:background 0.12s, border-color 0.12s, color 0.12s;
    }
    .pagination-links a:hover { background:var(--p10); border-color:var(--p20); color:var(--primary); }
    .pagination-links span.active { background:var(--primary); border-color:var(--primary); color:#fff; }
    .pagination-links span.disabled { opacity:0.4; pointer-events:none; }

    /* ─── RESPONSIVE ──────────────────────────────────────── */
    @media (max-width:1023px) {
        .courses-grid { grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); }
    }
    @media (max-width:767px) {
        .page-hero { padding:24px 20px; }
        .stat-strip { grid-template-columns: 1fr 1fr; }
        .filter-bar { flex-direction:column; align-items:stretch; }
        .search-wrap { min-width:unset; }
        .courses-grid { grid-template-columns: 1fr; }
        .rec-grid { grid-template-columns: 1fr; }
    }
    @media (max-width:479px) {
        .stat-strip { grid-template-columns: 1fr; }
    }
</style>

<div style="max-width:1400px;margin:0 auto;display:flex;flex-direction:column;gap:20px;">

    {{-- ─── PAGE HERO ─────────────────────────────────────── --}}
    <div class="section-fade d1">
        <div class="page-hero">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dasbor</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                <span style="color:rgba(255,255,255,0.9);">Kursus</span>
            </div>
            <h1 class="page-hero-title">Kursus</h1>
            <p class="page-hero-sub">Kuasai Bahasa Inggris Matematika melalui jalur pembelajaran terstruktur.</p>
        </div>
    </div>

    {{-- ─── STATISTICS STRIP ───────────────────────────────── --}}
    <div class="section-fade d2">
        <div class="stat-strip">
            {{-- Total Kursus --}}
            <div class="stat-tile">
                <div class="stat-tile-icon" style="background:#EFF6FF;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                </div>
                <div class="stat-tile-body">
                    <div class="stat-tile-value">{{ $totalCourses }}</div>
                    <div class="stat-tile-label">Total Kursus</div>
                </div>
            </div>

            {{-- Total Pelajaran --}}
            <div class="stat-tile">
                <div class="stat-tile-icon" style="background:#F0FDF4;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>
                </div>
                <div class="stat-tile-body">
                    <div class="stat-tile-value">{{ $totalLessons }}</div>
                    <div class="stat-tile-label">Total Pelajaran</div>
                </div>
            </div>

            {{-- Vocabulary --}}
            <div class="stat-tile">
                <div class="stat-tile-icon" style="background:#DBEAFE;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                    </svg>
                </div>
                <div class="stat-tile-body">
                    <div class="stat-tile-value">{{ $totalVocabulary }}</div>
                    <div class="stat-tile-label">Vocabulary</div>
                </div>
            </div>

            {{-- Total XP --}}
            <div class="stat-tile">
                <div class="stat-tile-icon" style="background:#FFFBEB;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                </div>
                <div class="stat-tile-body">
                    <div class="stat-tile-value">{{ number_format($totalXp) }}</div>
                    <div class="stat-tile-label">Total XP</div>
                </div>
            </div>

            {{-- Completed Courses --}}
            <div class="stat-tile">
                <div class="stat-tile-icon" style="background:#F0FDF4;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/>
                    </svg>
                </div>
                <div class="stat-tile-body">
                    <div class="stat-tile-value">{{ $userStats['completed_courses'] }}</div>
                    <div class="stat-tile-label">Completed</div>
                </div>
            </div>

            {{-- XP Diperoleh --}}
            <div class="stat-tile">
                <div class="stat-tile-icon" style="background:#EDE9FE;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                    </svg>
                </div>
                <div class="stat-tile-body">
                    <div class="stat-tile-value">{{ number_format($userStats['total_xp']) }}</div>
                    <div class="stat-tile-label">XP Diperoleh</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── SEARCH & FILTER ────────────────────────────────── --}}
    <div class="section-fade d3">
        <form method="GET" action="{{ route('courses.index') }}" class="filter-bar">
            {{-- Search --}}
            <div class="search-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input
                    type="search"
                    name="search"
                    class="search-input"
                    placeholder="Cari kursus, topik..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                >
            </div>

            {{-- Difficulty --}}
            <select name="difficulty" class="filter-select">
                <option value="">Semua Tingkat</option>
                @foreach($difficulties as $d)
                    <option value="{{ $d }}" {{ request('difficulty') === $d ? 'selected' : '' }}>
                        {{ ucfirst($d) }}
                    </option>
                @endforeach
            </select>

            {{-- Sort --}}
            <select name="sort" class="filter-select">
                <option value="sort_order" {{ $sort === 'sort_order' ? 'selected' : '' }}>Urutan Default</option>
                <option value="newest"     {{ $sort === 'newest'     ? 'selected' : '' }}>Newest</option>
                <option value="oldest"     {{ $sort === 'oldest'     ? 'selected' : '' }}>Oldest</option>
                <option value="lessons"    {{ $sort === 'lessons'    ? 'selected' : '' }}>Pelajaran Terbanyak</option>
                <option value="xp"         {{ $sort === 'xp'         ? 'selected' : '' }}>XP Tertinggi</option>
                <option value="az"         {{ $sort === 'az'         ? 'selected' : '' }}>A → Z</option>
            </select>

            <button type="submit" class="btn-filter-submit">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Cari
            </button>

            @if(request()->hasAny(['search', 'difficulty', 'sort']))
                <a href="{{ route('courses.index') }}" class="btn-reset">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ─── CONTINUE LEARNING ──────────────────────────────── --}}
    @if($continueLearning->isNotEmpty())
    <div class="section-fade d4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon" style="background:#EFF6FF;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="5 3 19 12 5 21 5 3"/>
                        </svg>
                    </div>
                    <span class="card-title">Lanjutkan Belajar</span>
                </div>
                <span style="font-size:12px;font-weight:600;color:var(--muted);">{{ $continueLearning->count() }} sedang berjalan</span>
            </div>
            <div class="continue-list">
                @foreach($continueLearning as $c)
                @php $pct = $c->calculated_progress; @endphp
                <a href="{{ route('courses.show', $c->slug) }}" class="continue-item">
                    <div class="continue-thumb" style="background:{{ $c->color }}1A;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $c->color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                    </div>
                    <div class="continue-meta" style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:3px;">
                            <span class="continue-name">{{ $c->title }}</span>
                            <span class="continue-pct">{{ $pct }}%</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:7px;">
                            <span class="badge badge-muted">{{ $c->difficulty_label }}</span>
                            <span style="font-size:12px;color:var(--muted);">{{ $c->lessons_count }} pelajaran</span>
                        </div>
                        <div class="prog-track">
                            <div class="prog-fill" style="width:{{ $pct }}%;background:{{ $c->color }};"></div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ─── RECOMMENDED COURSES ─────────────────────────────── --}}
    @if($recommendedCourses->isNotEmpty())
    <div class="section-fade d4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon" style="background:#F0FDF4;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <span class="card-title">Rekomendasi untuk Anda</span>
                </div>
                <span style="font-size:12px;font-weight:600;color:var(--muted);">Cocok untuk pemula</span>
            </div>
            <div class="card-body">
                <div class="rec-grid">
                    @foreach($recommendedCourses as $r)
                    <a href="{{ route('courses.show', $r->slug) }}" class="rec-card">
                        <div class="rec-card-thumb" style="background:{{ $r->color }}1A;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $r->color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                        </div>
                        <div class="rec-card-body">
                            <div class="rec-card-title">{{ $r->title }}</div>
                            <div class="rec-card-meta">{{ $r->lessons_count }} pelajaran &middot; {{ number_format($r->total_xp) }} XP</div>
                        </div>
                        <div class="rec-card-arrow">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ─── ALL COURSES ─────────────────────────────────────── --}}
    <div class="section-fade d5">
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon" style="background:#F8FAFC;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
                        </svg>
                    </div>
                    <span class="card-title">Semua Kursus</span>
                </div>
                <span style="font-size:12px;font-weight:600;color:var(--muted);">{{ $courses->total() }} courses</span>
            </div>
            <div class="card-body">

                @if($courses->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                    </div>
                    <p class="empty-title">Tidak ada kursus ditemukan</p>
                    <p class="empty-sub">Coba ubah pencarian atau filter untuk menemukan yang Anda butuhkan.</p>
                    <a href="{{ route('courses.index') }}" class="btn-primary">Hapus Filter</a>
                </div>
                @else

                <div class="courses-grid">
                    @foreach($courses as $course)
                    @php
                        $pct = $course->calculated_progress;
                        $diffClass = match($course->difficulty) {
                            'beginner'     => 'diff-beginner',
                            'intermediate' => 'diff-intermediate',
                            'advanced'     => 'diff-advanced',
                            default        => 'diff-beginner',
                        };
                    @endphp
                    <a href="{{ route('courses.show', $course->slug) }}" class="course-card">
                        {{-- Color band at top --}}
                        <div class="course-card-thumb" style="background:{{ $course->color }};"></div>

                        <div class="course-card-body">
                            {{-- Top row --}}
                            <div class="course-card-top">
                                <span class="difficulty-badge {{ $diffClass }}">{{ $course->difficulty_label }}</span>
                                <div class="course-card-icon-wrap" style="background:{{ $course->color }}1A;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $course->color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Title & Description --}}
                            <h3 class="course-card-title">{{ $course->title }}</h3>
                            @if($course->description)
                                <p class="course-card-desc">{{ $course->description }}</p>
                            @endif

                            {{-- Meta --}}
                            <div class="course-card-meta">
                                <span class="meta-item">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                    {{ $course->lessons_count }} Pelajaran
                                </span>
                                <span class="meta-item">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    {{ $course->vocabulary_count }} Kosakata
                                </span>
                                <span class="meta-item">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                                    {{ $course->quiz_count }} Kuis
                                </span>
                            </div>

                            {{-- Progress --}}
                            @if($pct > 0)
                            <div class="course-card-progress">
                                <div class="course-card-progress-row">
                                    <span class="course-card-progress-label">Progress</span>
                                    <span class="course-card-progress-pct">{{ $pct }}%</span>
                                </div>
                                <div class="prog-track-card">
                                    <div class="prog-fill-card" style="width:{{ $pct }}%;background:{{ $course->color }};"></div>
                                </div>
                            </div>
                            @endif

                            {{-- Footer --}}
                            <div class="course-card-footer">
                                <span class="btn-course-action {{ $pct > 0 ? 'btn-course-primary' : 'btn-course-outline' }}">
                                    @if($pct === 0)
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                        Mulai Belajar
                                    @elseif($pct >= 100)
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/></svg>
                                        Review
                                    @else
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                        Lanjutkan
                                    @endif
                                </span>
                                <span class="xp-tag">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                                    {{ number_format($course->total_xp) }} XP
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($courses->hasPages())
                <div class="pagination-wrap" style="margin-top:24px;">
                    <span class="pagination-info">
                        Menampilkan {{ $courses->firstItem() }}–{{ $courses->lastItem() }} dari {{ $courses->total() }} kursus
                    </span>
                    <div class="pagination-links">
                        {{-- Previous --}}
                        @if($courses->onFirstPage())
                            <span class="disabled">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </span>
                        @else
                            <a href="{{ $courses->previousPageUrl() }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach($courses->getUrlRange(max(1, $courses->currentPage()-2), min($courses->lastPage(), $courses->currentPage()+2)) as $page => $url)
                            @if($page === $courses->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if($courses->hasMorePages())
                            <a href="{{ $courses->nextPageUrl() }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @else
                            <span class="disabled">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </span>
                        @endif
                    </div>
                </div>
                @endif

                @endif
            </div>
        </div>
    </div>

</div>

</x-app-layout>