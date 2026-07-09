<x-admin-layout title="Manajemen Quiz">

@push('styles')
<style>
.admin-page { padding: 28px 28px 40px; }
.admin-page-header { margin-bottom: 24px; display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub { font-size: 13.5px; color: var(--color-muted); margin: 0; }

.stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 20px; }
.stat-card { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 14px; padding: 16px 18px; display: flex; flex-direction: column; gap: 4px; }
.stat-card-value { font-size: 22px; font-weight: 800; color: var(--color-text); line-height: 1; }
.stat-card-label { font-size: 12px; font-weight: 500; color: var(--color-muted); }
.stat-card.primary .stat-card-value { color: var(--color-primary); }
.stat-card.success .stat-card-value { color: #16A34A; }
.stat-card.danger  .stat-card-value { color: var(--color-danger); }
.stat-card.accent  .stat-card-value { color: #D97706; }
.stat-card.purple  .stat-card-value { color: #7C3AED; }

.toolbar { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 14px; padding: 14px 16px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 16px; }
.toolbar-search { display: flex; align-items: center; gap: 8px; background: var(--color-bg); border: 1.5px solid var(--color-border); border-radius: 9px; padding: 7px 12px; flex: 1; min-width: 200px; }
.toolbar-search input { border: none; background: transparent; font-size: 13px; color: var(--color-text); font-family: inherit; outline: none; width: 100%; }
.toolbar-select {
    padding: 8px 30px 8px 12px; border: 1.5px solid var(--color-border); border-radius: 9px;
    font-size: 13px; font-family: inherit; background: var(--color-bg); color: var(--color-text);
    outline: none; cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
}
.btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 9px; border: none; background: var(--color-primary); color: #fff; font-size: 13px; font-weight: 700; font-family: inherit; cursor: pointer; text-decoration: none; white-space: nowrap; transition: opacity 0.15s; }
.btn-primary:hover { opacity: 0.88; }
.toolbar-right { display: flex; align-items: center; gap: 8px; margin-left: auto; }

.table-panel { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 14px; overflow: hidden; margin-bottom: 16px; }
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th { padding: 11px 14px; font-size: 11.5px; font-weight: 700; color: var(--color-muted); text-align: left; white-space: nowrap; border-bottom: 1px solid var(--color-border); background: #FAFBFC; text-transform: uppercase; letter-spacing: 0.05em; }
tbody tr { border-bottom: 1px solid var(--color-border); transition: background 0.1s; }
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: #F8FAFC; }
tbody td { padding: 13px 14px; font-size: 13.5px; color: var(--color-text); vertical-align: middle; }

.q-cell { display: flex; flex-direction: column; gap: 3px; max-width: 320px; }
.q-title { font-weight: 700; color: var(--color-text); font-size: 13.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.q-answer { font-size: 12px; color: var(--color-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.course-pill { display: inline-flex; flex-direction: column; gap: 1px; font-size: 12px; font-weight: 600; color: var(--color-text); background: var(--color-primary-10); padding: 4px 8px; border-radius: 6px; max-width: 190px; overflow: hidden; }
.course-pill small { font-weight: 500; color: var(--color-muted); font-size: 10.5px; }

.type-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; white-space: nowrap; background: #EDE9FE; color: #6D28D9; }
.status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
.status-active   { background: #F0FDF4; color: #166534; }
.status-inactive { background: #F8FAFC; color: #64748B; }

.xp-cell { font-size: 13px; font-weight: 700; color: #D97706; white-space: nowrap; }

.row-actions { display: flex; align-items: center; gap: 4px; }
.row-btn { display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 7px; border: 1px solid var(--color-border); background: transparent; color: var(--color-muted); cursor: pointer; text-decoration: none; transition: background 0.12s, color 0.12s, border-color 0.12s; }
.row-btn:hover { background: var(--color-bg); color: var(--color-primary); border-color: var(--color-primary); }
.row-btn.danger:hover { background: #FEF2F2; color: var(--color-danger); border-color: var(--color-danger); }

.empty-state { text-align: center; padding: 64px 32px; }
.empty-icon { width: 64px; height: 64px; border-radius: 18px; background: var(--color-primary-10); color: var(--color-primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.empty-title { font-size: 17px; font-weight: 700; color: var(--color-text); margin: 0 0 6px; }
.empty-desc  { font-size: 13.5px; color: var(--color-muted); margin: 0 0 20px; }

.pagination-bar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; padding: 14px 16px; border-top: 1px solid var(--color-border); }
.pagination-info { font-size: 13px; color: var(--color-muted); }
.pagination-links { display: flex; align-items: center; gap: 4px; }
.page-btn { display: flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; padding: 0 8px; border-radius: 7px; border: 1px solid var(--color-border); font-size: 13px; font-weight: 500; color: var(--color-muted); background: transparent; cursor: pointer; text-decoration: none; }
.page-btn:hover { background: var(--color-bg); color: var(--color-primary); }
.page-btn.active { background: var(--color-primary); color: #fff; border-color: var(--color-primary); font-weight: 700; }
.page-btn.disabled { opacity: 0.4; cursor: default; pointer-events: none; }

.flash { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 11px; font-size: 13.5px; font-weight: 600; margin-bottom: 16px; }
.flash-success { background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; }
.flash-error   { background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; }

@media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px)  { .stats-grid { grid-template-columns: repeat(2, 1fr); } .admin-page { padding: 16px; } }
</style>
@endpush

<div class="admin-page">

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Manajemen Quiz</h1>
            <p class="admin-page-sub">Kelola soal quiz untuk setiap pelajaran.</p>
        </div>
        <a href="{{ route('admin.quizzes.create') }}" class="btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Soal
        </a>
    </div>

    @if(session('success'))
    <div class="flash flash-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flash flash-error">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-card-value">{{ number_format($stats['total']) }}</div>
            <div class="stat-card-label">Total Soal</div>
        </div>
        <div class="stat-card success">
            <div class="stat-card-value">{{ number_format($stats['active']) }}</div>
            <div class="stat-card-label">Aktif</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-card-value">{{ number_format($stats['inactive']) }}</div>
            <div class="stat-card-label">Nonaktif</div>
        </div>
        <div class="stat-card accent">
            <div class="stat-card-value">{{ number_format($stats['total_xp']) }}</div>
            <div class="stat-card-label">Total XP</div>
        </div>
        <div class="stat-card purple">
            <div class="stat-card-value">{{ number_format($stats['total_lessons']) }}</div>
            <div class="stat-card-label">Pelajaran Terisi</div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.quizzes.index') }}" id="filterForm">
        <div class="toolbar">
            <div class="toolbar-search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="search" name="search" placeholder="Cari pertanyaan..." value="{{ request('search') }}" onchange="this.form.submit()">
            </div>

            <select name="course_id" class="toolbar-select" onchange="this.form.submit()">
                <option value="">Semua Kursus</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                @endforeach
            </select>

            <select name="lesson_id" class="toolbar-select" onchange="this.form.submit()">
                <option value="">Semua Pelajaran</option>
                @foreach($lessons as $lesson)
                    <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>{{ $lesson->title }}</option>
                @endforeach
            </select>

            <select name="question_type" class="toolbar-select" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                @foreach($questionTypes as $value => $label)
                    <option value="{{ $value }}" {{ request('question_type') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <select name="status" class="toolbar-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="per_page" value="{{ $perPage }}">

            @if(request()->hasAny(['search','course_id','lesson_id','question_type','status']))
            <a href="{{ route('admin.quizzes.index') }}" style="font-size:13px;color:var(--color-danger);text-decoration:none;white-space:nowrap;">Reset Filter</a>
            @endif

            <div class="toolbar-right">
                <select name="per_page" class="toolbar-select" onchange="this.form.submit()">
                    @foreach([10, 25, 50, 100] as $n)
                        <option value="{{ $n }}" {{ $perPage == $n ? 'selected' : '' }}>{{ $n }} / hal</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <div class="table-panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Pertanyaan</th>
                        <th>Pelajaran</th>
                        <th>Tipe</th>
                        <th>XP</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th style="width:110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizzes as $quiz)
                    <tr>
                        <td style="color:var(--color-muted);font-size:12px;">{{ $quizzes->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="q-cell">
                                <span class="q-title">{{ $quiz->question }}</span>
                                <span class="q-answer">Jawaban: {{ $quiz->correct_answer }}</span>
                            </div>
                        </td>
                        <td>
                            @if($quiz->lesson)
                            <span class="course-pill">
                                {{ $quiz->lesson->title }}
                                <small>{{ $quiz->lesson->course->title ?? '—' }}</small>
                            </span>
                            @else
                            <span style="color:var(--color-muted);font-size:12px;">—</span>
                            @endif
                        </td>
                        <td><span class="type-badge">{{ $quiz->question_type_label }}</span></td>
                        <td class="xp-cell">+{{ number_format($quiz->xp_reward) }} XP</td>
                        <td style="font-size:13px;color:var(--color-muted);">{{ $quiz->time_limit_seconds }} dtk</td>
                        <td>
                            @if($quiz->is_active)
                                <span class="status-badge status-active">● Aktif</span>
                            @else
                                <span class="status-badge status-inactive">○ Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="row-actions">
                                <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="row-btn" title="Edit">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}"
                                      onsubmit="return confirm('Hapus soal ini? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="row-btn danger" title="Hapus">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                                <h3 class="empty-title">Belum ada soal quiz</h3>
                                <p class="empty-desc">
                                    @if(request()->hasAny(['search','course_id','lesson_id','question_type','status']))
                                        Tidak ada soal yang sesuai filter. <a href="{{ route('admin.quizzes.index') }}" style="color:var(--color-primary);">Reset filter</a>
                                    @else
                                        Mulai dengan menambahkan soal pertama.
                                    @endif
                                </p>
                                @unless(request()->hasAny(['search','course_id','lesson_id','question_type','status']))
                                <a href="{{ route('admin.quizzes.create') }}" class="btn-primary" style="display:inline-flex;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    Tambah Soal
                                </a>
                                @endunless
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($quizzes->hasPages())
        <div class="pagination-bar">
            <div class="pagination-info">
                Menampilkan {{ $quizzes->firstItem() }}–{{ $quizzes->lastItem() }} dari {{ $quizzes->total() }} soal
            </div>
            <div class="pagination-links">
                @if($quizzes->onFirstPage())
                    <span class="page-btn disabled">‹</span>
                @else
                    <a href="{{ $quizzes->previousPageUrl() }}" class="page-btn">‹</a>
                @endif

                @foreach($quizzes->getUrlRange(max(1, $quizzes->currentPage() - 2), min($quizzes->lastPage(), $quizzes->currentPage() + 2)) as $page => $url)
                    @if($page == $quizzes->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach

                @if($quizzes->hasMorePages())
                    <a href="{{ $quizzes->nextPageUrl() }}" class="page-btn">›</a>
                @else
                    <span class="page-btn disabled">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

</x-admin-layout>
