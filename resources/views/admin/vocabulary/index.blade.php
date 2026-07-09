<x-admin-layout title="Manajemen Kosakata">

@push('styles')
<style>
.admin-page { padding: 28px 28px 40px; }
.admin-page-header { margin-bottom: 24px; display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub { font-size: 13.5px; color: var(--color-muted); margin: 0; }

.stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 20px; }
.stat-card {
    background: var(--color-surface); border: 1px solid var(--color-border);
    border-radius: 14px; padding: 16px 18px;
    display: flex; flex-direction: column; gap: 4px;
}
.stat-card-value { font-size: 22px; font-weight: 800; color: var(--color-text); line-height: 1; }
.stat-card-label { font-size: 12px; font-weight: 500; color: var(--color-muted); }
.stat-card.primary .stat-card-value { color: var(--color-primary); }
.stat-card.success .stat-card-value { color: #16A34A; }
.stat-card.accent  .stat-card-value { color: #D97706; }
.stat-card.danger  .stat-card-value { color: var(--color-danger); }
.stat-card.purple  .stat-card-value { color: #7C3AED; }

.toolbar {
    background: var(--color-surface); border: 1px solid var(--color-border);
    border-radius: 14px; padding: 14px 16px;
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    margin-bottom: 16px;
}
.toolbar-search {
    display: flex; align-items: center; gap: 8px;
    background: var(--color-bg); border: 1.5px solid var(--color-border);
    border-radius: 9px; padding: 7px 12px; flex: 1; min-width: 200px;
}
.toolbar-search input { border: none; background: transparent; font-size: 13px; color: var(--color-text); font-family: inherit; outline: none; width: 100%; }
.toolbar-select {
    padding: 8px 30px 8px 12px; border: 1.5px solid var(--color-border);
    border-radius: 9px; font-size: 13px; font-family: inherit; background: var(--color-bg);
    color: var(--color-text); outline: none; cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
}
.btn-primary {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: 9px; border: none;
    background: var(--color-primary); color: #fff;
    font-size: 13px; font-weight: 700; font-family: inherit;
    cursor: pointer; text-decoration: none; white-space: nowrap;
}
.btn-primary:hover { opacity: 0.88; }
.toolbar-right { display: flex; align-items: center; gap: 8px; margin-left: auto; }

.table-panel { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 14px; overflow: hidden; margin-bottom: 16px; }
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th {
    padding: 11px 14px; font-size: 11.5px; font-weight: 700; color: var(--color-muted);
    text-align: left; white-space: nowrap; border-bottom: 1px solid var(--color-border);
    background: #FAFBFC; text-transform: uppercase; letter-spacing: 0.05em;
}
tbody tr { border-bottom: 1px solid var(--color-border); }
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: #F8FAFC; }
tbody td { padding: 13px 14px; font-size: 13.5px; color: var(--color-text); vertical-align: middle; }

.term-cell { display: flex; flex-direction: column; gap: 3px; }
.term-title { font-weight: 700; color: var(--color-text); font-size: 13.5px; }
.term-meaning { font-size: 12px; color: var(--color-muted); max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.term-formula { font-family: monospace; font-size: 11.5px; color: #7C3AED; background: #F5F3FF; padding: 1px 6px; border-radius: 4px; display: inline-block; margin-top: 2px; }

.lesson-pill {
    display: inline-flex; flex-direction: column; gap: 1px;
    font-size: 12px; font-weight: 600; color: var(--color-text);
    background: var(--color-primary-10); padding: 4px 9px;
    border-radius: 6px; max-width: 200px; text-decoration: none;
}
.lesson-pill small { font-weight: 500; color: var(--color-muted); font-size: 10.5px; }

.diff-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; }
.diff-beginner     { background: #F0FDF4; color: #166534; }
.diff-intermediate { background: #FFFBEB; color: #92400E; }
.diff-advanced     { background: #FEF2F2; color: #991B1B; }

.row-actions { display: flex; align-items: center; gap: 4px; }
.row-btn {
    display: flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px;
    border: 1px solid var(--color-border); background: transparent;
    color: var(--color-muted); cursor: pointer; text-decoration: none;
}
.row-btn:hover { background: var(--color-bg); color: var(--color-primary); border-color: var(--color-primary); }
.row-btn.danger:hover { background: #FEF2F2; color: var(--color-danger); border-color: var(--color-danger); }

.empty-state { text-align: center; padding: 64px 32px; }
.empty-icon { width: 64px; height: 64px; border-radius: 18px; background: var(--color-primary-10); color: var(--color-primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.empty-title { font-size: 17px; font-weight: 700; color: var(--color-text); margin: 0 0 6px; }
.empty-desc { font-size: 13.5px; color: var(--color-muted); margin: 0 0 20px; }

.pagination-bar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; padding: 14px 16px; border-top: 1px solid var(--color-border); }
.pagination-info { font-size: 13px; color: var(--color-muted); }
.pagination-links { display: flex; align-items: center; gap: 4px; }
.page-btn { display: flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; padding: 0 8px; border-radius: 7px; border: 1px solid var(--color-border); font-size: 13px; font-weight: 500; color: var(--color-muted); background: transparent; cursor: pointer; text-decoration: none; }
.page-btn:hover { background: var(--color-bg); color: var(--color-primary); }
.page-btn.active { background: var(--color-primary); color: #fff; border-color: var(--color-primary); font-weight: 700; }
.page-btn.disabled { opacity: 0.4; pointer-events: none; }

.flash { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 11px; font-size: 13.5px; font-weight: 600; margin-bottom: 16px; }
.flash-success { background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; }

@media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px)  { .stats-grid { grid-template-columns: repeat(2, 1fr); } .admin-page { padding: 16px; } }
</style>
@endpush

<div class="admin-page">

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Manajemen Kosakata</h1>
            <p class="admin-page-sub">Kelola kosakata matematika Bahasa Inggris untuk setiap pelajaran.</p>
        </div>
        <a href="{{ route('admin.vocabulary.create') }}" class="btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Kosakata
        </a>
    </div>

    @if(session('success'))
    <div class="flash flash-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card primary"><div class="stat-card-value">{{ number_format($stats['total']) }}</div><div class="stat-card-label">Total Kosakata</div></div>
        <div class="stat-card success"><div class="stat-card-value">{{ number_format($stats['beginner']) }}</div><div class="stat-card-label">Beginner</div></div>
        <div class="stat-card accent"><div class="stat-card-value">{{ number_format($stats['intermediate']) }}</div><div class="stat-card-label">Intermediate</div></div>
        <div class="stat-card danger"><div class="stat-card-value">{{ number_format($stats['advanced']) }}</div><div class="stat-card-label">Advanced</div></div>
        <div class="stat-card purple"><div class="stat-card-value">{{ number_format($stats['total_lessons']) }}</div><div class="stat-card-label">Pelajaran Terisi</div></div>
    </div>

    <form method="GET" action="{{ route('admin.vocabulary.index') }}">
        <div class="toolbar">
            <div class="toolbar-search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="search" name="search" placeholder="Cari istilah, arti, atau terjemahan..." value="{{ request('search') }}" onchange="this.form.submit()">
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
            <select name="difficulty" class="toolbar-select" onchange="this.form.submit()">
                <option value="">Semua Tingkat</option>
                <option value="beginner" {{ request('difficulty') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                <option value="intermediate" {{ request('difficulty') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                <option value="advanced" {{ request('difficulty') === 'advanced' ? 'selected' : '' }}>Advanced</option>
            </select>
            <input type="hidden" name="sort" value="{{ $sort }}">
            @if(request()->hasAny(['search','course_id','lesson_id','difficulty']))
            <a href="{{ route('admin.vocabulary.index') }}" style="font-size:13px;color:var(--color-danger);text-decoration:none;white-space:nowrap;">Reset Filter</a>
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
                        <th>Istilah</th>
                        <th>Pelajaran</th>
                        <th>Terjemahan</th>
                        <th>Tingkat</th>
                        <th style="width:60px;text-align:center;">Order</th>
                        <th style="width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vocabularies as $vocab)
                    <tr>
                        <td style="color:var(--color-muted);font-size:12px;">{{ $vocabularies->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="term-cell" style="display:flex;align-items:flex-start;gap:10px;">
                                @if($vocab->image)
                                <img src="{{ $vocab->image_url }}" alt="{{ $vocab->term }}"
                                     style="width:36px;height:36px;object-fit:cover;border-radius:8px;border:1px solid var(--color-border);flex-shrink:0;">
                                @endif
                                <div style="display:flex;flex-direction:column;">
                                <span class="term-title">{{ $vocab->term }}</span>
                                @if($vocab->mathematical_meaning)
                                <span class="term-meaning">{{ $vocab->mathematical_meaning }}</span>
                                @endif
                                @if($vocab->formula)
                                <span class="term-formula">{{ $vocab->formula }}</span>
                                @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($vocab->lesson)
                            <a href="{{ route('admin.vocabulary.index', ['lesson_id' => $vocab->lesson_id]) }}" class="lesson-pill">
                                {{ $vocab->lesson->title }}
                                <small>{{ $vocab->lesson->course?->title }}</small>
                            </a>
                            @else
                            <span style="color:var(--color-muted);font-size:12px;">&mdash;</span>
                            @endif
                        </td>
                        <td style="font-size:13px;color:var(--color-muted);">{{ $vocab->translation ?: '—' }}</td>
                        <td><span class="diff-badge diff-{{ $vocab->difficulty }}">{{ ucfirst($vocab->difficulty) }}</span></td>
                        <td style="text-align:center;"><span style="font-size:12px;color:var(--color-muted);">{{ $vocab->sort_order }}</span></td>
                        <td>
                            <div class="row-actions">
                                <a href="{{ route('admin.vocabulary.edit', $vocab) }}" class="row-btn" title="Edit">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.vocabulary.destroy', $vocab) }}" onsubmit="return confirm('Hapus kosakata &quot;{{ addslashes($vocab->term) }}&quot;?')">
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
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                </div>
                                <h3 class="empty-title">Belum ada kosakata</h3>
                                <p class="empty-desc">
                                    @if(request()->hasAny(['search','course_id','lesson_id','difficulty']))
                                        Tidak ada kosakata yang sesuai filter. <a href="{{ route('admin.vocabulary.index') }}" style="color:var(--color-primary);">Reset filter</a>
                                    @else
                                        Mulai dengan menambahkan kosakata pertama.
                                    @endif
                                </p>
                                @unless(request()->hasAny(['search','course_id','lesson_id','difficulty']))
                                <a href="{{ route('admin.vocabulary.create') }}" class="btn-primary" style="display:inline-flex;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    Tambah Kosakata
                                </a>
                                @endunless
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($vocabularies->hasPages())
        <div class="pagination-bar">
            <div class="pagination-info">Menampilkan {{ $vocabularies->firstItem() }}–{{ $vocabularies->lastItem() }} dari {{ $vocabularies->total() }} kosakata</div>
            <div class="pagination-links">
                @if($vocabularies->onFirstPage())
                    <span class="page-btn disabled">‹</span>
                @else
                    <a href="{{ $vocabularies->previousPageUrl() }}" class="page-btn">‹</a>
                @endif
                @foreach($vocabularies->getUrlRange(max(1, $vocabularies->currentPage() - 2), min($vocabularies->lastPage(), $vocabularies->currentPage() + 2)) as $page => $url)
                    @if($page == $vocabularies->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach
                @if($vocabularies->hasMorePages())
                    <a href="{{ $vocabularies->nextPageUrl() }}" class="page-btn">›</a>
                @else
                    <span class="page-btn disabled">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

</x-admin-layout>
