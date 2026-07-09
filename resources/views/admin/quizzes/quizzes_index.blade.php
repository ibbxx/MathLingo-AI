<x-app-layout>

@section('page-title', 'Manajemen Kuis')

<style>
    :root {
        --primary: #2563EB; --p10:#EFF6FF;
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
    .q-cell { font-weight:600; max-width:280px; }
    .badge { font-size:11px; font-weight:700; padding:3px 9px; border-radius:99px; display:inline-block; background:var(--p10); color:var(--primary); }
    .status-dot { width:8px; height:8px; border-radius:50%; display:inline-block; margin-right:6px; }
    .row-actions { display:flex; gap:8px; justify-content:flex-end; }
    .row-actions a, .row-actions button { font-size:12px; font-weight:700; text-decoration:none; border:none; background:none; cursor:pointer; padding:0; }
    .act-edit { color:var(--primary); }
    .act-delete { color:var(--danger); }
    .act-toggle { color:var(--muted); }
    .empty-row td { text-align:center; padding:40px; color:var(--muted); }
</style>

<div class="page-head">
    <div>
        <div class="page-title">Manajemen Kuis</div>
        <div class="page-sub">Kelola soal kuis untuk setiap lesson.</div>
    </div>
    <a href="{{ route('admin.quizzes.create') }}" class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Soal
    </a>
</div>

@if(session('success'))
<div style="background:var(--s10);color:#15803D;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px;">
    {{ session('success') }}
</div>
@endif

<div class="stat-grid">
    <div class="stat-card"><div class="stat-val">{{ $stats['total'] }}</div><div class="stat-label">Total Soal</div></div>
    <div class="stat-card"><div class="stat-val">{{ $stats['active'] }}</div><div class="stat-label">Aktif</div></div>
    <div class="stat-card"><div class="stat-val">{{ $stats['inactive'] }}</div><div class="stat-label">Nonaktif</div></div>
    <div class="stat-card"><div class="stat-val">{{ number_format($stats['total_xp']) }}</div><div class="stat-label">Total XP</div></div>
</div>

<form method="GET" action="{{ route('admin.quizzes.index') }}" class="filter-bar">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pertanyaan atau jawaban...">

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

    <select name="question_type" onchange="this.form.submit()">
        <option value="">Semua Tipe</option>
        @foreach($questionTypes as $val => $label)
            <option value="{{ $val }}" @selected(request('question_type') === $val)>{{ $label }}</option>
        @endforeach
    </select>

    <select name="status" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        <option value="active" @selected(request('status') === 'active')>Aktif</option>
        <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
    </select>

    <button type="submit" class="btn-primary" style="padding:9px 16px;">Filter</button>
</form>

<table class="data-table">
    <thead>
        <tr>
            <th>Pertanyaan</th>
            <th>Tipe</th>
            <th>Lesson</th>
            <th>XP / Waktu</th>
            <th>Status</th>
            <th style="text-align:right;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($quizzes as $quiz)
        <tr>
            <td class="q-cell">{{ \Illuminate\Support\Str::limit($quiz->question, 70) }}</td>
            <td><span class="badge">{{ $quiz->question_type_label }}</span></td>
            <td>{{ $quiz->lesson->title ?? '-' }}<br><span style="color:var(--muted);font-size:11px;">{{ $quiz->lesson->course->title ?? '' }}</span></td>
            <td>{{ $quiz->xp_reward }} XP &middot; {{ $quiz->time_limit_seconds }}s</td>
            <td>
                <span class="status-dot" style="background:{{ $quiz->is_active ? '#22C55E' : '#94A3B8' }};"></span>
                {{ $quiz->is_active ? 'Aktif' : 'Nonaktif' }}
            </td>
            <td>
                <div class="row-actions">
                    <form action="{{ route('admin.quizzes.status.toggle', $quiz) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="act-toggle">{{ $quiz->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                    </form>
                    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="act-edit">Edit</a>
                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="act-delete">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr class="empty-row"><td colspan="6">Belum ada data soal kuis.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:16px;">
    {{ $quizzes->links() }}
</div>

</x-app-layout>
