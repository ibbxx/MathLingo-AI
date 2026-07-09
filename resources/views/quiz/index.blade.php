<x-app-layout>

@section('page-title', 'Quiz')

<style>
    :root {
        --primary:   #2563EB;
        --p10:       #EFF6FF;
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

    .page-wrap { padding: 28px; display: flex; flex-direction: column; gap: 20px; }

    .page-hero {
        background: var(--primary); border-radius: var(--r-card);
        padding: 32px 36px; position: relative; overflow: hidden;
    }
    .page-hero::before {
        content:''; position:absolute; top:-60px; right:-60px;
        width:240px; height:240px; border-radius:50%; background:rgba(255,255,255,0.05);
    }
    .page-hero-title { font-size:26px; font-weight:800; color:#fff; letter-spacing:-0.4px; margin:0 0 6px; position:relative; z-index:1; }
    .page-hero-sub   { font-size:14px; color:rgba(255,255,255,0.8); margin:0; max-width:560px; line-height:1.6; position:relative; z-index:1; }

    .lesson-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 18px;
    }
    .lesson-card {
        background: var(--surface); border-radius: var(--r-card); box-shadow: var(--shadow);
        overflow: hidden; text-decoration: none; color: inherit; display: flex; flex-direction: column;
        transition: transform 0.15s, box-shadow 0.15s; border: 1px solid var(--border);
    }
    .lesson-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
    .lesson-card-band { height: 6px; }
    .lesson-card-body { padding: 20px; display: flex; flex-direction: column; gap: 10px; flex: 1; }
    .lesson-card-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .lesson-card-icon {
        width: 38px; height: 38px; border-radius: 11px; display: flex; align-items: center;
        justify-content: center; flex-shrink: 0;
    }
    .lesson-course-pill {
        font-size: 11px; font-weight: 700; color: var(--muted); background: var(--bg);
        padding: 4px 9px; border-radius: 99px; letter-spacing: 0.02em;
    }
    .lesson-card-title { font-size: 15.5px; font-weight: 800; color: var(--text); letter-spacing: -0.2px; line-height: 1.35; }

    .lesson-type-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 2px; }
    .lesson-type-tag {
        display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 700;
        padding: 5px 10px; border-radius: 8px;
    }
    .tag-mc    { background: #DBEAFE; color: #1D4ED8; }
    .tag-essay { background: #EDE9FE; color: #6D28D9; }

    .lesson-card-footer {
        display: flex; align-items: center; justify-content: space-between; margin-top: auto;
        padding-top: 12px; border-top: 1px solid var(--border);
    }
    .lesson-card-count { font-size: 12.5px; font-weight: 600; color: var(--muted); }
    .lesson-card-cta {
        font-size: 12.5px; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 4px;
    }

    .empty-state {
        background: var(--surface); border-radius: var(--r-card); box-shadow: var(--shadow);
        padding: 60px 24px; text-align: center;
    }
    .empty-icon {
        width: 56px; height: 56px; border-radius: 16px; background: var(--p10); color: var(--primary);
        display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
    }
    .empty-title { font-size: 15px; font-weight: 700; color: var(--text); margin: 0 0 6px; }
    .empty-sub   { font-size: 13px; color: var(--muted); margin: 0; }
</style>

<div class="page-wrap">

    <div class="page-hero">
        <h1 class="page-hero-title">Quiz</h1>
        <p class="page-hero-sub">Pilih pelajaran di bawah untuk mengerjakan soal Multiple Choice atau Essay (Susun Kata) dan kumpulkan XP.</p>
    </div>

    @if($lessons->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 1 1 5.82 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
            </div>
            <p class="empty-title">Belum ada quiz tersedia</p>
            <p class="empty-sub">Admin belum menambahkan soal quiz aktif untuk pelajaran manapun.</p>
        </div>
    @else
        <div class="lesson-grid">
            @foreach($lessons as $lesson)
                @php $color = $lesson->course->color ?? '#2563EB'; @endphp
                <a href="{{ route('quiz.lesson', $lesson->id) }}" class="lesson-card">
                    <div class="lesson-card-band" style="background:{{ $color }};"></div>
                    <div class="lesson-card-body">
                        <div class="lesson-card-top">
                            <span class="lesson-course-pill">{{ $lesson->course->title ?? 'Umum' }}</span>
                            <div class="lesson-card-icon" style="background:{{ $color }}1A;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 1 1 5.82 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                            </div>
                        </div>

                        <div class="lesson-card-title">{{ $lesson->title }}</div>

                        <div class="lesson-type-tags">
                            @if($lesson->mc_count > 0)
                                <span class="lesson-type-tag tag-mc">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                    {{ $lesson->mc_count }} Multiple Choice
                                </span>
                            @endif
                            @if($lesson->essay_count > 0)
                                <span class="lesson-type-tag tag-essay">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7V4h16v3"/><path d="M9 20h6"/><path d="M12 4v16"/></svg>
                                    {{ $lesson->essay_count }} Essay (Susun Kata)
                                </span>
                            @endif
                        </div>

                        <div class="lesson-card-footer">
                            <span class="lesson-card-count">{{ $lesson->quiz_count }} soal tersedia</span>
                            <span class="lesson-card-cta">
                                Mulai
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>

</x-app-layout>
