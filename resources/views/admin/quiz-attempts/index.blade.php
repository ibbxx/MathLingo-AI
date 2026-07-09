<x-app-layout>

@section('page-title', 'Aktivitas Quiz Siswa')

<style>
    .admin-page { padding: 28px 28px 40px; }
    .admin-page-header { margin-bottom: 20px; }
    .admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; }
    .admin-page-sub   { font-size: 13.5px; color: var(--color-muted); margin: 0; }

    .stat-row { display:grid; grid-template-columns: repeat(3, 1fr); gap:14px; margin-bottom:20px; }
    .stat-card { background:var(--color-surface); border:1px solid var(--color-border); border-radius:var(--radius-card); box-shadow:var(--shadow-card); padding:16px 18px; }
    .stat-card-num { font-size:22px; font-weight:800; color:var(--color-text); }
    .stat-card-label { font-size:12px; font-weight:600; color:var(--color-muted); margin-top:2px; }

    .filter-row { margin-bottom: 16px; }
    .filter-row select {
        padding: 8px 12px; border: 1.5px solid var(--color-border); border-radius: 9px;
        font-size: 13px; font-family: inherit; background:#fff;
    }

    table.attempt-table { width:100%; border-collapse:collapse; background:var(--color-surface); border-radius:var(--radius-card); overflow:hidden; box-shadow:var(--shadow-card); }
    table.attempt-table th, table.attempt-table td { padding:12px 16px; text-align:left; font-size:13.5px; border-bottom:1px solid var(--color-border); }
    table.attempt-table th { background:#FAFBFC; font-weight:700; color:var(--color-text); font-size:12px; text-transform:uppercase; letter-spacing:0.03em; }
    table.attempt-table td.num { font-weight:700; }
    .badge-benar { color:#16A34A; }
    .badge-salah { color:#EF4444; }
    .badge-xp { color:#2563EB; }
    .btn-review {
        display:inline-flex; align-items:center; gap:6px;
        padding:7px 14px; border-radius:9px; font-size:12.5px; font-weight:700;
        background:var(--color-primary,#2563EB); color:#fff; text-decoration:none;
    }
    .btn-review:hover { opacity:0.9; }
</style>


<div class="admin-page">
    <div class="admin-page-header">
        <h1 class="admin-page-title">Aktivitas Quiz Siswa</h1>
        <p class="admin-page-sub">Rekap skor & XP yang diperoleh siswa dari mengerjakan quiz, per siswa.</p>
    </div>

    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-card-num">{{ $stats['total_students'] }}</div>
            <div class="stat-card-label">Siswa Sudah Mengerjakan</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-num">{{ $stats['total_attempts'] }}</div>
            <div class="stat-card-label">Total Soal Dikerjakan</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-num">{{ $stats['total_xp'] }}</div>
            <div class="stat-card-label">Total XP Diberikan</div>
        </div>
    </div>

    <form method="GET" class="filter-row">
        <select name="lesson_id" onchange="this.form.submit()">
            <option value="">Semua Pelajaran</option>
            @foreach($lessons as $lesson)
                <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>{{ $lesson->title }}</option>
            @endforeach
        </select>
    </form>

    <table class="attempt-table">
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Dikerjakan</th>
                <th>Benar</th>
                <th>Salah</th>
                <th>Total XP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perStudent as $row)
                <tr>
                    <td>
                        <div style="font-weight:700;">{{ $row->user->name ?? '—' }}</div>
                        <div style="font-size:12px;color:var(--color-muted);">{{ $row->user->email ?? '' }}</div>
                    </td>
                    <td class="num">{{ $row->total_dikerjakan }}</td>
                    <td class="num badge-benar">{{ $row->total_benar }}</td>
                    <td class="num badge-salah">{{ $row->total_salah }}</td>
                    <td class="num badge-xp">{{ $row->total_xp }} XP</td>
                    <td>
                        @if($row->user)
                            <a href="{{ route('admin.quiz-attempts.show', $row->user_id) }}" class="btn-review">
                                Lihat Detail
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;color:var(--color-muted);padding:30px;">Belum ada siswa yang mengerjakan quiz.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:16px;">{{ $perStudent->links() }}</div>
</div>

</x-app-layout>
