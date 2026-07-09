<x-app-layout>

@section('page-title', $lesson->title . ' — ' . $course->title)

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
    .d1{animation-delay:0.04s;} .d2{animation-delay:0.10s;} .d3{animation-delay:0.16s;}
    .d4{animation-delay:0.22s;} .d5{animation-delay:0.28s;} .d6{animation-delay:0.34s;}

    /* ─── LAYOUT ──────────────────────────────────────────── */
    .lesson-grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 20px;
        align-items: start;
    }
    .lesson-col-main  { display:flex; flex-direction:column; gap:20px; }
    .lesson-col-side  { display:flex; flex-direction:column; gap:20px; position:sticky; top:20px; }

    /* ─── CARD ────────────────────────────────────────────── */
    .card {
        background: var(--surface);
        border-radius: var(--r-card);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .card-header {
        display:flex; align-items:center; justify-content:space-between;
        padding: 20px 24px 14px;
        border-bottom: 1px solid var(--border);
    }
    .card-header-left { display:flex; align-items:center; gap:10px; }
    .card-icon {
        width:34px; height:34px; border-radius:9px;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .card-title { font-size:15px; font-weight:700; color:var(--text); letter-spacing:-0.2px; }
    .card-body  { padding:20px 24px 24px; }

    /* ─── BREADCRUMB ──────────────────────────────────────── */
    .breadcrumb {
        display:flex; align-items:center; gap:6px; flex-wrap:wrap;
        font-size:13px; font-weight:500; color:var(--muted);
        margin-bottom:0;
    }
    .breadcrumb a { color:var(--muted); text-decoration:none; transition:color 0.12s; }
    .breadcrumb a:hover { color:var(--primary); }

    /* ─── LESSON HERO ─────────────────────────────────────── */
    .lesson-hero {
        border-radius: var(--r-card);
        overflow: hidden;
        box-shadow: var(--shadow);
    }
    .lesson-hero-band { height: 6px; }
    .lesson-hero-body {
        background: var(--surface);
        padding: 24px 28px 22px;
    }
    .lesson-hero-top {
        display:flex; align-items:flex-start; gap:16px;
    }
    .lesson-hero-icon {
        width:50px; height:50px; border-radius:13px;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0; font-size:22px;
    }
    .lesson-hero-info { flex:1; min-width:0; }
    .lesson-hero-title {
        font-size:20px; font-weight:800; color:var(--text);
        letter-spacing:-0.4px; line-height:1.25; margin:0 0 8px;
    }
    .lesson-hero-badges { display:flex; flex-wrap:wrap; gap:6px; }
    .badge {
        font-size:11px; font-weight:700;
        padding:3px 9px; border-radius:99px;
        letter-spacing:0.02em;
    }
    .badge-muted  { background:#F1F5F9; color:var(--muted); }
    .badge-blue   { background:var(--p10); color:var(--primary); }
    .badge-green  { background:var(--s10); color:#15803D; }
    .badge-amber  { background:var(--a10); color:#92400E; }
    .badge-red    { background:#FEF2F2; color:#991B1B; }
    .badge-purple { background:#EDE9FE; color:#6D28D9; }

    /* ─── PROGRESS BAR (hero) ─────────────────────────────── */
    .prog-wrap { margin-top:18px; }
    .prog-row { display:flex;align-items:center;justify-content:space-between;margin-bottom:5px; }
    .prog-label { font-size:12px;font-weight:600;color:var(--muted); }
    .prog-pct   { font-size:12px;font-weight:800;color:var(--text); }
    .prog-track { height:6px;background:#F1F5F9;border-radius:99px;overflow:hidden; }
    .prog-fill  { height:100%;border-radius:99px;transition:width 0.8s cubic-bezier(0.4,0,0.2,1); }

    /* ─── NAV BUTTONS (prev/next) ─────────────────────────── */
    .lesson-nav {
        display:flex; gap:10px; margin-top:18px; flex-wrap:wrap;
    }
    .btn-primary {
        display:inline-flex; align-items:center; gap:7px;
        padding:10px 20px;
        background:var(--primary); color:#fff;
        font-size:13px; font-weight:700; font-family:inherit;
        border-radius:10px; text-decoration:none;
        transition:opacity 0.15s; border:none; cursor:pointer;
    }
    .btn-primary:hover { opacity:0.88; color:#fff; }
    .btn-success {
        display:inline-flex; align-items:center; gap:7px;
        padding:10px 20px;
        background:var(--secondary); color:#fff;
        font-size:13px; font-weight:700; font-family:inherit;
        border-radius:10px; text-decoration:none;
        transition:opacity 0.15s; border:none; cursor:pointer;
    }
    .btn-success:hover { opacity:0.88; }
    .btn-outline {
        display:inline-flex; align-items:center; gap:7px;
        padding:10px 18px;
        background:var(--bg); color:var(--muted);
        font-size:13px; font-weight:600; font-family:inherit;
        border-radius:10px; text-decoration:none;
        border:1.5px solid var(--border); transition:border-color 0.15s, color 0.15s;
    }
    .btn-outline:hover { border-color:var(--primary); color:var(--primary); }
    .btn-disabled {
        display:inline-flex; align-items:center; gap:7px;
        padding:10px 18px;
        background:#F1F5F9; color:#CBD5E1;
        font-size:13px; font-weight:600; font-family:inherit;
        border-radius:10px; border:1.5px solid #E5E7EB;
        cursor:not-allowed; pointer-events:none;
    }

    /* ─── COMPLETED BANNER ────────────────────────────────── */
    .completed-banner {
        display:flex; align-items:center; gap:12px;
        background:var(--s10); border:1.5px solid #BBF7D0;
        border-radius:14px; padding:14px 20px;
    }
    .completed-banner-icon {
        width:38px; height:38px; border-radius:50%;
        background:var(--secondary); color:#fff;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .completed-banner-title { font-size:14px; font-weight:700; color:#15803D; }
    .completed-banner-sub   { font-size:12px; color:#16A34A; }

    /* ─── READING CONTENT ─────────────────────────────────── */
    .content-prose {
        font-size:15px; line-height:1.8; color:var(--text);
    }
    .content-prose h1,.content-prose h2,.content-prose h3 {
        font-weight:700; color:var(--text); letter-spacing:-0.3px;
        margin:1.4em 0 0.5em;
    }
    .content-prose h1 { font-size:20px; }
    .content-prose h2 { font-size:18px; }
    .content-prose h3 { font-size:16px; }
    .content-prose p  { margin:0 0 1em; }
    .content-prose ul,.content-prose ol { padding-left:22px; margin:0 0 1em; }
    .content-prose li { margin-bottom:0.4em; }
    .content-prose code {
        background:var(--bg); border:1px solid var(--border);
        border-radius:5px; padding:1px 6px;
        font-size:13px; font-family:monospace;
    }
    .content-prose pre {
        background:#1E293B; color:#E2E8F0;
        border-radius:12px; padding:18px 20px;
        font-size:13px; overflow-x:auto; margin:1em 0;
    }
    .content-prose pre code { background:none; border:none; padding:0; color:inherit; }
    .content-prose blockquote {
        border-left:3px solid var(--primary);
        background:var(--p10); border-radius:0 10px 10px 0;
        padding:12px 16px; margin:1em 0;
        font-style:italic; color:var(--muted);
    }
    .content-prose strong { font-weight:700; color:var(--text); }
    .content-prose table {
        border-collapse:collapse; width:100%; margin:1em 0;
        font-size:14px;
    }
    .content-prose th,.content-prose td {
        border:1px solid var(--border); padding:8px 12px; text-align:left;
    }
    .content-prose th { background:var(--bg); font-weight:700; }
    .content-prose img {
        max-width:100%; height:auto; border-radius:10px; margin:0.8em 0;
        display:block;
    }
    .content-prose a { color:var(--primary); text-decoration:underline; }
    .content-prose .math-block {
        background:var(--bg); border:1px solid var(--border); border-radius:8px;
        padding:10px 14px; margin:0.6em 0; display:inline-block; font-family:monospace;
    }

    /* ─── VOCABULARY CARDS ────────────────────────────────── */
    .vocab-grid { display:flex; flex-direction:column; gap:10px; }
    .vocab-card {
        border-radius:14px; border:1.5px solid var(--border);
        padding:16px 18px; background:var(--bg);
        transition:border-color 0.12s, box-shadow 0.12s;
    }
    .vocab-card:hover { border-color:var(--p20); box-shadow:0 2px 8px rgba(37,99,235,0.07); }
    .vocab-term {
        font-size:16px; font-weight:800; color:var(--primary);
        margin-bottom:4px; letter-spacing:-0.2px;
    }
    .vocab-meaning {
        font-size:13px; color:var(--text); font-weight:500; margin-bottom:6px;
    }
    .vocab-row { display:flex; flex-wrap:wrap; gap:6px 16px; margin-top:8px; }
    .vocab-field { font-size:12px; color:var(--muted); }
    .vocab-field strong { color:var(--text); font-weight:600; }
    .vocab-badge {
        font-size:10px; font-weight:700; padding:2px 8px; border-radius:99px;
        background:var(--p10); color:var(--primary);
    }
    .vocab-formula {
        font-family:monospace; font-size:13px; background:#1E293B; color:#93C5FD;
        border-radius:8px; padding:8px 12px; margin-top:8px; display:inline-block;
    }
    .vocab-example {
        font-size:13px; color:var(--muted); font-style:italic;
        border-left:2px solid var(--p20); padding-left:10px; margin-top:8px;
    }

    /* ─── QUIZ CARDS ──────────────────────────────────────── */
    .quiz-grid { display:flex; flex-direction:column; gap:16px; }
    .quiz-card {
        border-radius:14px; border:1.5px solid var(--border);
        overflow:hidden; background:var(--surface);
    }
    .quiz-card-header {
        display:flex; align-items:center; gap:10px;
        padding:14px 18px; background:var(--a10);
        border-bottom:1px solid #FDE68A;
    }
    .quiz-num {
        width:26px; height:26px; border-radius:50%;
        background:var(--accent); color:#fff;
        display:flex; align-items:center; justify-content:center;
        font-size:11px; font-weight:800; flex-shrink:0;
    }
    .quiz-type-badge {
        font-size:10px; font-weight:700; padding:2px 8px; border-radius:99px;
        background:#FEF3C7; color:#92400E; flex-shrink:0;
    }
    .quiz-xp-badge {
        margin-left:auto;
        font-size:10px; font-weight:700; padding:2px 8px; border-radius:99px;
        background:var(--a10); color:var(--accent);
    }
    .quiz-card-body { padding:14px 18px 16px; }
    .quiz-question-text {
        font-size:14px; font-weight:600; color:var(--text);
        margin-bottom:12px; line-height:1.5;
    }
    .quiz-options { display:flex; flex-direction:column; gap:6px; }
    .quiz-option {
        font-size:13px; color:var(--muted);
        padding:8px 12px; border-radius:8px; background:var(--bg);
        border:1px solid var(--border);
        display:flex; align-items:center; gap:8px;
    }
    .quiz-option-key {
        width:22px; height:22px; border-radius:50%;
        background:#E2E8F0; color:var(--muted);
        display:flex; align-items:center; justify-content:center;
        font-size:10px; font-weight:700; flex-shrink:0;
    }
    .quiz-answer {
        margin-top:10px; padding:8px 12px; border-radius:8px;
        background:var(--s10); border:1px solid #BBF7D0;
        font-size:12px; font-weight:600; color:#15803D;
    }
    .quiz-explanation {
        margin-top:6px; padding:8px 12px; border-radius:8px;
        background:var(--p10); font-size:12px; color:var(--muted);
        font-style:italic;
    }

    /* ─── SIDEBAR: Lesson List ────────────────────────────── */
    .sidebar-lesson-list { display:flex; flex-direction:column; gap:2px; padding:8px 12px 14px; }
    .sidebar-lesson-item {
        display:flex; align-items:center; gap:10px;
        padding:9px 10px; border-radius:10px;
        text-decoration:none; color:inherit;
        transition:background 0.12s;
    }
    .sidebar-lesson-item:hover { background:var(--bg); }
    .sidebar-lesson-item.active { background:var(--p10); }
    .sidebar-lesson-item.s-completed { opacity:0.75; }
    .sidebar-lesson-num {
        width:22px; height:22px; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        font-size:10px; font-weight:700; flex-shrink:0;
        background:#F1F5F9; color:var(--muted);
    }
    .sidebar-lesson-item.active .sidebar-lesson-num   { background:var(--primary); color:#fff; }
    .sidebar-lesson-item.s-completed .sidebar-lesson-num { background:var(--secondary); color:#fff; }
    .sidebar-lesson-title {
        font-size:12px; font-weight:600; color:var(--text);
        flex:1; min-width:0;
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
    }
    .sidebar-lesson-item.active .sidebar-lesson-title { color:var(--primary); }

    /* ─── EMPTY STATE ─────────────────────────────────────── */
    .empty-state {
        padding:32px 20px; text-align:center;
        display:flex; flex-direction:column; align-items:center; gap:10px;
    }
    .empty-icon {
        width:46px; height:46px; border-radius:13px; background:var(--bg);
        display:flex; align-items:center; justify-content:center; font-size:20px;
    }
    .empty-title { font-size:14px; font-weight:600; color:var(--text); }
    .empty-sub   { font-size:12px; color:var(--muted); }

    /* ─── COMPLETE SECTION ────────────────────────────────── */
    .complete-section {
        border-radius:16px;
        border:2px dashed var(--border);
        padding:28px 24px;
        text-align:center;
        display:flex; flex-direction:column; align-items:center; gap:14px;
    }
    .complete-section.done {
        border-color:#BBF7D0; background:var(--s10);
    }
    .complete-icon { font-size:36px; }
    .complete-title { font-size:16px; font-weight:800; color:var(--text); letter-spacing:-0.3px; }
    .complete-sub   { font-size:13px; color:var(--muted); }

    /* ─── SECTION DIVIDER ─────────────────────────────────── */
    .section-label {
        font-size:11px; font-weight:700; color:var(--muted);
        letter-spacing:0.06em; text-transform:uppercase;
        padding:0 12px 6px;
    }

    /* ─── RESPONSIVE ──────────────────────────────────────── */
    @media (max-width:1023px) {
        .lesson-grid { grid-template-columns:1fr; }
        .lesson-col-side { position:static; order:-1; }
    }
    @media (max-width:767px) {
        .lesson-hero-body { padding:18px; }
        .lesson-hero-title { font-size:17px; }
        .lesson-hero-top { flex-direction:column; gap:10px; }
        .lesson-nav { flex-direction:column; }
        .lesson-nav .btn-primary,
        .lesson-nav .btn-success,
        .lesson-nav .btn-outline,
        .lesson-nav .btn-disabled { width:100%; justify-content:center; }
    }
</style>

@php
    $typeColor = $lesson->lesson_type_color;
    $typeBg    = $lesson->lesson_type_bg;
    $typeIcon  = $lesson->lesson_type_icon;
    $typeLabel = $lesson->lesson_type_label;
@endphp

<div style="max-width:1400px;margin:0 auto;display:flex;flex-direction:column;gap:20px;">

    {{-- ─── BREADCRUMB ──────────────────────────────────────── --}}
    <div class="section-fade d1">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dasbor</a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            <a href="{{ route('courses.index') }}">Kursus</a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            <span style="color:var(--text);font-weight:600;">{{ $lesson->title }}</span>
        </div>
    </div>

    {{-- ─── HERO ────────────────────────────────────────────── --}}
    <div class="section-fade d1">
        <div class="lesson-hero">
            <div class="lesson-hero-band" style="background:{{ $typeColor }};"></div>
            <div class="lesson-hero-body">
                <div class="lesson-hero-top">
                    <div class="lesson-hero-icon" style="background:{{ $typeBg }};">
                        {{ $typeIcon }}
                    </div>
                    <div class="lesson-hero-info">
                        <h1 class="lesson-hero-title">{{ $lesson->title }}</h1>
                        <div class="lesson-hero-badges">
                            <span class="badge" style="background:{{ $typeBg }};color:{{ $typeColor }};">{{ $typeLabel }}</span>
                            <span class="badge badge-muted">Pelajaran {{ $lessonNumber }} dari {{ $totalLessons }}</span>
                            @if($lesson->duration_minutes > 0)
                                <span class="badge badge-muted">{{ $lesson->duration_minutes }} menit</span>
                            @endif
                            @if($lesson->xp_reward > 0)
                                <span class="badge badge-amber">{{ $lesson->xp_reward }} XP</span>
                            @endif
                            @if($isCompleted)
                                <span class="badge badge-green">✓ Selesai</span>
                            @elseif($isInProgress)
                                <span class="badge badge-blue">Sedang Dipelajari</span>
                            @endif
                        </div>
                        @if($lesson->description)
                            <p style="font-size:13px;color:var(--muted);margin:10px 0 0;line-height:1.6;">{{ $lesson->description }}</p>
                        @endif
                    </div>
                </div>

                {{-- Progress kursus --}}
                <div class="prog-wrap">
                    <div class="prog-row">
                        <span class="prog-label">Progres kursus: {{ $completedCount }} / {{ $totalLessons }} selesai</span>
                        <span class="prog-pct">{{ $courseProgressPct }}%</span>
                    </div>
                    <div class="prog-track">
                        <div class="prog-fill" style="width:{{ $courseProgressPct }}%;background:{{ $course->color }};"></div>
                    </div>
                </div>

                {{-- Nav prev/next + complete --}}
                <div class="lesson-nav">
                    @if($prevLesson)
                        <a href="{{ route('courses.lessons.show', [$course->slug, $prevLesson->id]) }}" class="btn-outline">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            Sebelumnya
                        </a>
                    @else
                        <span class="btn-disabled">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            Sebelumnya
                        </span>
                    @endif

                    @if(! $isCompleted)
                        <form method="POST"
                              action="{{ route('courses.lessons.complete', [$course->slug, $lesson->id]) }}"
                              style="margin:0;">
                            @csrf
                            <button type="submit" class="btn-success">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Tandai Selesai
                            </button>
                        </form>
                    @else
                        <span class="btn-success" style="opacity:0.75;cursor:default;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Sudah Selesai
                        </span>
                    @endif

                    @if($nextLesson)
                        <a href="{{ route('courses.lessons.show', [$course->slug, $nextLesson->id]) }}" class="btn-primary">
                            Selanjutnya
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    @else
                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-primary" style="background:var(--secondary);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Selesai Kursus
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ─── MAIN GRID ───────────────────────────────────────── --}}
    <div class="lesson-grid">

        {{-- LEFT: Main Content --}}
        <div class="lesson-col-main">

            {{-- ── COMPLETED BANNER ──────────────────────────── --}}
            @if($isCompleted)
            <div class="section-fade d2">
                <div class="completed-banner">
                    <div class="completed-banner-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div>
                        <div class="completed-banner-title">Pelajaran Ini Sudah Selesai!</div>
                        <div class="completed-banner-sub">
                            Anda mendapatkan {{ $lesson->xp_reward > 0 ? $lesson->xp_reward . ' XP' : 'poin' }} dari pelajaran ini.
                            @if($nextLesson)
                                Lanjut ke pelajaran berikutnya.
                            @endif
                        </div>
                    </div>
                    @if($nextLesson)
                    <a href="{{ route('courses.lessons.show', [$course->slug, $nextLesson->id]) }}"
                       class="btn-primary" style="margin-left:auto;white-space:nowrap;">
                        Lanjut
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                    @endif
                </div>
            </div>
            @endif

            {{-- ── READING MATERIAL ───────────────────────────── --}}
            @if($lesson->content)
            <div class="section-fade d2">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:{{ $typeBg }};">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="{{ $typeColor }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                </svg>
                            </div>
                            <span class="card-title">Materi Pelajaran</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content-prose">
                            {!! $lesson->content !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- ── VOCABULARY ──────────────────────────────────── --}}
            @if($lesson->vocabularies->isNotEmpty())
            <div class="section-fade d3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#DBEAFE;">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                            </div>
                            <span class="card-title">Kosakata Matematika</span>
                        </div>
                        <span style="font-size:12px;font-weight:600;color:var(--muted);">{{ $lesson->vocabularies->count() }} kata</span>
                    </div>
                    <div class="card-body">
                        <div class="vocab-grid">
                            @foreach($lesson->vocabularies as $vocab)
                            <div class="vocab-card">
                                @if($vocab->image)
                                <img src="{{ $vocab->image_url }}" alt="{{ $vocab->term }}"
                                     style="width:100%;max-height:160px;object-fit:cover;border-radius:10px;margin-bottom:10px;">
                                @endif
                                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                                    <div class="vocab-term">{{ $vocab->term }}</div>
                                    @if($vocab->pronunciation)
                                        <span style="font-size:12px;color:var(--muted);font-style:italic;">/{{ $vocab->pronunciation }}/</span>
                                    @endif
                                    @if($vocab->difficulty)
                                        <span class="vocab-badge">{{ ucfirst($vocab->difficulty) }}</span>
                                    @endif
                                </div>
                                @if($vocab->mathematical_meaning)
                                    <div class="vocab-meaning">{{ $vocab->mathematical_meaning }}</div>
                                @endif
                                @if($vocab->formula)
                                    <div class="vocab-formula">{{ $vocab->formula }}</div>
                                @endif
                                @if($vocab->example)
                                    <div class="vocab-example">Contoh: {{ $vocab->example }}</div>
                                @endif
                                @if($vocab->example_sentence)
                                    <div class="vocab-example" style="margin-top:4px;">{{ $vocab->example_sentence }}</div>
                                @endif
                                <div class="vocab-row">
                                    @if($vocab->translation)
                                        <span class="vocab-field"><strong>Terjemahan:</strong> {{ $vocab->translation }}</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- ── QUIZ ─────────────────────────────────────────── --}}
            @if($lesson->quizzes->isNotEmpty())
            <div class="section-fade d4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:var(--a10);">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                                </svg>
                            </div>
                            <span class="card-title">Latihan & Kuis</span>
                        </div>
                        <span style="font-size:12px;font-weight:600;color:var(--muted);">{{ $lesson->quizzes->count() }} soal</span>
                    </div>
                    <div class="card-body">
                        <div class="quiz-grid">
                            @foreach($lesson->quizzes as $idx => $quiz)
                            <div class="quiz-card">
                                <div class="quiz-card-header">
                                    <div class="quiz-num">{{ $idx + 1 }}</div>
                                    <span style="font-size:13px;font-weight:600;color:var(--text);flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        Soal {{ $idx + 1 }}
                                    </span>
                                    <span class="quiz-type-badge">{{ $quiz->question_type_label }}</span>
                                    @if($quiz->xp_reward > 0)
                                        <span class="quiz-xp-badge">{{ $quiz->xp_reward }} XP</span>
                                    @endif
                                </div>
                                <div class="quiz-card-body">
                                    <div class="quiz-question-text">{{ $quiz->question }}</div>

                                    @if($quiz->question_type === 'multiple_choice' && ! empty($quiz->options))
                                        <div class="quiz-options">
                                            @foreach($quiz->options as $optKey => $optVal)
                                            <div class="quiz-option">
                                                <div class="quiz-option-key">{{ strtoupper($optKey) }}</div>
                                                <span>{{ $optVal }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    @elseif($quiz->question_type === 'true_false')
                                        <div class="quiz-options">
                                            <div class="quiz-option">
                                                <div class="quiz-option-key">A</div>
                                                <span>Benar</span>
                                            </div>
                                            <div class="quiz-option">
                                                <div class="quiz-option-key">B</div>
                                                <span>Salah</span>
                                            </div>
                                        </div>
                                    @elseif($quiz->question_type === 'fill_blank' || $quiz->question_type === 'typing' || $quiz->question_type === 'short_answer')
                                        <div class="quiz-option" style="border-style:dashed;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                            <span style="color:var(--muted);font-style:italic;">Isi jawaban Anda...</span>
                                        </div>
                                    @elseif($quiz->question_type === 'matching' && ! empty($quiz->options))
                                        <div class="quiz-options">
                                            @foreach($quiz->options as $optKey => $optVal)
                                            <div class="quiz-option">
                                                <div class="quiz-option-key">{{ is_numeric($optKey) ? $optKey + 1 : strtoupper($optKey) }}</div>
                                                <span>{{ $optVal }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    @elseif($quiz->question_type === 'ordering' && ! empty($quiz->options))
                                        <div class="quiz-options">
                                            @foreach($quiz->options as $optIdx => $optVal)
                                            <div class="quiz-option">
                                                <div class="quiz-option-key">{{ $optIdx + 1 }}</div>
                                                <span>{{ $optVal }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    @elseif($quiz->question_type === 'essay')
                                        <div class="quiz-option" style="border-style:dashed;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                                            <span style="color:var(--muted);font-style:italic;">Tulis jawaban esai Anda...</span>
                                        </div>
                                    @endif

                                    @if($isCompleted && $quiz->correct_answer)
                                        <div class="quiz-answer">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;margin-right:4px;"><polyline points="20 6 9 17 4 12"/></svg>
                                            Jawaban: {{ is_array($quiz->correct_answer) ? implode(', ', $quiz->correct_answer) : $quiz->correct_answer }}
                                        </div>
                                        @if($quiz->explanation)
                                            <div class="quiz-explanation">{{ $quiz->explanation }}</div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if(! $isCompleted)
                        <p style="font-size:12px;color:var(--muted);text-align:center;margin-top:14px;font-style:italic;">
                            Tandai pelajaran selesai untuk melihat jawaban & penjelasan.
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- ── EMPTY: no content --}}
            @if(! $lesson->content && $lesson->vocabularies->isEmpty() && $lesson->quizzes->isEmpty())
            <div class="section-fade d2">
                <div class="card">
                    <div class="empty-state">
                        <div class="empty-icon">📋</div>
                        <p class="empty-title">Materi Belum Tersedia</p>
                        <p class="empty-sub">Konten pelajaran ini sedang disiapkan. Silakan cek kembali nanti.</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- ── COMPLETION CTA ──────────────────────────────── --}}
            <div class="section-fade d5">
                <div class="complete-section {{ $isCompleted ? 'done' : '' }}">
                    @if($isCompleted)
                        <div class="complete-icon">🎉</div>
                        <div class="complete-title">Pelajaran Selesai!</div>
                        <div class="complete-sub">
                            Anda telah menyelesaikan pelajaran ini dan mendapatkan
                            <strong>{{ $lesson->xp_reward > 0 ? $lesson->xp_reward . ' XP' : 'poin penyelesaian' }}</strong>.
                        </div>
                        @if($nextLesson)
                            <a href="{{ route('courses.lessons.show', [$course->slug, $nextLesson->id]) }}" class="btn-primary">
                                Lanjut ke: {{ $nextLesson->title }}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @else
                            <a href="{{ route('courses.show', $course->slug) }}" class="btn-success">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Kembali ke Ringkasan Kursus
                            </a>
                        @endif
                    @else
                        <div class="complete-icon">✏️</div>
                        <div class="complete-title">Sudah Memahami Materi?</div>
                        <div class="complete-sub">
                            Tandai pelajaran ini sebagai selesai untuk melacak progres Anda
                            @if($lesson->xp_reward > 0)
                                dan mendapatkan <strong>{{ $lesson->xp_reward }} XP</strong>
                            @endif
                            .
                        </div>
                        <form method="POST"
                              action="{{ route('courses.lessons.complete', [$course->slug, $lesson->id]) }}"
                              style="margin:0;">
                            @csrf
                            <button type="submit" class="btn-success">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Tandai Selesai
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- ── BOTTOM NAV ──────────────────────────────────── --}}
            <div class="section-fade d6">
                <div style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                    @if($prevLesson)
                        <a href="{{ route('courses.lessons.show', [$course->slug, $prevLesson->id]) }}"
                           style="display:flex;align-items:center;gap:10px;background:var(--surface);border:1.5px solid var(--border);border-radius:14px;padding:14px 18px;text-decoration:none;color:inherit;flex:1;min-width:180px;transition:border-color 0.12s;"
                           onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            <div>
                                <div style="font-size:10px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:0.05em;">Sebelumnya</div>
                                <div style="font-size:13px;font-weight:700;color:var(--text);margin-top:1px;">{{ $prevLesson->title }}</div>
                            </div>
                        </a>
                    @else
                        <div style="flex:1;"></div>
                    @endif

                    @if($nextLesson)
                        <a href="{{ route('courses.lessons.show', [$course->slug, $nextLesson->id]) }}"
                           style="display:flex;align-items:center;gap:10px;background:var(--surface);border:1.5px solid var(--border);border-radius:14px;padding:14px 18px;text-decoration:none;color:inherit;flex:1;min-width:180px;justify-content:flex-end;text-align:right;transition:border-color 0.12s;"
                           onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                            <div>
                                <div style="font-size:10px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:0.05em;">Selanjutnya</div>
                                <div style="font-size:13px;font-weight:700;color:var(--text);margin-top:1px;">{{ $nextLesson->title }}</div>
                            </div>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    @else
                        <a href="{{ route('courses.show', $course->slug) }}"
                           style="display:flex;align-items:center;gap:10px;background:var(--s10);border:1.5px solid #BBF7D0;border-radius:14px;padding:14px 18px;text-decoration:none;color:inherit;flex:1;min-width:180px;justify-content:flex-end;text-align:right;">
                            <div>
                                <div style="font-size:10px;font-weight:600;color:#15803D;text-transform:uppercase;letter-spacing:0.05em;">Selesai!</div>
                                <div style="font-size:13px;font-weight:700;color:#15803D;margin-top:1px;">Kembali ke Kursus</div>
                            </div>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </a>
                    @endif
                </div>
            </div>

        </div>{{-- /lesson-col-main --}}

        {{-- RIGHT: Sidebar --}}
        <div class="lesson-col-side">

            {{-- Lesson List Sidebar --}}
            <div class="section-fade d2">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:var(--bg);">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                                    <line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/>
                                    <line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                                </svg>
                            </div>
                            <span class="card-title">Daftar Pelajaran</span>
                        </div>
                        <a href="{{ route('courses.show', $course->slug) }}"
                           style="font-size:11px;font-weight:600;color:var(--primary);text-decoration:none;">
                            Semua
                        </a>
                    </div>
                    <div class="sidebar-lesson-list">
                        @foreach($allLessons as $idx => $sLesson)
                        @php
                            $sCompleted = in_array($sLesson->id, $completedLessonIds);
                            $sActive    = $sLesson->id === $lesson->id;
                            $sClass     = $sActive ? 'active' : ($sCompleted ? 's-completed' : '');
                        @endphp
                        <a href="{{ route('courses.lessons.show', [$course->slug, $sLesson->id]) }}"
                           class="sidebar-lesson-item {{ $sClass }}">
                            <div class="sidebar-lesson-num">
                                @if($sCompleted && ! $sActive)
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                @else
                                    {{ $idx + 1 }}
                                @endif
                            </div>
                            <div class="sidebar-lesson-title">{{ $sLesson->title }}</div>
                            @if($sLesson->xp_reward > 0)
                                <span style="font-size:9px;font-weight:700;color:var(--accent);flex-shrink:0;">{{ $sLesson->xp_reward }}xp</span>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Lesson Info --}}
            <div class="section-fade d3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:var(--bg);">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                            </div>
                            <span class="card-title">Info Pelajaran</span>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;">
                        @php
                            $infoRows = [
                                ['label'=>'Tipe','value'=>$typeLabel,'color'=>$typeColor,'bg'=>$typeBg],
                                ['label'=>'Durasi','value'=>($lesson->duration_minutes > 0 ? $lesson->duration_minutes.' menit' : '-'),'color'=>null,'bg'=>null],
                                ['label'=>'XP Reward','value'=>($lesson->xp_reward > 0 ? $lesson->xp_reward.' XP' : '-'),'color'=>'#92400E','bg'=>'#FFFBEB'],
                                ['label'=>'Kosakata','value'=>$lesson->vocabularies->count(),'color'=>null,'bg'=>null],
                                ['label'=>'Soal Kuis','value'=>$lesson->quizzes->count(),'color'=>null,'bg'=>null],
                                ['label'=>'Status','value'=>($isCompleted ? 'Selesai' : ($isInProgress ? 'Sedang Dipelajari' : 'Belum Dimulai')),'color'=>($isCompleted ? '#15803D' : ($isInProgress ? '#1D4ED8' : null)),'bg'=>($isCompleted ? '#F0FDF4' : ($isInProgress ? '#EFF6FF' : null))],
                            ];
                        @endphp
                        @foreach($infoRows as $row)
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:11px 20px;border-bottom:1px solid #F8FAFC;">
                            <span style="font-size:12px;font-weight:500;color:var(--muted);">{{ $row['label'] }}</span>
                            @if($row['color'] && $row['bg'])
                                <span style="font-size:12px;font-weight:700;background:{{ $row['bg'] }};color:{{ $row['color'] }};padding:2px 8px;border-radius:99px;">{{ $row['value'] }}</span>
                            @else
                                <span style="font-size:13px;font-weight:700;color:var(--text);">{{ $row['value'] }}</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Back to Course --}}
            <div class="section-fade d4">
                <a href="{{ route('courses.show', $course->slug) }}"
                   style="display:flex;align-items:center;gap:12px;background:var(--surface);border:1.5px solid var(--border);border-radius:14px;padding:14px 18px;text-decoration:none;color:inherit;transition:border-color 0.12s;"
                   onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                    <div style="width:36px;height:36px;border-radius:9px;background:var(--bg);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:10px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:0.05em;">Kursus</div>
                        <div style="font-size:13px;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $course->title }}</div>
                        <div style="font-size:11px;color:var(--muted);margin-top:1px;">{{ $courseProgressPct }}% selesai</div>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>

        </div>{{-- /lesson-col-side --}}

    </div>{{-- /lesson-grid --}}

</div>

@push('scripts')
<script>
// Render MathJax jika konten pelajaran mengandung formula matematika
if (document.querySelector('.content-prose .math-block')) {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js';
    script.async = true;
    document.head.appendChild(script);
}
</script>
@endpush

</x-app-layout>