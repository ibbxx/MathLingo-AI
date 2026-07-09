<x-app-layout>

@section('page-title', 'Detail Quiz Siswa')

<style>
    .admin-page { padding: 28px 28px 40px; }
    .admin-page-header { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom: 20px; flex-wrap:wrap; }
    .admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; }
    .admin-page-sub   { font-size: 13.5px; color: var(--color-muted); margin: 0; }

    .btn-back {
        display:inline-flex; align-items:center; gap:6px;
        padding:8px 14px; border-radius:9px; font-size:13px; font-weight:700;
        background:#fff; border:1.5px solid var(--color-border); color:var(--color-text); text-decoration:none;
    }

    .stat-row { display:grid; grid-template-columns: repeat(4, 1fr); gap:14px; margin-bottom:20px; }
    .stat-card { background:var(--color-surface); border:1px solid var(--color-border); border-radius:var(--radius-card); box-shadow:var(--shadow-card); padding:16px 18px; }
    .stat-card-num { font-size:22px; font-weight:800; color:var(--color-text); }
    .stat-card-label { font-size:12px; font-weight:600; color:var(--color-muted); margin-top:2px; }

    .filter-row { margin-bottom: 16px; }
    .filter-row select {
        padding: 8px 12px; border: 1.5px solid var(--color-border); border-radius: 9px;
        font-size: 13px; font-family: inherit; background:#fff;
    }

    .lesson-group { margin-bottom:22px; }
    .lesson-group-title {
        font-size:14px; font-weight:800; color:var(--color-text);
        margin:0 0 10px; display:flex; align-items:center; gap:8px;
    }

    .review-list { background: var(--color-surface); border:1px solid var(--color-border); border-radius: var(--radius-card); box-shadow: var(--shadow-card); overflow:hidden; }
    .review-row {
        display:flex; align-items:center; gap:12px; padding:14px 18px;
        border-bottom:1px solid var(--color-border);
    }
    .review-row:last-child { border-bottom: none; }
    .review-row-icon {
        width:30px; height:30px; border-radius:9px; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
    }
    .review-row-icon.benar { background:#F0FDF4; color:#16A34A; }
    .review-row-icon.salah { background:#FEF2F2; color:#EF4444; }
    .review-row-icon.belum { background:#F1F5F9; color:var(--color-muted); }
    .review-row-body { flex:1; min-width:0; }
    .review-row-question { font-size:13.5px; font-weight:600; color:var(--color-text); }
    .review-row-meta { font-size:12px; color:var(--color-muted); margin-top:2px; }
    .review-row-xp { font-size:12px; font-weight:700; color:var(--color-muted); flex-shrink:0; white-space:nowrap; }
    .review-row-xp.earned { color:#16A34A; }

    .empty-state { text-align:center; color:var(--color-muted); padding:40px 20px; background:var(--color-surface); border:1px solid var(--color-border); border-radius:var(--radius-card); }
</style>

<div class="admin-page">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Detail Quiz — {{ $user->name }}</h1>
            <p class="admin-page-sub">{{ $user->email }} · Review jawaban per soal yang pernah dikerjakan.</p>
        </div>
        <a href="{{ route('admin.quiz-attempts.index') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-card-num">{{ $stats['total_dikerjakan'] }}</div>
            <div class="stat-card-label">Dikerjakan</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-num" style="color:#16A34A;">{{ $stats['total_benar'] }}</div>
            <div class="stat-card-label">Benar</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-num" style="color:#EF4444;">{{ $stats['total_salah'] }}</div>
            <div class="stat-card-label">Salah</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-num" style="color:#2563EB;">{{ $stats['total_xp'] }}</div>
            <div class="stat-card-label">Total XP</div>
        </div>
    </div>

    @if($lessons->count() > 1)
        <form method="GET" class="filter-row">
            <select name="lesson_id" onchange="this.form.submit()">
                <option value="">Semua Pelajaran</option>
                @foreach($lessons as $lesson)
                    <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>{{ $lesson->title }}</option>
                @endforeach
            </select>
        </form>
    @endif

    @forelse($byLesson as $lessonTitle => $attempts)
        <div class="lesson-group">
            <h2 class="lesson-group-title">{{ $lessonTitle }}</h2>
            <div class="review-list">
                @foreach($attempts as $attempt)
                    @php $quiz = $attempt->quiz; @endphp
                    <div class="review-row">
                        <div class="review-row-icon {{ $attempt->is_correct === null ? 'belum' : ($attempt->is_correct ? 'benar' : 'salah') }}">
                            @if($attempt->is_correct === true)
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            @elseif($attempt->is_correct === false)
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            @else
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>
                            @endif
                        </div>
                        <div class="review-row-body">
                            <div class="review-row-question">{{ $quiz->question ?? 'Soal telah dihapus' }}</div>
                            <div class="review-row-meta">
                                {{ $quiz->question_type_label ?? '—' }}
                                @if($quiz && $quiz->question_type !== 'word_arrange' && ! ($quiz->question_type === 'essay' && ! empty($quiz->options)))
                                    · Jawaban benar: <strong>{{ $quiz->correct_answer }}</strong>
                                @endif
                                @if($attempt->answered_at)
                                    · {{ $attempt->answered_at->format('d M Y, H:i') }}
                                @endif
                                @if($attempt->attempt_count > 1)
                                    · {{ $attempt->attempt_count }}x percobaan
                                @endif
                            </div>
                        </div>
                        <div class="review-row-xp {{ $attempt->xp_earned > 0 ? 'earned' : '' }}">
                            {{ $attempt->xp_earned > 0 ? '+' . $attempt->xp_earned . ' XP' : '0 XP' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="empty-state">Siswa ini belum mengerjakan quiz apa pun.</div>
    @endforelse
</div>

</x-app-layout>
