<x-app-layout>

@section('page-title', 'Hasil Quiz')

<style>
    html { scroll-behavior: smooth; }
    :root {
        --primary:   #2563EB; --p10: #EFF6FF;
        --secondary: #22C55E; --s10: #F0FDF4;
        --danger:    #EF4444; --d10: #FEF2F2;
        --accent:    #F59E0B; --a10: #FFFBEB;
        --bg:        #F8FAFC; --surface: #FFFFFF; --border: #E5E7EB;
        --text:      #1E293B; --muted: #64748B;
        --r-card:    20px;
        --shadow:    0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05);
    }

    .page-wrap { padding: 28px; display: flex; flex-direction: column; gap: 18px; max-width: 760px; margin: 0 auto; }

    .breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; font-weight:500; color:var(--muted); }
    .breadcrumb a { color:var(--muted); text-decoration:none; }
    .breadcrumb a:hover { color:var(--primary); }

    .result-hero {
        background: linear-gradient(135deg, var(--primary), #1D4ED8);
        border-radius: var(--r-card); padding: 32px; text-align: center; color: #fff;
        position: relative; overflow: hidden;
    }
    .result-hero::before { content:''; position:absolute; top:-70px; right:-70px; width:220px; height:220px; border-radius:50%; background:rgba(255,255,255,0.08); }
    .result-hero-label { font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; opacity:0.8; position:relative; z-index:1; }
    .result-hero-title { font-size:22px; font-weight:800; margin:4px 0 18px; position:relative; z-index:1; }

    .result-stats { display:grid; grid-template-columns: repeat(3, 1fr); gap:12px; position:relative; z-index:1; }
    .result-stat { background:rgba(255,255,255,0.12); border-radius:14px; padding:14px 10px; }
    .result-stat-num { font-size:22px; font-weight:800; }
    .result-stat-label { font-size:11.5px; opacity:0.85; margin-top:2px; }

    .xp-banner {
        display:flex; align-items:center; justify-content:center; gap:8px;
        background: var(--a10); border: 1.5px solid #FDE68A; color:#B45309;
        border-radius:14px; padding:14px; font-size:14px; font-weight:800;
    }

    .result-list { background: var(--surface); border-radius: var(--r-card); box-shadow: var(--shadow); overflow:hidden; }
    .result-row {
        display:flex; align-items:center; gap:12px; padding:14px 20px;
        border-bottom:1px solid var(--border);
    }
    .result-row:last-child { border-bottom: none; }
    a.result-row { text-decoration:none; cursor:pointer; transition: background .12s; }
    a.result-row:hover { background: var(--bg); }
    .result-row-chevron { color: var(--muted); flex-shrink:0; }
    .result-row-icon {
        width:30px; height:30px; border-radius:9px; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
    }
    .result-row-icon.benar { background: var(--s10); color:#16A34A; }
    .result-row-icon.salah { background: var(--d10); color: var(--danger); }
    .result-row-icon.belum { background: #F1F5F9; color: var(--muted); }
    .result-row-question {
        flex:1; min-width:0; font-size:13.5px; font-weight:600; color:var(--text);
        display:-webkit-box; -webkit-line-clamp:1; -webkit-box-orient:vertical; overflow:hidden;
    }
    .result-row-xp { font-size:12px; font-weight:700; color: var(--muted); flex-shrink:0; }
    .result-row-xp.earned { color: #16A34A; }

    .result-actions { display:flex; gap:10px; justify-content:center; flex-wrap:wrap; }
    .btn-secondary, .btn-primary {
        padding:11px 22px; border-radius:12px; font-size:13.5px; font-weight:700;
        text-decoration:none; display:inline-flex; align-items:center; gap:8px;
    }
    .btn-secondary { background:#fff; border:1.5px solid var(--border); color:var(--text); }
    .btn-primary { background:var(--primary); color:#fff; }
</style>

<div class="page-wrap">

    <div class="breadcrumb">
        <a href="{{ route('quiz.index') }}">Quiz</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('quiz.lesson', $lesson->id) }}">{{ $lesson->title }}</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--text);font-weight:600;">Hasil</span>
    </div>

    <div class="result-hero">
        <div class="result-hero-label">{{ $type === 'mc' ? 'Multiple Choice' : 'Essay (Susun Kata)' }}</div>
        <div class="result-hero-title">Hasil Quiz — {{ $lesson->title }}</div>
        <div class="result-stats">
            <div class="result-stat">
                <div class="result-stat-num">{{ $totalBenar }}</div>
                <div class="result-stat-label">Benar</div>
            </div>
            <div class="result-stat">
                <div class="result-stat-num">{{ $totalSalah }}</div>
                <div class="result-stat-label">Salah</div>
            </div>
            <div class="result-stat">
                <div class="result-stat-num">{{ $totalDijawab }}/{{ $totalSoal }}</div>
                <div class="result-stat-label">Dikerjakan</div>
            </div>
        </div>
    </div>

    <div class="xp-banner">
        ⚡ Total XP diperoleh dari sesi ini: {{ $totalXp }} XP
    </div>

    <div style="font-size:12.5px; color:var(--muted); font-weight:600; padding:0 4px;">
        Ketuk salah satu soal di bawah untuk melihat detail & kunci jawabannya.
    </div>

    <div class="result-list" id="reviewList" style="scroll-margin-top: 20px;">
        @foreach($rows as $row)
            @php
                $isAnswered = $row['status'] !== 'belum';
                $tag = $isAnswered ? 'a' : 'div';
            @endphp
            <{{ $tag }}
                @if($isAnswered) href="{{ route('quiz.show', $row['quiz']->id) }}?review=1" @endif
                class="result-row"
            >
                <div class="result-row-icon {{ $row['status'] }}">
                    @if($row['status'] === 'benar')
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    @elseif($row['status'] === 'salah')
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    @else
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>
                    @endif
                </div>
                <div class="result-row-question">{{ $row['quiz']->question }}</div>
                <div class="result-row-xp {{ $row['xp_earned'] > 0 ? 'earned' : '' }}">
                    {{ $row['xp_earned'] > 0 ? '+' . $row['xp_earned'] . ' XP' : '0 XP' }}
                </div>
                @if($isAnswered)
                    <svg class="result-row-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                @endif
            </{{ $tag }}>
        @endforeach
    </div>

    <div class="result-actions">
        <a href="{{ route('quiz.lesson', $lesson->id) }}" class="btn-primary">
            Kembali ke Halaman Quiz
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>

</div>

</x-app-layout>
