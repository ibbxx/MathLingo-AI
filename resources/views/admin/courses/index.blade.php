<x-admin-layout title="Manajemen Kursus">

@push('styles')
<style>
/* ── PAGE ─────────────────────────────────────── */
.admin-page { padding: 28px 28px 40px; }
.admin-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
}
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub   { font-size: 13.5px; color: var(--color-muted); margin: 0; }

/* ── STAT STRIP ───────────────────────────────── */
.stat-strip {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 12px; margin-bottom: 20px;
}
.stat-tile {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 14px;
    padding: 16px 18px;
    display: flex; align-items: center; gap: 12px;
    box-shadow: var(--shadow-card);
}
.stat-tile-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.stat-tile-value { font-size: 22px; font-weight: 800; color: var(--color-text); line-height: 1; margin-bottom: 2px; }
.stat-tile-label { font-size: 11px; font-weight: 600; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.04em; }

/* ── FILTER BAR ───────────────────────────────── */
.filter-bar {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-card);
    padding: 16px 20px;
    display: flex; flex-wrap: wrap; gap: 10px; align-items: center;
    margin-bottom: 16px;
    box-shadow: var(--shadow-card);
}
.search-wrap { flex: 1; min-width: 200px; position: relative; }
.search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--color-muted); pointer-events: none; }
.search-input {
    width: 100%; padding: 8px 12px 8px 36px;
    border: 1.5px solid var(--color-border); border-radius: 9px;
    font-size: 13.5px; font-family: inherit; color: var(--color-text);
    background: var(--color-bg); outline: none;
    transition: border-color 0.15s;
}
.search-input:focus { border-color: var(--color-primary); }
.search-input::placeholder { color: var(--color-muted); }

.filter-select {
    padding: 8px 28px 8px 11px; border: 1.5px solid var(--color-border);
    border-radius: 9px; font-size: 13px; font-weight: 500; font-family: inherit;
    color: var(--color-text); background: var(--color-bg); outline: none;
    cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 9px center;
    min-width: 130px; transition: border-color 0.15s;
}
.filter-select:focus { border-color: var(--color-primary); outline: none; }

.btn-search {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; background: var(--color-primary); color: #fff;
    font-size: 13px; font-weight: 600; font-family: inherit;
    border-radius: 9px; border: none; cursor: pointer; transition: opacity 0.15s;
}
.btn-search:hover { opacity: 0.88; }

.btn-reset {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 8px 13px; background: var(--color-bg); color: var(--color-muted);
    font-size: 13px; font-weight: 500; font-family: inherit;
    border-radius: 9px; border: 1.5px solid var(--color-border);
    cursor: pointer; text-decoration: none; transition: border-color 0.15s, color 0.15s;
}
.btn-reset:hover { border-color: var(--color-primary); color: var(--color-primary); }

/* ── PANEL ─────────────────────────────────────── */
.panel {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-card);
    overflow: hidden;
}
.panel-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px; border-bottom: 1px solid var(--color-border);
}
.panel-title { font-size: 14px; font-weight: 700; color: var(--color-text); }
.panel-count { font-size: 12px; font-weight: 600; color: var(--color-muted); }

/* ── TABLE ─────────────────────────────────────── */
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th {
    padding: 11px 14px; font-size: 11px; font-weight: 700;
    color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.06em;
    background: #F8FAFC; border-bottom: 1px solid var(--color-border);
    white-space: nowrap; text-align: left;
}
thead th:first-child { padding-left: 20px; }
thead th:last-child  { padding-right: 20px; text-align: right; }

tbody tr { border-bottom: 1px solid #F1F5F9; transition: background 0.1s; }
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: #FAFBFC; }
tbody td { padding: 13px 14px; font-size: 13.5px; color: var(--color-text); vertical-align: middle; }
tbody td:first-child { padding-left: 20px; }
tbody td:last-child  { padding-right: 20px; }

/* Course title cell */
.course-thumb-cell { display: flex; align-items: center; gap: 12px; }
.course-thumb {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; overflow: hidden;
}
.course-thumb img { width: 100%; height: 100%; object-fit: cover; }
.course-name { font-size: 14px; font-weight: 700; color: var(--color-text); margin-bottom: 2px; }
.course-slug { font-size: 11.5px; color: var(--color-muted); font-family: monospace; }

/* Badges */
.badge {
    display: inline-block; font-size: 11px; font-weight: 700;
    padding: 2px 8px; border-radius: 99px; white-space: nowrap;
}
.badge-green  { background: #F0FDF4; color: #15803D; }
.badge-amber  { background: #FFFBEB; color: #92400E; }
.badge-red    { background: #FEF2F2; color: #991B1B; }
.badge-blue   { background: #EFF6FF; color: #1D4ED8; }
.badge-muted  { background: #F1F5F9; color: #64748B; }
.badge-purple { background: #F5F3FF; color: #6D28D9; }

/* Status badge */
.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 700;
    padding: 3px 9px; border-radius: 99px;
}
.status-published { background: #F0FDF4; color: #15803D; }
.status-draft     { background: #F1F5F9; color: #64748B; }
.status-archived  { background: #FFFBEB; color: #92400E; }
.status-trashed   { background: #FEF2F2; color: #991B1B; }

/* Action buttons */
.action-group { display: flex; align-items: center; gap: 4px; justify-content: flex-end; }
.action-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px;
    border: 1px solid var(--color-border); background: transparent;
    cursor: pointer; color: var(--color-muted);
    transition: background 0.12s, color 0.12s, border-color 0.12s;
    text-decoration: none;
}
.action-btn:hover { background: #F1F5F9; color: var(--color-text); border-color: #CBD5E1; }
.action-btn.danger:hover { background: #FEF2F2; color: #DC2626; border-color: #FECACA; }
.action-btn.success:hover { background: #F0FDF4; color: #16A34A; border-color: #BBF7D0; }

/* ── PAGINATION ─────────────────────────────────── */
.pagi-wrap {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 10px;
    padding: 14px 20px; border-top: 1px solid var(--color-border);
}
.pagi-info { font-size: 13px; color: var(--color-muted); }
.pagi-links { display: flex; align-items: center; gap: 4px; }
.pagi-links a, .pagi-links span {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 32px; height: 32px; padding: 0 8px;
    border-radius: 8px; font-size: 13px; font-weight: 600;
    text-decoration: none; color: var(--color-muted);
    border: 1px solid var(--color-border); background: var(--color-bg);
    transition: background 0.12s, border-color 0.12s, color 0.12s;
}
.pagi-links a:hover { background: #EFF6FF; border-color: #BFDBFE; color: var(--color-primary); }
.pagi-links span.active { background: var(--color-primary); border-color: var(--color-primary); color: #fff; }
.pagi-links span.disabled { opacity: 0.35; pointer-events: none; }

/* ── EMPTY STATE ────────────────────────────────── */
.empty-state {
    padding: 56px 24px; text-align: center;
    display: flex; flex-direction: column; align-items: center; gap: 12px;
}
.empty-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--color-primary-10); color: var(--color-primary);
    display: flex; align-items: center; justify-content: center;
}
.empty-title { font-size: 15px; font-weight: 700; color: var(--color-text); }
.empty-sub   { font-size: 13px; color: var(--color-muted); max-width: 300px; }

/* ── MODAL ──────────────────────────────────────── */
.modal-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.45); z-index: 200;
    align-items: center; justify-content: center;
}
.modal-backdrop.open { display: flex; }
.modal {
    background: var(--color-surface); border-radius: 16px;
    padding: 28px; max-width: 420px; width: calc(100% - 32px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: modalIn 0.18s cubic-bezier(0.22,1,0.36,1);
}
@keyframes modalIn { from { opacity:0; transform:scale(0.95); } to { opacity:1; transform:scale(1); } }
.modal-icon {
    width: 48px; height: 48px; border-radius: 12px;
    background: #FEF2F2; color: #DC2626;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
}
.modal-title { font-size: 17px; font-weight: 800; color: var(--color-text); text-align: center; margin-bottom: 8px; }
.modal-desc  { font-size: 13.5px; color: var(--color-muted); text-align: center; line-height: 1.6; margin-bottom: 22px; }
.modal-actions { display: flex; gap: 10px; }
.btn-cancel {
    flex: 1; padding: 10px; border: 1.5px solid var(--color-border);
    border-radius: 9px; background: var(--color-bg); color: var(--color-muted);
    font-size: 14px; font-weight: 600; font-family: inherit; cursor: pointer;
    transition: border-color 0.12s;
}
.btn-cancel:hover { border-color: var(--color-primary); color: var(--color-primary); }
.btn-danger {
    flex: 1; padding: 10px; border: none;
    border-radius: 9px; background: #DC2626; color: #fff;
    font-size: 14px; font-weight: 700; font-family: inherit; cursor: pointer;
    transition: opacity 0.12s;
}
.btn-danger:hover { opacity: 0.88; }

/* ── FLASH ───────────────────────────────────────── */
.flash {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 11px;
    font-size: 13.5px; font-weight: 600; margin-bottom: 16px;
}
.flash-success { background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; }
.flash-error   { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }

/* ── BUTTONS ─────────────────────────────────────── */
.btn-primary {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; background: var(--color-primary); color: #fff;
    font-size: 13.5px; font-weight: 700; font-family: inherit;
    border-radius: 10px; text-decoration: none; border: none; cursor: pointer;
    transition: opacity 0.15s;
}
.btn-primary:hover { opacity: 0.88; }

@media (max-width: 767px) {
    .admin-page { padding: 16px 16px 32px; }
    .filter-bar { flex-direction: column; align-items: stretch; }
    .admin-page-header { flex-direction: column; }
}
</style>
@endpush

<div class="admin-page">

    {{-- Header --}}
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Manajemen Kursus</h1>
            <p class="admin-page-sub">Buat, edit, dan kelola kursus pembelajaran matematika.</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Kursus
        </a>
    </div>

    {{-- Flash --}}
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

    {{-- Stats --}}
    <div class="stat-strip">
        <div class="stat-tile">
            <div class="stat-tile-icon" style="background:#EFF6FF;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div>
                <div class="stat-tile-value">{{ $stats['total'] }}</div>
                <div class="stat-tile-label">Total</div>
            </div>
        </div>
        <div class="stat-tile">
            <div class="stat-tile-icon" style="background:#F0FDF4;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
            </div>
            <div>
                <div class="stat-tile-value">{{ $stats['published'] }}</div>
                <div class="stat-tile-label">Published</div>
            </div>
        </div>
        <div class="stat-tile">
            <div class="stat-tile-icon" style="background:#F8FAFC;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <div class="stat-tile-value">{{ $stats['draft'] }}</div>
                <div class="stat-tile-label">Draft</div>
            </div>
        </div>
        <div class="stat-tile">
            <div class="stat-tile-icon" style="background:#FFFBEB;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 8h14M5 8a2 2 0 1 0 0-4h14a2 2 0 1 0 0 4M5 8l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"/></svg>
            </div>
            <div>
                <div class="stat-tile-value">{{ $stats['archived'] }}</div>
                <div class="stat-tile-label">Archived</div>
            </div>
        </div>
        <div class="stat-tile">
            <div class="stat-tile-icon" style="background:#FEF2F2;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
            </div>
            <div>
                <div class="stat-tile-value">{{ $stats['trashed'] }}</div>
                <div class="stat-tile-label">Dihapus</div>
            </div>
        </div>
        <div class="stat-tile">
            <div class="stat-tile-icon" style="background:#FDF4FF;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9333EA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div>
                <div class="stat-tile-value">{{ $stats['featured'] }}</div>
                <div class="stat-tile-label">Featured</div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.courses.index') }}" class="filter-bar">
        <div class="search-wrap">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="search" name="search" class="search-input"
                   placeholder="Cari judul, slug, kategori..."
                   value="{{ request('search') }}" autocomplete="off">
        </div>

        <select name="category" class="filter-select">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <select name="difficulty" class="filter-select">
            <option value="">Semua Level</option>
            <option value="beginner"     {{ request('difficulty') === 'beginner'     ? 'selected' : '' }}>Beginner</option>
            <option value="intermediate" {{ request('difficulty') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
            <option value="advanced"     {{ request('difficulty') === 'advanced'     ? 'selected' : '' }}>Advanced</option>
        </select>

        <select name="status" class="filter-select">
            <option value="">Semua Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
            <option value="archived"  {{ request('status') === 'archived'  ? 'selected' : '' }}>Archived</option>
            <option value="trashed"   {{ request('status') === 'trashed'   ? 'selected' : '' }}>Dihapus</option>
        </select>

        <select name="sort" class="filter-select">
            <option value="sort_order" {{ $sort === 'sort_order' ? 'selected' : '' }}>Sort Order</option>
            <option value="newest"     {{ $sort === 'newest'     ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest"     {{ $sort === 'oldest'     ? 'selected' : '' }}>Terlama</option>
            <option value="az"         {{ $sort === 'az'         ? 'selected' : '' }}>A → Z</option>
            <option value="za"         {{ $sort === 'za'         ? 'selected' : '' }}>Z → A</option>
            <option value="students"   {{ $sort === 'students'   ? 'selected' : '' }}>Terbanyak Student</option>
            <option value="lessons"    {{ $sort === 'lessons'    ? 'selected' : '' }}>Terbanyak Lesson</option>
        </select>

        <select name="per_page" class="filter-select" style="min-width:80px;">
            @foreach([10, 25, 50, 100] as $pp)
                <option value="{{ $pp }}" {{ $perPage == $pp ? 'selected' : '' }}>{{ $pp }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn-search">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            Filter
        </button>

        @if(request()->hasAny(['search','category','difficulty','status','sort']))
        <a href="{{ route('admin.courses.index') }}" class="btn-reset">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Reset
        </a>
        @endif
    </form>

    {{-- Table --}}
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Daftar Kursus</span>
            <span class="panel-count">{{ $courses->total() }} kursus</span>
        </div>

        @if($courses->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <p class="empty-title">Belum ada kursus</p>
            <p class="empty-sub">Buat kursus pertama atau ubah filter pencarian Anda.</p>
            <a href="{{ route('admin.courses.create') }}" class="btn-primary" style="margin-top:4px;">
                Tambah Kursus
            </a>
        </div>
        @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kursus</th>
                        <th>Kategori</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Lesson</th>
                        <th>Student</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        {{-- Thumbnail + Title --}}
                        <td>
                            <div class="course-thumb-cell">
                                <div class="course-thumb" style="background:{{ $course->color }}1A;">
                                    @if($course->thumbnail)
                                        <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="{{ $course->title }}">
                                    @else
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $course->color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="course-name">{{ $course->title }}</div>
                                    <div class="course-slug">{{ $course->slug }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td>
                            <span class="badge badge-blue">{{ $course->category ?: '—' }}</span>
                        </td>

                        {{-- Difficulty --}}
                        <td>
                            @php
                                $diffClass = match($course->difficulty) {
                                    'beginner'     => 'badge-green',
                                    'intermediate' => 'badge-amber',
                                    'advanced'     => 'badge-red',
                                    default        => 'badge-muted',
                                };
                            @endphp
                            <span class="badge {{ $diffClass }}">{{ $course->difficulty_label }}</span>
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($course->trashed())
                                <span class="status-badge status-trashed">
                                    <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                    Dihapus
                                </span>
                            @else
                                <span class="status-badge status-{{ $course->status }}">
                                    <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                    {{ $course->status_label }}
                                </span>
                            @endif
                        </td>

                        {{-- Featured --}}
                        <td>
                            @if($course->is_featured)
                                <span class="badge badge-purple">★ Featured</span>
                            @else
                                <span style="font-size:13px;color:var(--color-muted);">—</span>
                            @endif
                        </td>

                        {{-- Lessons --}}
                        <td>
                            <span style="font-weight:700;">{{ $course->lessons_count }}</span>
                        </td>

                        {{-- Students --}}
                        <td>
                            <span style="font-weight:700;">{{ number_format($course->students_count) }}</span>
                        </td>

                        {{-- Created --}}
                        <td style="font-size:12.5px;color:var(--color-muted);">
                            {{ $course->created_at->format('d M Y') }}
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="action-group">
                                @if($course->trashed())
                                    <span style="font-size:12px;color:var(--color-muted);font-style:italic;">—</span>
                                @else
                                    {{-- Preview --}}
                                    <a href="{{ route('admin.courses.preview', $course) }}" class="action-btn" title="Preview sebagai Student" target="_blank">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="action-btn" title="Edit">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>

                                    {{-- Duplicate --}}
                                    <form method="POST" action="{{ route('admin.courses.duplicate', $course) }}" style="display:contents;">
                                        @csrf
                                        <button type="submit" class="action-btn" title="Duplikasi">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                        </button>
                                    </form>

                                    {{-- Quick status toggle --}}
                                    @if($course->status !== 'published')
                                    <form method="POST" action="{{ route('admin.courses.toggle-status', $course) }}" style="display:contents;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="published">
                                        <button type="submit" class="action-btn success" title="Publish">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </button>
                                    </form>
                                    @else
                                    <form method="POST" action="{{ route('admin.courses.toggle-status', $course) }}" style="display:contents;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="draft">
                                        <button type="submit" class="action-btn" title="Set Draft">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        </button>
                                    </form>
                                    @endif

                                    {{-- Delete --}}
                                    <button type="button" class="action-btn danger"
                                            title="Hapus"
                                            onclick="openDeleteModal('{{ $course->id }}', '{{ addslashes($course->title) }}')">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($courses->hasPages())
        <div class="pagi-wrap">
            <span class="pagi-info">
                Menampilkan {{ $courses->firstItem() }}–{{ $courses->lastItem() }} dari {{ $courses->total() }} kursus
            </span>
            <div class="pagi-links">
                @if($courses->onFirstPage())
                    <span class="disabled"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $courses->previousPageUrl() }}"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif

                @foreach($courses->getUrlRange(max(1, $courses->currentPage()-2), min($courses->lastPage(), $courses->currentPage()+2)) as $page => $url)
                    @if($page === $courses->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($courses->hasMorePages())
                    <a href="{{ $courses->nextPageUrl() }}"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="disabled"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
        @endif
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal-backdrop" id="deleteModal">
    <div class="modal">
        <div class="modal-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
        </div>
        <div class="modal-title">Hapus Kursus?</div>
        <div class="modal-desc" id="deleteModalDesc">Kursus ini akan dipindahkan ke tempat sampah. Anda dapat memulihkannya nanti.</div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" style="flex:1;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger" style="width:100%;">Hapus</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openDeleteModal(id, title) {
    document.getElementById('deleteModalDesc').textContent =
        'Kursus "' + title + '" akan dipindahkan ke tempat sampah. Anda dapat memulihkannya nanti.';
    document.getElementById('deleteForm').action = '/admin/courses/' + id;
    document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
});
</script>
@endpush

</x-admin-layout>