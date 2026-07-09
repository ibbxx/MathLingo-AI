<x-admin-layout title="Detail Pelajaran">

@push('styles')
<style>
.admin-page { padding: 28px 28px 40px; max-width: 960px; }
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub   { font-size: 13.5px; color: var(--color-muted); margin: 0; }

.breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 500; color: var(--color-muted);
    margin-bottom: 16px;
}
.breadcrumb a { color: var(--color-muted); text-decoration: none; }
.breadcrumb a:hover { color: var(--color-primary); }

.panel {
    background: var(--color-surface); border: 1px solid var(--color-border);
    border-radius: var(--radius-card); box-shadow: var(--shadow-card);
    overflow: hidden; margin-bottom: 16px;
}
.panel-header {
    padding: 18px 24px 16px; border-bottom: 1px solid var(--color-border);
    display: flex; align-items: center; gap: 10px;
}
.panel-header-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: var(--color-primary-10); color: var(--color-primary);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.panel-title { font-size: 14px; font-weight: 700; color: var(--color-text); }
.panel-body  { padding: 20px 24px; }

/* Info grid */
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.info-item { display: flex; flex-direction: column; gap: 4px; }
.info-label { font-size: 11.5px; font-weight: 700; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.05em; }
.info-value { font-size: 14px; font-weight: 600; color: var(--color-text); }
.info-item.full { grid-column: 1 / -1; }

.type-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 7px;
    font-size: 12.5px; font-weight: 700;
}
.status-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 7px;
    font-size: 12.5px; font-weight: 700;
}
.status-active   { background: #F0FDF4; color: #166534; }
.status-inactive { background: #F8FAFC; color: #64748B; }

/* Stat cards */
.stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
.stat-mini {
    background: var(--color-bg); border: 1px solid var(--color-border);
    border-radius: 12px; padding: 14px 16px; text-align: center;
}
.stat-mini-value { font-size: 20px; font-weight: 800; color: var(--color-primary); line-height: 1; }
.stat-mini-label { font-size: 11.5px; color: var(--color-muted); font-weight: 500; margin-top: 4px; }

/* Content preview */
.content-preview {
    font-size: 14px; line-height: 1.8; color: var(--color-text);
    padding: 20px 24px;
}
.content-preview h2 { font-size: 18px; font-weight: 700; margin: 16px 0 8px; }
.content-preview h3 { font-size: 15px; font-weight: 700; margin: 14px 0 6px; }
.content-preview ul, .content-preview ol { padding-left: 20px; margin: 8px 0; }
.content-preview li { margin: 4px 0; }
.content-preview table { border-collapse: collapse; width: 100%; margin: 12px 0; }
.content-preview th, .content-preview td { border: 1px solid var(--color-border); padding: 8px 10px; font-size: 13.5px; }
.content-preview th { background: #F8FAFC; font-weight: 700; }
.content-preview blockquote { border-left: 3px solid var(--color-primary); padding-left: 14px; color: var(--color-muted); margin: 12px 0; }
.content-preview code { background: #F1F5F9; padding: 1px 6px; border-radius: 4px; font-size: 13px; font-family: monospace; }
.content-empty { font-size: 13.5px; color: var(--color-muted); font-style: italic; padding: 20px 24px; }

/* Navigation */
.nav-prev-next {
    display: flex; gap: 12px;
}
.nav-card {
    flex: 1; padding: 14px 16px; border: 1px solid var(--color-border);
    border-radius: 12px; text-decoration: none; color: var(--color-text);
    transition: border-color 0.12s, box-shadow 0.12s; display: flex; flex-direction: column; gap: 4px;
}
.nav-card:hover { border-color: var(--color-primary); box-shadow: 0 2px 8px rgba(37,99,235,0.08); }
.nav-card-dir { font-size: 11px; font-weight: 700; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.05em; }
.nav-card-title { font-size: 13.5px; font-weight: 700; }
.nav-card-meta  { font-size: 12px; color: var(--color-muted); }
.nav-card.disabled { opacity: 0.4; pointer-events: none; }

/* Action bar */
.action-bar {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
}
.btn-action {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: 9px; border: 1.5px solid var(--color-border);
    font-size: 13px; font-weight: 600; font-family: inherit; cursor: pointer;
    text-decoration: none; color: var(--color-muted); background: transparent;
    transition: border-color 0.12s, color 0.12s, background 0.12s;
}
.btn-action:hover { border-color: var(--color-primary); color: var(--color-primary); background: var(--color-primary-10); }
.btn-action.primary { background: var(--color-primary); color: #fff; border-color: var(--color-primary); }
.btn-action.primary:hover { opacity: 0.88; background: var(--color-primary); color: #fff; }
.btn-action.danger { border-color: var(--color-danger); color: var(--color-danger); }
.btn-action.danger:hover { background: #FEF2F2; }

/* Placeholder badges */
.placeholder-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: #F8FAFC; border: 1px solid var(--color-border);
    color: var(--color-muted); padding: 6px 12px; border-radius: 8px;
    font-size: 13px; font-weight: 600;
}

@media (max-width: 767px) {
    .admin-page { padding: 16px; }
    .info-grid  { grid-template-columns: 1fr; }
    .stat-row   { grid-template-columns: repeat(2, 1fr); }
    .nav-prev-next { flex-direction: column; }
}
</style>
@endpush

<div class="admin-page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('admin.lessons.index') }}">Manajemen Pelajaran</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--color-text);font-weight:600;">Detail Pelajaran</span>
    </div>

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <div>
            <h1 class="admin-page-title">{{ $lesson->title }}</h1>
            <p class="admin-page-sub">
                <span class="type-badge" style="background:{{ $lesson->lesson_type_bg }};color:{{ $lesson->lesson_type_color }};">
                    {{ $lesson->lesson_type_icon }} {{ $lesson->lesson_type_label }}
                </span>
                &nbsp;·&nbsp;
                @if($lesson->course)
                    <a href="{{ route('admin.lessons.index', ['course_id' => $lesson->course_id]) }}"
                       style="color:var(--color-primary);text-decoration:none;font-weight:600;">
                        {{ $lesson->course->title }}
                    </a>
                @endif
            </p>
        </div>
        <div class="action-bar">
            <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn-action primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}"
                  onsubmit="return confirm('Hapus pelajaran ini? Tidak dapat dibatalkan.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-action danger">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Stat mini --}}
    <div class="stat-row" style="margin-bottom:16px;">
        <div class="stat-mini">
            <div class="stat-mini-value" style="color:#D97706;">+{{ number_format($lesson->xp_reward) }}</div>
            <div class="stat-mini-label">XP Reward</div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-value" style="color:#0891B2;">{{ $lesson->duration_minutes }}</div>
            <div class="stat-mini-label">Menit</div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-value" style="color:#7C3AED;">{{ $vocabularyCount }}</div>
            <div class="stat-mini-label">Vocabulary</div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-value" style="color:#EA580C;">{{ $quizCount }}</div>
            <div class="stat-mini-label">Quiz</div>
        </div>
    </div>

    {{-- Informasi --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <span class="panel-title">Informasi Pelajaran</span>
        </div>
        <div class="panel-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Kursus</span>
                    <span class="info-value">{{ $lesson->course?->title ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tipe Pelajaran</span>
                    <span class="info-value">
                        <span class="type-badge" style="background:{{ $lesson->lesson_type_bg }};color:{{ $lesson->lesson_type_color }};">
                            {{ $lesson->lesson_type_icon }} {{ $lesson->lesson_type_label }}
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($lesson->is_active)
                            <span class="status-pill status-active">● Aktif</span>
                        @else
                            <span class="status-pill status-inactive">○ Nonaktif</span>
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Sort Order</span>
                    <span class="info-value">{{ $lesson->sort_order }}</span>
                </div>
                <div class="info-item full">
                    <span class="info-label">Slug</span>
                    <span class="info-value" style="font-family:monospace;font-size:13px;">{{ $lesson->slug }}</span>
                </div>
                @if($lesson->description)
                <div class="info-item full">
                    <span class="info-label">Deskripsi</span>
                    <span class="info-value" style="font-weight:400;line-height:1.6;">{{ $lesson->description }}</span>
                </div>
                @endif
                <div class="info-item">
                    <span class="info-label">Dibuat</span>
                    <span class="info-value" style="font-weight:500;">{{ $lesson->created_at?->format('d M Y, H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Diperbarui</span>
                    <span class="info-value" style="font-weight:500;">{{ $lesson->updated_at?->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Vocabulary --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <span class="panel-title">Vocabulary ({{ $vocabularyCount }})</span>
            <a href="{{ route('admin.vocabulary.create', ['lesson_id' => $lesson->id]) }}" style="margin-left:auto;font-size:12.5px;font-weight:700;color:var(--color-primary);text-decoration:none;">+ Tambah Kosakata</a>
        </div>
        <div class="panel-body">
            @forelse($lesson->vocabularies as $vocab)
            <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:10px 0;border-bottom:1px solid var(--color-border);">
                <div>
                    <div style="font-weight:700;font-size:13.5px;color:var(--color-text);">{{ $vocab->term }}</div>
                    @if($vocab->translation)
                    <div style="font-size:12px;color:var(--color-muted);">{{ $vocab->translation }}</div>
                    @endif
                </div>
                <a href="{{ route('admin.vocabulary.edit', $vocab) }}" style="font-size:12.5px;color:var(--color-primary);text-decoration:none;font-weight:600;white-space:nowrap;">Edit</a>
            </div>
            @empty
            <p style="font-size:13px;color:var(--color-muted);margin:0;">Belum ada kosakata untuk pelajaran ini.</p>
            @endforelse
        </div>
    </div>

    {{-- Quiz --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <span class="panel-title">Quiz ({{ $quizCount }})</span>
            <a href="{{ route('admin.quizzes.create', ['lesson_id' => $lesson->id]) }}" style="margin-left:auto;font-size:12.5px;font-weight:700;color:var(--color-primary);text-decoration:none;">+ Tambah Soal</a>
        </div>
        <div class="panel-body">
            @forelse($lesson->quizzes as $quiz)
            <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:10px 0;border-bottom:1px solid var(--color-border);">
                <div style="min-width:0;">
                    <div style="font-weight:700;font-size:13.5px;color:var(--color-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:480px;">{{ $quiz->question }}</div>
                    <div style="font-size:12px;color:var(--color-muted);">{{ $quiz->question_type_label }} · +{{ $quiz->xp_reward }} XP</div>
                </div>
                <a href="{{ route('admin.quizzes.edit', $quiz) }}" style="font-size:12.5px;color:var(--color-primary);text-decoration:none;font-weight:600;white-space:nowrap;">Edit</a>
            </div>
            @empty
            <p style="font-size:13px;color:var(--color-muted);margin:0;">Belum ada soal quiz untuk pelajaran ini.</p>
            @endforelse
        </div>
    </div>

    {{-- Konten --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <span class="panel-title">Konten Pelajaran</span>
        </div>
        @if($lesson->content)
            <div class="content-preview">{!! $lesson->public_content !!}</div>
        @else
            <div class="content-empty">Belum ada konten. <a href="{{ route('admin.lessons.edit', $lesson) }}" style="color:var(--color-primary);">Tambahkan konten</a></div>
        @endif
    </div>

    {{-- Navigasi Prev/Next --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </div>
            <span class="panel-title">Navigasi Pelajaran (dalam kursus ini)</span>
        </div>
        <div class="panel-body">
            <div class="nav-prev-next">
                @if($prevLesson)
                <a href="{{ route('admin.lessons.show', $prevLesson) }}" class="nav-card">
                    <span class="nav-card-dir">← Sebelumnya</span>
                    <span class="nav-card-title">{{ $prevLesson->title }}</span>
                    <span class="nav-card-meta">Sort order: {{ $prevLesson->sort_order }} · {{ $prevLesson->lesson_type_label }}</span>
                </a>
                @else
                <div class="nav-card disabled">
                    <span class="nav-card-dir">← Sebelumnya</span>
                    <span class="nav-card-title" style="color:var(--color-muted);">Tidak ada</span>
                </div>
                @endif

                @if($nextLesson)
                <a href="{{ route('admin.lessons.show', $nextLesson) }}" class="nav-card" style="text-align:right;">
                    <span class="nav-card-dir">Selanjutnya →</span>
                    <span class="nav-card-title">{{ $nextLesson->title }}</span>
                    <span class="nav-card-meta">Sort order: {{ $nextLesson->sort_order }} · {{ $nextLesson->lesson_type_label }}</span>
                </a>
                @else
                <div class="nav-card disabled" style="text-align:right;">
                    <span class="nav-card-dir">Selanjutnya →</span>
                    <span class="nav-card-title" style="color:var(--color-muted);">Tidak ada</span>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
// Render MathJax jika konten mengandung formula
if (document.querySelector('.content-preview .math-block')) {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js';
    script.async = true;
    document.head.appendChild(script);
}
</script>
@endpush

</x-admin-layout>
