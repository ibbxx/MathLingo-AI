<x-app-layout>

@section('page-title', $lesson->title . ' — Quiz')

<style>
    :root {
        --primary:   #2563EB; --p10: #EFF6FF;
        --secondary: #22C55E; --s10: #F0FDF4;
        --accent:    #F59E0B; --a10: #FFFBEB;
        --danger:    #EF4444;
        --bg:        #F8FAFC; --surface: #FFFFFF; --border: #E5E7EB;
        --text:      #1E293B; --muted: #64748B;
        --r-card:    20px;
        --shadow:    0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 8px rgba(0,0,0,0.08),0 12px 32px rgba(0,0,0,0.08);
    }

    .page-wrap { padding: 28px; display: flex; flex-direction: column; gap: 20px; max-width: 980px; }

    .breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; font-weight:500; color:var(--muted); }
    .breadcrumb a { color:var(--muted); text-decoration:none; }
    .breadcrumb a:hover { color:var(--primary); }

    .page-hero {
        background: {{ $lesson->course->color ?? '#2563EB' }}; border-radius: var(--r-card);
        padding: 28px 32px; position: relative; overflow: hidden;
    }
    .page-hero::before { content:''; position:absolute; top:-60px; right:-60px; width:220px; height:220px; border-radius:50%; background:rgba(255,255,255,0.05); }
    .page-hero-course { font-size:12px; font-weight:700; color:rgba(255,255,255,0.75); text-transform:uppercase; letter-spacing:0.06em; position:relative; z-index:1; }
    .page-hero-title { font-size:23px; font-weight:800; color:#fff; margin:4px 0 0; position:relative; z-index:1; }

    .type-tabs { display:flex; gap:8px; background:var(--surface); padding:6px; border-radius:14px; box-shadow:var(--shadow); width:fit-content; }
    .type-tab {
        padding:9px 18px; border-radius:10px; font-size:13px; font-weight:700; color:var(--muted);
        cursor:pointer; border:none; background:transparent; font-family:inherit; display:flex; align-items:center; gap:7px;
    }
    .type-tab.active { background:var(--primary); color:#fff; }

    .quiz-panel { display:none; flex-direction:column; gap:16px; }
    .quiz-panel.active { display:flex; }

    .type-tab-badge {
        font-size: 10.5px; font-weight: 800; padding: 1px 7px; border-radius: 99px;
        background: rgba(255,255,255,0.25); color: inherit;
    }
    .type-tab:not(.active) .type-tab-badge { background: var(--p10); color: var(--primary); }

    .start-card {
        background: var(--surface); border-radius: var(--r-card); box-shadow: var(--shadow);
        padding: 32px 30px; text-align:center; border: 1px solid var(--border);
    }
    .start-icon {
        width:60px; height:60px; border-radius:18px; margin:0 auto 16px; display:flex;
        align-items:center; justify-content:center;
    }
    .start-icon.mc    { background:#DBEAFE; color:#1D4ED8; }
    .start-icon.essay { background:#EDE9FE; color:#6D28D9; }
    .start-title { font-size:16px; font-weight:800; color:var(--text); margin-bottom:6px; }
    .start-sub   { font-size:13px; color:var(--muted); margin-bottom:22px; }

    .progress-track {
        width:100%; max-width:380px; margin:0 auto 22px; background:var(--bg); border-radius:99px;
        height:10px; overflow:hidden; border:1px solid var(--border);
    }
    .progress-fill { height:100%; background:var(--primary); border-radius:99px; transition:width .2s; }
    .progress-caption { font-size:12.5px; font-weight:700; color:var(--muted); margin-top:8px; }
    .progress-caption b { color:var(--primary); }

    .start-actions { display:flex; justify-content:center; gap:10px; flex-wrap:wrap; }
    .btn-start {
        padding:13px 30px; border-radius:12px; background:var(--primary); color:#fff;
        font-size:14px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:8px; border:none; cursor:pointer;
    }
    .btn-start.done { background:var(--secondary); }
    .btn-ghost {
        padding:13px 24px; border-radius:12px; background:#fff; border:1.5px solid var(--border); color:var(--text);
        font-size:14px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:8px;
    }

    .empty-inline { text-align: center; padding: 40px 20px; color: var(--muted); font-size: 13.5px; background: var(--surface); border-radius: 16px; box-shadow: var(--shadow); }
</style>

<div class="page-wrap">

    <div class="breadcrumb">
        <a href="{{ route('quiz.index') }}">Quiz</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--text);font-weight:600;">{{ $lesson->title }}</span>
    </div>

    <div class="page-hero">
        <div class="page-hero-course">{{ $lesson->course->title ?? 'Umum' }}</div>
        <h1 class="page-hero-title">{{ $lesson->title }}</h1>
    </div>

    <div class="type-tabs">
        @if($mcQuizzes->isNotEmpty())
            <button type="button" class="type-tab {{ $mcQuizzes->isNotEmpty() ? 'active' : '' }}" onclick="showQuizTab('mc', this)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Multiple Choice ({{ $mcQuizzes->count() }})
                <span class="type-tab-badge">{{ $progress['mc']['answered'] }}/{{ $progress['mc']['total'] }}</span>
            </button>
        @endif
        @if($essayQuizzes->isNotEmpty())
            <button type="button" class="type-tab {{ $mcQuizzes->isEmpty() ? 'active' : '' }}" onclick="showQuizTab('essay', this)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7V4h16v3"/><path d="M9 20h6"/><path d="M12 4v16"/></svg>
                Essay - Susun Kata ({{ $essayQuizzes->count() }})
                <span class="type-tab-badge">{{ $progress['essay']['answered'] }}/{{ $progress['essay']['total'] }}</span>
            </button>
        @endif
    </div>

    {{-- Panel Multiple Choice --}}
    <div class="quiz-panel {{ $mcQuizzes->isNotEmpty() ? 'active' : '' }}" id="panel-mc">
        @if($mcQuizzes->isNotEmpty())
            @php
                $mcDone = $progress['mc']['answered'] >= $progress['mc']['total'];
            @endphp
            <div class="start-card">
                <div class="start-icon mc">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <div class="start-title">Quiz Multiple Choice</div>
                <div class="start-sub">{{ $mcQuizzes->count() }} soal · {{ $mcQuizzes->sum('xp_reward') }} XP total</div>

                <div class="progress-track"><div class="progress-fill" style="width: {{ $progress['mc']['total'] > 0 ? round($progress['mc']['answered'] / $progress['mc']['total'] * 100) : 0 }}%;"></div></div>
                <div class="progress-caption">Sudah dikerjakan <b>{{ $progress['mc']['answered'] }}/{{ $progress['mc']['total'] }}</b> soal
                    @if($progress['mc']['answered'] > 0) · <b>{{ $progress['mc']['xp'] }} XP</b> diperoleh @endif
                </div>

                <div class="start-actions" style="margin-top:22px;">
                    <a href="{{ route('quiz.lesson.play', ['lesson' => $lesson->id, 'type' => 'mc']) }}" class="btn-start {{ $mcDone ? 'done' : '' }}">
                        @if($progress['mc']['answered'] === 0)
                            Mulai Quiz
                        @elseif(!$mcDone)
                            Lanjutkan Quiz
                        @else
                            Kerjakan Ulang
                        @endif
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                    @if($progress['mc']['answered'] > 0)
                        <a href="{{ route('quiz.lesson.result', ['lesson' => $lesson->id, 'type' => 'mc']) }}" class="btn-ghost">Lihat Hasil</a>
                    @endif
                </div>
            </div>
        @else
            <div class="empty-inline">Belum ada soal Multiple Choice di pelajaran ini.</div>
        @endif
    </div>

    {{-- Panel Essay / Susun Kata --}}
    <div class="quiz-panel {{ $mcQuizzes->isEmpty() ? 'active' : '' }}" id="panel-essay">
        @if($essayQuizzes->isNotEmpty())
            @php
                $essayDone = $progress['essay']['answered'] >= $progress['essay']['total'];
            @endphp
            <div class="start-card">
                <div class="start-icon essay">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7V4h16v3"/><path d="M9 20h6"/><path d="M12 4v16"/></svg>
                </div>
                <div class="start-title">Quiz Essay (Susun Kata)</div>
                <div class="start-sub">{{ $essayQuizzes->count() }} soal · {{ $essayQuizzes->sum('xp_reward') }} XP total</div>

                <div class="progress-track"><div class="progress-fill" style="width: {{ $progress['essay']['total'] > 0 ? round($progress['essay']['answered'] / $progress['essay']['total'] * 100) : 0 }}%;"></div></div>
                <div class="progress-caption">Sudah dikerjakan <b>{{ $progress['essay']['answered'] }}/{{ $progress['essay']['total'] }}</b> soal
                    @if($progress['essay']['answered'] > 0) · <b>{{ $progress['essay']['xp'] }} XP</b> diperoleh @endif
                </div>

                <div class="start-actions" style="margin-top:22px;">
                    <a href="{{ route('quiz.lesson.play', ['lesson' => $lesson->id, 'type' => 'essay']) }}" class="btn-start {{ $essayDone ? 'done' : '' }}">
                        @if($progress['essay']['answered'] === 0)
                            Mulai Quiz
                        @elseif(!$essayDone)
                            Lanjutkan Quiz
                        @else
                            Kerjakan Ulang
                        @endif
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                    @if($progress['essay']['answered'] > 0)
                        <a href="{{ route('quiz.lesson.result', ['lesson' => $lesson->id, 'type' => 'essay']) }}" class="btn-ghost">Lihat Hasil</a>
                    @endif
                </div>
            </div>
        @else
            <div class="empty-inline">Belum ada soal Essay (Susun Kata) di pelajaran ini.</div>
        @endif
    </div>

</div>

<script>
function showQuizTab(tab, btn) {
    document.querySelectorAll('.type-tab').forEach(function (el) { el.classList.remove('active'); });
    document.querySelectorAll('.quiz-panel').forEach(function (el) { el.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('panel-' + tab).classList.add('active');
}
</script>

</x-app-layout>
