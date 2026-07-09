<x-app-layout>

@section('page-title', $course->title)

<style>
    /* ─── DESIGN TOKENS ───────────────────────────────────── */
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

    /* ─── LAYOUT ──────────────────────────────────────────── */
    .show-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 20px;
        align-items: start;
    }
    .show-col-left  { display: flex; flex-direction: column; gap: 20px; }
    .show-col-right { display: flex; flex-direction: column; gap: 20px; }

    /* ─── CARD ────────────────────────────────────────────── */
    .card {
        background: var(--surface);
        border-radius: var(--r-card);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .card-header {
        display:flex; align-items:center; justify-content:space-between;
        padding: 22px 24px 16px;
    }
    .card-header-left { display:flex; align-items:center; gap:10px; }
    .card-icon {
        width:34px; height:34px; border-radius:9px;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .card-title { font-size:15px; font-weight:700; color:var(--text); letter-spacing:-0.2px; }
    .card-body  { padding:0 24px 24px; }

    /* ─── HERO CARD ───────────────────────────────────────── */
    .course-hero {
        border-radius: var(--r-card);
        overflow: hidden;
        box-shadow: var(--shadow);
    }
    .course-hero-band { height: 10px; }
    .course-hero-body {
        background: var(--surface);
        padding: 28px 28px 24px;
    }
    .breadcrumb {
        display:flex; align-items:center; gap:6px;
        font-size:13px; font-weight:500; color:var(--muted);
        margin-bottom:14px;
    }
    .breadcrumb a { color:var(--muted); text-decoration:none; transition:color 0.12s; }
    .breadcrumb a:hover { color:var(--primary); }

    .course-hero-top {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        margin-bottom: 16px;
    }
    .course-hero-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .course-hero-info { flex:1; min-width:0; }
    .course-hero-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.4px;
        line-height: 1.25;
        margin: 0 0 8px;
    }
    .course-hero-badges { display:flex; flex-wrap:wrap; gap:6px; }
    .badge {
        font-size: 11px; font-weight: 700;
        padding: 3px 9px; border-radius: 99px;
        letter-spacing: 0.02em;
    }
    .badge-muted  { background:#F1F5F9; color:var(--muted); }
    .badge-blue   { background:var(--p10); color:var(--primary); }
    .badge-green  { background:var(--s10); color:#15803D; }
    .badge-amber  { background:var(--a10); color:#92400E; }
    .badge-red    { background:#FEF2F2; color:#991B1B; }

    .course-hero-desc {
        font-size: 14px;
        color: var(--muted);
        line-height: 1.65;
        margin: 16px 0 0;
    }

    /* Progress block */
    .course-hero-progress { margin-top: 20px; }
    .progress-row {
        display:flex; align-items:center; justify-content:space-between;
        margin-bottom:6px;
    }
    .progress-label { font-size:13px; font-weight:600; color:var(--muted); }
    .progress-pct   { font-size:13px; font-weight:800; color:var(--text); }
    .prog-track {
        height: 8px; background:#F1F5F9; border-radius:99px; overflow:hidden;
    }
    .prog-fill {
        height:100%; border-radius:99px;
        transition:width 0.8s cubic-bezier(0.4,0,0.2,1);
    }

    /* CTA Buttons */
    .course-hero-cta {
        margin-top: 20px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-primary {
        display:inline-flex; align-items:center; gap:7px;
        padding:11px 22px;
        background:var(--primary); color:#fff;
        font-size:14px; font-weight:700; font-family:inherit;
        border-radius:10px; text-decoration:none;
        transition:opacity 0.15s; border:none; cursor:pointer;
    }
    .btn-primary:hover { opacity:0.88; color:#fff; }
    .btn-outline {
        display:inline-flex; align-items:center; gap:7px;
        padding:11px 18px;
        background:var(--bg); color:var(--muted);
        font-size:14px; font-weight:600; font-family:inherit;
        border-radius:10px; text-decoration:none;
        border:1.5px solid var(--border);
        transition:border-color 0.15s, color 0.15s;
    }
    .btn-outline:hover { border-color:var(--primary); color:var(--primary); }

    /* ─── QUICK STATS (sidebar) ───────────────────────────── */
    .quick-stats { display:flex; flex-direction:column; gap:0; }
    .qs-row {
        display:flex; align-items:center; justify-content:space-between;
        padding:13px 24px; border-bottom:1px solid #F8FAFC;
    }
    .qs-row:last-child { border-bottom:none; }
    .qs-left { display:flex; align-items:center; gap:10px; }
    .qs-icon {
        width:32px; height:32px; border-radius:8px;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .qs-label { font-size:13px; font-weight:500; color:var(--muted); }
    .qs-value { font-size:14px; font-weight:700; color:var(--text); }

    /* ─── CURRICULUM / LESSON LIST ───────────────────────── */
    .lesson-list { display:flex; flex-direction:column; gap:4px; }
    .lesson-item {
        display:flex; align-items:center; gap:14px;
        padding:13px 16px; border-radius:12px;
        text-decoration:none; color:inherit;
        border:1.5px solid transparent;
        transition:background 0.12s, border-color 0.12s;
        cursor:pointer;
    }
    .lesson-item:hover { background:var(--bg); border-color:var(--border); }
    .lesson-item.completed   { background:var(--s10); border-color:#BBF7D0; }
    .lesson-item.in_progress { background:var(--p10); border-color:var(--p20); }

    .lesson-num {
        width:28px; height:28px; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        font-size:12px; font-weight:700; flex-shrink:0;
        background:#F1F5F9; color:var(--muted);
    }
    .lesson-item.completed   .lesson-num { background:var(--secondary); color:#fff; }
    .lesson-item.in_progress .lesson-num { background:var(--primary); color:#fff; }

    .lesson-body { flex:1; min-width:0; }
    .lesson-title {
        font-size:14px; font-weight:600; color:var(--text);
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        margin-bottom:2px;
    }
    .lesson-meta { font-size:12px; color:var(--muted); display:flex; align-items:center; gap:6px; }
    .lesson-type-dot { width:6px; height:6px; border-radius:50%; display:inline-block; }
    .lesson-status {
        flex-shrink:0; font-size:11px; font-weight:700;
        padding:2px 8px; border-radius:99px;
    }
    .status-completed   { background:var(--s10); color:#15803D; }
    .status-in_progress { background:var(--p10); color:var(--primary); }
    .status-not_started { background:#F1F5F9; color:var(--muted); }

    /* ─── VOCABULARY LIST ─────────────────────────────────── */
    .vocab-list { display:flex; flex-direction:column; gap:4px; }
    .vocab-item {
        padding:12px 16px; border-radius:12px;
        border:1.5px solid transparent;
        background:var(--bg);
        transition:border-color 0.12s;
    }
    .vocab-item:hover { border-color:var(--border); }
    .vocab-title  { font-size:14px; font-weight:700; color:var(--text); margin-bottom:2px; }
    .vocab-desc   { font-size:12px; color:var(--muted); line-height:1.5; }

    /* ─── QUIZ LIST ───────────────────────────────────────── */
    .quiz-list { display:flex; flex-direction:column; gap:6px; }
    .quiz-item {
        display:flex; align-items:center; gap:12px;
        padding:12px 16px; border-radius:12px;
        background:var(--bg); border:1.5px solid transparent;
        transition:border-color 0.12s;
    }
    .quiz-item:hover { border-color:var(--border); }
    .quiz-icon {
        width:34px; height:34px; border-radius:9px;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0; background:var(--a10); color:var(--accent);
    }
    .quiz-body { flex:1; min-width:0; }
    .quiz-question {
        font-size:13px; font-weight:600; color:var(--text);
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px;
    }
    .quiz-type { font-size:11px; color:var(--muted); }
    .quiz-xp {
        font-size:11px; font-weight:700; color:var(--accent);
        background:var(--a10); padding:2px 8px; border-radius:99px; flex-shrink:0;
    }

    /* ─── EMPTY STATE ─────────────────────────────────────── */
    .empty-state {
        padding:36px 24px; text-align:center;
        display:flex; flex-direction:column; align-items:center; gap:10px;
    }
    .empty-icon {
        width:48px; height:48px; border-radius:14px; background:var(--bg);
        display:flex; align-items:center; justify-content:center; color:var(--muted);
    }
    .empty-title { font-size:14px; font-weight:600; color:var(--text); }
    .empty-sub   { font-size:13px; color:var(--muted); max-width:260px; }

    /* ─── RELATED COURSES ─────────────────────────────────── */
    .related-list { display:flex; flex-direction:column; gap:6px; }
    .related-item {
        display:flex; align-items:center; gap:12px;
        padding:12px 16px; border-radius:12px;
        text-decoration:none; color:inherit;
        transition:background 0.12s;
    }
    .related-item:hover { background:var(--bg); }
    .related-thumb {
        width:38px; height:38px; border-radius:10px;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .related-body { flex:1; min-width:0; }
    .related-title {
        font-size:13px; font-weight:600; color:var(--text);
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px;
    }
    .related-meta { font-size:12px; color:var(--muted); }

    /* ─── PROGRESS STAT (sidebar) ─────────────────────────── */
    .progress-sidebar-stat { display:flex; align-items:center; gap:12px; padding:12px 20px; }
    .pss-icon {
        width:36px; height:36px; border-radius:9px;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .pss-body { flex:1; min-width:0; }
    .pss-value { font-size:18px; font-weight:800; color:var(--text); }
    .pss-label { font-size:12px; color:var(--muted); }

    /* ─── RESPONSIVE ──────────────────────────────────────── */
    @media (max-width:1023px) {
        .show-grid { grid-template-columns:1fr; }
        .show-col-right { order:-1; }
    }
    @media (max-width:767px) {
        .course-hero-body  { padding:20px; }
        .course-hero-title { font-size:18px; }
        .course-hero-top   { flex-direction:column; gap:12px; }
    }
</style>

@php
    $hasStarted  = $progressPct > 0;
    $isCompleted = $progressPct >= 100;
    $diffBadge   = match($course->difficulty) {
        'beginner'     => 'badge-green',
        'intermediate' => 'badge-amber',
        'advanced'     => 'badge-red',
        default        => 'badge-muted',
    };
@endphp

<div style="max-width:1400px;margin:0 auto;display:flex;flex-direction:column;gap:20px;">

    {{-- ─── BREADCRUMB + HERO ──────────────────────────────── --}}
    <div class="section-fade d1">
        <div class="course-hero">
            <div class="course-hero-band" style="background:{{ $course->color }};"></div>
            <div class="course-hero-body">

                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Dasbor</a>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="{{ route('courses.index') }}">Kursus</a>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    <span style="color:var(--text);font-weight:600;">{{ $course->title }}</span>
                </div>

                <div class="course-hero-top">
                    <div class="course-hero-icon" style="background:{{ $course->color }}1A;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="{{ $course->color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                    </div>
                    <div class="course-hero-info">
                        <h1 class="course-hero-title">{{ $course->title }}</h1>
                        <div class="course-hero-badges">
                            <span class="badge {{ $diffBadge }}">{{ $course->difficulty_label }}</span>
                            <span class="badge badge-muted">{{ $course->lessons_count }} Pelajaran</span>
                            <span class="badge badge-muted">{{ $course->vocabulary_count }} Kosakata</span>
                            <span class="badge badge-muted">{{ $course->quiz_count }} Kuis</span>
                            <span class="badge badge-blue">{{ number_format($course->total_xp) }} XP</span>
                        </div>
                    </div>
                </div>

                @if($course->description)
                <p class="course-hero-desc">{{ $course->description }}</p>
                @endif

                {{-- Progress --}}
                @if($hasStarted)
                <div class="course-hero-progress">
                    <div class="progress-row">
                        <span class="progress-label">{{ $completedCount }} dari {{ $course->lessons_count }} pelajaran selesai</span>
                        <span class="progress-pct">{{ $progressPct }}%</span>
                    </div>
                    <div class="prog-track">
                        <div class="prog-fill" style="width:{{ $progressPct }}%;background:{{ $course->color }};"></div>
                    </div>
                </div>
                @endif

                {{-- CTA --}}
                <div class="course-hero-cta">
                    @if($nextLesson && ! $isCompleted)
                        <a href="{{ route('courses.lessons.show', [$course->slug, $nextLesson->id]) }}" class="btn-primary">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="5 3 19 12 5 21 5 3"/>
                            </svg>
                            {{ $hasStarted ? 'Lanjutkan Belajar' : 'Mulai Belajar' }}
                        </a>
                    @elseif($isCompleted)
                        <a href="{{ route('courses.show', $course->slug) }}#curriculum" class="btn-primary" style="background:var(--secondary);">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 11 12 14 22 4"/>
                            </svg>
                            Tinjau Ulang Kursus
                        </a>
                    @endif
                    <a href="{{ route('courses.index') }}" class="btn-outline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"/>
                        </svg>
                        Semua Kursus
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- ─── MAIN GRID ───────────────────────────────────────── --}}
    <div class="show-grid">

        {{-- LEFT COLUMN --}}
        <div class="show-col-left">

            {{-- CURRICULUM ─────────────────────────────────── --}}
            <div class="section-fade d2" id="curriculum">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#EFF6FF;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                                    <line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/>
                                    <line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                                </svg>
                            </div>
                            <span class="card-title">Kurikulum Kursus</span>
                        </div>
                        <span style="font-size:12px;font-weight:600;color:var(--muted);">{{ $course->lessons_count }} lessons</span>
                    </div>
                    <div class="card-body">
                        @if($lessons->isEmpty())
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/>
                                </svg>
                            </div>
                            <p class="empty-title">Belum ada pelajaran</p>
                            <p class="empty-sub">Pelajaran akan muncul di sini setelah ditambahkan ke kursus ini.</p>
                        </div>
                        @else
                        <div class="lesson-list">
                            @foreach($lessons as $i => $lesson)
                            @php
                                $itemClass = $lesson->is_completed ? 'completed' : ($lesson->is_in_progress ? 'in_progress' : '');
                            @endphp
                            {{-- FIX: <div> diganti <a> dengan href ke lesson detail --}}
                            <a href="{{ route('courses.lessons.show', [$course->slug, $lesson->id]) }}"
                               class="lesson-item {{ $itemClass }}"
                               id="lesson-{{ $lesson->id }}">
                                <div class="lesson-num">
                                    @if($lesson->is_completed)
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    @elseif($lesson->is_in_progress)
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                            <polygon points="5 3 19 12 5 21 5 3"/>
                                        </svg>
                                    @else
                                        {{ $i + 1 }}
                                    @endif
                                </div>
                                <div class="lesson-body">
                                    <div class="lesson-title">{{ $lesson->title }}</div>
                                    <div class="lesson-meta">
                                        <span class="lesson-type-dot" style="background:{{ $lesson->lesson_type_color }};"></span>
                                        {{ $lesson->lesson_type_label }}
                                        @if($lesson->duration_minutes > 0)
                                            &middot; {{ $lesson->duration_minutes }} min
                                        @endif
                                        @if($lesson->xp_reward > 0)
                                            &middot; {{ $lesson->xp_reward }} XP
                                        @endif
                                    </div>
                                </div>
                                @if($lesson->is_completed)
                                    <span class="lesson-status status-completed">Selesai</span>
                                @elseif($lesson->is_in_progress)
                                    <span class="lesson-status status-in_progress">Lanjutkan</span>
                                @else
                                    <span class="lesson-status status-not_started">Mulai</span>
                                @endif
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- VOCABULARY LESSONS ──────────────────────────── --}}
            @if($vocabularyLessons->isNotEmpty())
            <div class="section-fade d3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#DBEAFE;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                            </div>
                            <span class="card-title">Pelajaran Kosakata</span>
                        </div>
                        <span style="font-size:12px;font-weight:600;color:var(--muted);">{{ $vocabularyLessons->count() }} pelajaran</span>
                    </div>
                    <div class="card-body">
                        <div class="vocab-list">
                            @foreach($vocabularyLessons as $vl)
                            <a href="{{ route('courses.lessons.show', [$course->slug, $vl->id]) }}"
                               class="vocab-item" style="text-decoration:none;display:block;">
                                <div class="vocab-title">{{ $vl->title }}</div>
                                @if($vl->description)
                                    <div class="vocab-desc">{{ $vl->description }}</div>
                                @endif
                                <div style="display:flex;align-items:center;gap:8px;margin-top:6px;">
                                    @if($vl->duration_minutes > 0)
                                    <span style="font-size:11px;font-weight:600;color:var(--muted);">{{ $vl->duration_minutes }} min</span>
                                    @endif
                                    @if($vl->xp_reward > 0)
                                    <span style="font-size:11px;font-weight:700;color:var(--accent);background:var(--a10);padding:1px 7px;border-radius:99px;">{{ $vl->xp_reward }} XP</span>
                                    @endif
                                    @if($vl->is_completed)
                                    <span style="font-size:11px;font-weight:700;color:#15803D;background:var(--s10);padding:1px 7px;border-radius:99px;">Selesai</span>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>{{-- /show-col-left --}}

        {{-- RIGHT COLUMN --}}
        <div class="show-col-right">

            {{-- COURSE INFO ───────────────────────────────────── --}}
            <div class="section-fade d2">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:var(--bg);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                            </div>
                            <span class="card-title">Info Kursus</span>
                        </div>
                    </div>
                    <div class="quick-stats">
                        <div class="qs-row">
                            <div class="qs-left">
                                <div class="qs-icon" style="background:#EFF6FF;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                </div>
                                <span class="qs-label">Total Pelajaran</span>
                            </div>
                            <span class="qs-value">{{ $course->lessons_count }}</span>
                        </div>
                        <div class="qs-row">
                            <div class="qs-left">
                                <div class="qs-icon" style="background:#DBEAFE;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                </div>
                                <span class="qs-label">Kosakata</span>
                            </div>
                            <span class="qs-value">{{ $course->vocabulary_count }}</span>
                        </div>
                        <div class="qs-row">
                            <div class="qs-left">
                                <div class="qs-icon" style="background:var(--a10);">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                </div>
                                <span class="qs-label">Kuis</span>
                            </div>
                            <span class="qs-value">{{ $course->quiz_count }}</span>
                        </div>
                        <div class="qs-row">
                            <div class="qs-left">
                                <div class="qs-icon" style="background:var(--a10);">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                                </div>
                                <span class="qs-label">Total XP</span>
                            </div>
                            <span class="qs-value" style="color:var(--accent);">{{ number_format($course->total_xp) }}</span>
                        </div>
                        <div class="qs-row">
                            <div class="qs-left">
                                <div class="qs-icon" style="background:{{ $course->difficulty_bg }};">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $course->difficulty_color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg>
                                </div>
                                <span class="qs-label">Tingkat Kesulitan</span>
                            </div>
                            <span class="qs-value" style="color:{{ $course->difficulty_color }};font-size:13px;">{{ $course->difficulty_label }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MY PROGRESS ───────────────────────────────────── --}}
            <div class="section-fade d3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:var(--s10);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                                </svg>
                            </div>
                            <span class="card-title">Progres Saya</span>
                        </div>
                    </div>
                    <div style="padding:4px 24px 20px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                            <span style="font-size:13px;font-weight:600;color:var(--muted);">{{ $completedCount }} / {{ $course->lessons_count }} completed</span>
                            <span style="font-size:14px;font-weight:800;color:{{ $course->color }};">{{ $progressPct }}%</span>
                        </div>
                        <div class="prog-track" style="height:10px;">
                            <div class="prog-fill" style="width:{{ $progressPct }}%;background:{{ $course->color }};"></div>
                        </div>
                        @if($progressPct === 0)
                        <p style="font-size:12px;color:var(--muted);margin-top:10px;line-height:1.5;">
                            Mulai pelajaran pertama Anda untuk melacak progres di sini.
                        </p>
                        @elseif($progressPct >= 100)
                        <p style="font-size:12px;color:#15803D;font-weight:600;margin-top:10px;">
                            Kursus selesai! Kerja bagus.
                        </p>
                        @else
                        <p style="font-size:12px;color:var(--muted);margin-top:10px;">
                            {{ $course->remaining_lessons }} pelajaran tersisa.
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RELATED COURSES ───────────────────────────────── --}}
            @if($relatedCourses->isNotEmpty())
            <div class="section-fade d4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:var(--bg);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                </svg>
                            </div>
                            <span class="card-title">Kursus Terkait</span>
                        </div>
                    </div>
                    <div class="related-list" style="padding:0 8px 16px;">
                        @foreach($relatedCourses as $rel)
                        <a href="{{ route('courses.show', $rel->slug) }}" class="related-item">
                            <div class="related-thumb" style="background:{{ $rel->color }}1A;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $rel->color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                </svg>
                            </div>
                            <div class="related-body">
                                <div class="related-title">{{ $rel->title }}</div>
                                <div class="related-meta">{{ $rel->lessons_count }} pelajaran &middot; {{ $rel->calculated_progress }}% done</div>
                            </div>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>{{-- /show-col-right --}}

    </div>{{-- /show-grid --}}

</div>

</x-app-layout>