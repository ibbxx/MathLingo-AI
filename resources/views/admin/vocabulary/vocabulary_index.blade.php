<x-app-layout>

@section('page-title', 'Manajemen Kosakata')

<style>
    :root {
        --primary: #2563EB; --p10:#EFF6FF; --p20:#DBEAFE;
        --secondary:#22C55E; --s10:#F0FDF4;
        --accent:#F59E0B; --a10:#FFFBEB;
        --danger:#EF4444;
        --bg:#F8FAFC; --surface:#FFFFFF; --border:#E5E7EB;
        --text:#1E293B; --muted:#64748B;
        --r-card:16px;
        --shadow:0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05);
    }
    .page-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
    .page-title { font-size:22px; font-weight:800; color:var(--text); letter-spacing:-0.3px; }
    .page-sub { font-size:13px; color:var(--muted); margin-top:2px; }

    .btn-primary { display:inline-flex; align-items:center; gap:7px; padding:10px 18px; background:var(--primary); color:#fff; font-size:14px; font-weight:700; border-radius:10px; text-decoration:none; border:none; cursor:pointer; }
    .btn-primary:hover { opacity:0.9; color:#fff; }

    .stat-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:12px; margin-bottom:20px; }
    .stat-card { background:var(--surface); border-radius:var(--r-card); box-shadow:var(--shadow); padding:16px 18px; }
    .stat-val { font-size:22px; font-weight:800; color:var(--text); }
    .stat-label { font-size:12px; color:var(--muted); font-weight:600; margin-top:2px; }

    .filter-bar { background:var(--surface); border-radius:var(--r-card); box-shadow:var(--shadow); padding:14px 16px; margin-bottom:16px; display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
    .filter-bar input, .filter-bar select { padding:9px 12px; border:1.5px solid var(--border); border-radius:9px; font-size:13px; font-family:inherit; color:var(--text); background:#fff; }
    .filter-bar input[type=text] { flex:1; min-width:180px; }

    table.data-table { width:100%; border-collapse:collapse; background:var(--surface); border-radius:var(--r-card); overflow:hidden; box-shadow:var(--shadow); }
    table.data-table th { text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:0.04em; color:var(--muted); font-weight:700; padding:12px 16px; background:var(--bg); border-bottom:1px solid var(--border); }
    table.data-table td { padding:12px 16px; font-size:13px; color:var(--text); border-bottom:1px solid #F1F5F9; vertical-align:top; }
    table.data-table tr:last-child td { border-bottom:none; }
    .term-cell { font-weight:700; }
    .meaning-cell { color:var(--muted); font-size:12px; max-width:260px; }
    .badge { font-size:11px; font-weight:700; padding:3px 9px; border-radius:99px; display:inline-block; }
    .badge-beginner { background:var(--s10); color:#15803D; }
    .badge-intermediate { background:var(--a10); color:#92400E; }
    .badge-advanced { background:#FEF2F2; color:#991B1B; }
    .row-actions { display:flex; gap:8px; }
    .row-actions a, .row-actions button { font-size:12px; font-weight:700; text-decoration:none; border:none; background:none; cursor:pointer; padding:0; }
    .act-edit { color:var(--primary); }
    .act-delete { color:var(--danger); }
    .empty-row td { text-align:center; padding:40px; color:var(--muted); }
</style>

<div class="page-head">
    <div>
        <div class="page-title">Manajemen Kosakata</div>
        <div class="page-sub">Kelola istilah kosakata matematika untuk setiap lesson.</div>
    </div>
    <a href="{{ route('admin.vocabulary.create') }}" class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Kosakata
    </a>
</div>

@if(session('success'))
<div style="background:var(--s10);color:#15803D;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px;">
    {{ session('success') }}
</div>
@endif

<div class="stat-grid">
    <div class="stat-card"><div class="stat-val">{{ $stats['total'] }}</div><div class="stat-label">Total Kosakata</div></div>
    <div class="stat-card"><div class="stat-val">{{ $stats['beginner'] }}</div><div class="stat-label">Beginner</div></div>
    <div class="stat-card"><div class="stat-val">{{ $stats['intermediate'] }}</div><div class="stat-label">Intermediate</div></div>
    <div class="stat-card"><div class="stat-val">{{ $stats['advanced'] }}</div><div class="stat-label">Advanced</div></div>
    <div class="stat-card"><div class="stat-val">{{ $stats['with_audio'] }}</div><div class="stat-label">Punya Audio</div></div>
</div>

<form method="GET" action="{{ route('admin.vocabulary.index') }}" class="filter-bar">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari istilah, arti, formula...">

    <select name="course_id" onchange="this.form.submit()">
        <option value="">Semua Kursus</option>
        @foreach($courses as $c)
            <option value="{{ $c->id }}" @selected(request('course_id') == $c->id)>{{ $c->title }}</option>
        @endforeach
    </select>

    <select name="lesson_id" onchange="this.form.submit()">
        <option value="">Semua Lesson</option>
        @foreach($lessons as $l)
            <option value="{{ $l->id }}" @selected(request('lesson_id') == $l->id)>{{ $l->title }} ({{ $l->course->title ?? '-' }})</option>
        @endforeach
    </select>

    <select name="difficulty" onchange="this.form.submit()">
        <option value="">Semua Tingkat</option>
        <option value="beginner" @selected(request('difficulty') === 'beginner')>Beginner</option>
        <option value="intermediate" @selected(request('difficulty') === 'intermediate')>Intermediate</option>
        <option value="advanced" @selected(request('difficulty') === 'advanced')>Advanced</option>
    </select>

    <select name="sort" onchange="this.form.submit()">
        <option value="sort_order" @selected($sort === 'sort_order')>Urutan</option>
        <option value="newest" @selected($sort === 'newest')>Terbaru</option>
        <option value="oldest" @selected($sort === 'oldest')>Terlama</option>
        <option value="az" @selected($sort === 'az')>A-Z</option>
        <option value="za" @selected($sort === 'za')>Z-A</option>
    </select>

    <button type="submit" class="btn-primary" style="padding:9px 16px;">Filter</button>
</form>

<table class="data-table">
    <thead>
        <tr>
            <th>Istilah</th>
            <th>Arti / Makna</th>
            <th>Lesson</th>
            <th>Tingkat</th>
            <th>Urutan</th>
            <th style="text-align:right;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($vocabularies as $vocab)
        <tr>
            <td class="term-cell">
                {{ $vocab->term }}
                @if($vocab->audio_path)
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" style="vertical-align:middle;margin-left:4px;"><path d="M11 5L6 9H2v6h4l5 4V5z"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
                @endif
            </td>
            <td class="meaning-cell">{{ \Illuminate\Support\Str::limit($vocab->mathematical_meaning ?? $vocab->translation, 80) }}</td>
            <td>{{ $vocab->lesson->title ?? '-' }}<br><span style="color:var(--muted);font-size:11px;">{{ $vocab->lesson->course->title ?? '' }}</span></td>
            <td><span class="badge badge-{{ $vocab->difficulty }}">{{ ucfirst($vocab->difficulty) }}</span></td>
            <td>{{ $vocab->sort_order }}</td>
            <td>
                <div class="row-actions" style="justify-content:flex-end;">
                    <a href="{{ route('admin.vocabulary.edit', $vocab) }}" class="act-edit">Edit</a>
                    <form action="{{ route('admin.vocabulary.destroy', $vocab) }}" method="POST" onsubmit="return confirm('Hapus kosakata &quot;{{ $vocab->term }}&quot;?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="act-delete">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr class="empty-row"><td colspan="6">Belum ada data kosakata.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:16px;">
    {{ $vocabularies->links() }}
</div>

</x-app-layout>
