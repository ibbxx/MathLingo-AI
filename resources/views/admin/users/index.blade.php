<x-admin-layout title="Manajemen Pengguna">

<style>
/* ── Page Layout ──────────────────────────────────────────── */
.admin-page { padding: 28px 28px 48px; }
.admin-page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub { font-size: 13.5px; color: var(--color-muted); margin: 0; }

/* ── Stats Cards ──────────────────────────────────────────── */
.stats-row { display: grid; grid-template-columns: repeat(5,1fr); gap: 14px; margin-bottom: 24px; }
.stat-card {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 16px;
    padding: 16px 18px;
    box-shadow: var(--shadow-card);
}
.stat-card-label { font-size: 12px; font-weight: 600; color: var(--color-muted); margin: 0 0 6px; text-transform: uppercase; letter-spacing: 0.5px; }
.stat-card-value { font-size: 26px; font-weight: 800; color: var(--color-text); line-height: 1; margin: 0; }
.stat-card-sub { font-size: 12px; color: var(--color-muted); margin: 4px 0 0; }

/* ── Toolbar ──────────────────────────────────────────────── */
.toolbar {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 16px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: flex-end;
    box-shadow: var(--shadow-card);
}
.toolbar-field { display: flex; flex-direction: column; gap: 5px; }
.toolbar-label { font-size: 11.5px; font-weight: 600; color: var(--color-muted); }
.toolbar-input, .toolbar-select {
    height: 38px;
    border: 1px solid var(--color-border);
    border-radius: 10px;
    padding: 0 12px;
    font-size: 13.5px;
    color: var(--color-text);
    background: var(--color-bg);
    font-family: inherit;
    outline: none;
    transition: border-color 0.15s;
}
.toolbar-input:focus, .toolbar-select:focus { border-color: var(--color-primary); }
.toolbar-input { min-width: 220px; }
.toolbar-select { min-width: 140px; }
.toolbar-date { min-width: 140px; }
.toolbar-actions { display: flex; gap: 8px; margin-left: auto; align-items: flex-end; }
.btn { display: inline-flex; align-items: center; gap: 7px; padding: 0 16px; height: 38px; border-radius: 10px; font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; text-decoration: none; transition: opacity 0.15s, background 0.15s; white-space: nowrap; }
.btn-primary { background: var(--color-primary); color: #fff; }
.btn-primary:hover { opacity: 0.9; }
.btn-outline { background: transparent; border: 1px solid var(--color-border); color: var(--color-text); }
.btn-outline:hover { background: #F1F5F9; }
.btn-danger { background: var(--color-danger); color: #fff; }
.btn-danger:hover { opacity: 0.9; }
.btn-sm { height: 30px; padding: 0 11px; font-size: 12.5px; border-radius: 8px; }
.btn-ghost { background: transparent; border: none; color: var(--color-muted); cursor: pointer; font-family: inherit; font-size: 13px; padding: 4px 8px; border-radius: 6px; transition: background 0.12s; }
.btn-ghost:hover { background: #F1F5F9; color: var(--color-text); }

/* ── Table ────────────────────────────────────────────────── */
.table-card {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 16px;
    box-shadow: var(--shadow-card);
    overflow: hidden;
}
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th {
    padding: 12px 16px;
    font-size: 11.5px;
    font-weight: 700;
    color: var(--color-muted);
    text-align: left;
    border-bottom: 1px solid var(--color-border);
    background: #FAFBFC;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    white-space: nowrap;
}
thead th a { color: var(--color-muted); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
thead th a:hover { color: var(--color-primary); }
tbody tr { border-bottom: 1px solid var(--color-border); transition: background 0.1s; }
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: #FAFBFC; }
tbody td { padding: 14px 16px; font-size: 13.5px; color: var(--color-text); vertical-align: middle; }

/* ── User Cell ────────────────────────────────────────────── */
.user-cell { display: flex; align-items: center; gap: 12px; }
.user-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    background: var(--color-primary-20);
    color: var(--color-primary);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 13px;
    flex-shrink: 0; overflow: hidden;
}
.user-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
.user-name { font-weight: 600; color: var(--color-text); font-size: 13.5px; line-height: 1.2; }
.user-username { font-size: 12px; color: var(--color-muted); }

/* ── Badges ───────────────────────────────────────────────── */
.badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 20px;
    font-size: 11.5px; font-weight: 600; white-space: nowrap;
}
.badge-student   { background: #EFF6FF; color: #2563EB; }
.badge-admin     { background: #FEF3C7; color: #B45309; }
.badge-active    { background: #F0FDF4; color: #16A34A; }
.badge-inactive  { background: #F8FAFC; color: #64748B; border: 1px solid #E5E7EB; }
.badge-suspended { background: #FEF2F2; color: #DC2626; }

/* ── Actions cell ─────────────────────────────────────────── */
.actions-cell { display: flex; align-items: center; gap: 6px; }

/* ── Table footer ─────────────────────────────────────────── */
.table-footer { padding: 14px 20px; border-top: 1px solid var(--color-border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; background: #FAFBFC; }
.table-info { font-size: 13px; color: var(--color-muted); }
.pagination { display: flex; gap: 4px; align-items: center; }
.pagination a, .pagination span {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 34px; height: 34px; padding: 0 8px;
    border-radius: 8px; font-size: 13px; font-weight: 500;
    color: var(--color-text); text-decoration: none;
    border: 1px solid var(--color-border);
    background: var(--color-surface);
    transition: background 0.12s;
}
.pagination a:hover { background: var(--color-primary-10); color: var(--color-primary); border-color: var(--color-primary-20); }
.pagination .active { background: var(--color-primary); color: #fff; border-color: var(--color-primary); }
.pagination .disabled { opacity: 0.4; pointer-events: none; }

/* ── Empty ────────────────────────────────────────────────── */
.empty-state { text-align: center; padding: 56px 32px; }
.empty-state-icon { width: 60px; height: 60px; border-radius: 18px; background: var(--color-primary-10); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: var(--color-primary); }
.empty-state-title { font-size: 16px; font-weight: 700; color: var(--color-text); margin: 0 0 6px; }
.empty-state-desc { font-size: 13.5px; color: var(--color-muted); margin: 0; }

/* ── Alert ────────────────────────────────────────────────── */
.alert { padding: 12px 16px; border-radius: 10px; font-size: 13.5px; font-weight: 500; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
.alert-success { background: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; }
.alert-error   { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }

/* ── Modal ────────────────────────────────────────────────── */
.modal-overlay {
    display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45);
    z-index: 999; align-items: center; justify-content: center; padding: 20px;
}
.modal-overlay.open { display: flex; }
.modal {
    background: var(--color-surface); border-radius: 20px;
    padding: 28px; max-width: 420px; width: 100%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: modalIn 0.2s ease;
}
@keyframes modalIn { from { opacity:0; transform:scale(0.95); } to { opacity:1; transform:scale(1); } }
.modal-icon { width: 52px; height: 52px; border-radius: 16px; background: #FEF2F2; color: #DC2626; display: flex; align-items: center; justify-content: center; margin: 0 0 16px; }
.modal-title { font-size: 17px; font-weight: 800; color: var(--color-text); margin: 0 0 6px; }
.modal-desc { font-size: 13.5px; color: var(--color-muted); margin: 0 0 24px; line-height: 1.6; }
.modal-actions { display: flex; gap: 10px; justify-content: flex-end; }

/* ── Status dropdown ──────────────────────────────────────── */
.status-dropdown-wrap { position: relative; }
.status-dropdown { position: absolute; top: calc(100% + 4px); right: 0; background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); width: 160px; z-index: 100; display: none; }
.status-dropdown.open { display: block; }
.status-dropdown-item { display: flex; align-items: center; gap: 8px; padding: 10px 14px; font-size: 13px; font-weight: 500; color: var(--color-text); cursor: pointer; border: none; background: none; width: 100%; font-family: inherit; text-align: left; }
.status-dropdown-item:first-child { border-radius: 12px 12px 0 0; }
.status-dropdown-item:last-child  { border-radius: 0 0 12px 12px; }
.status-dropdown-item:hover { background: #F1F5F9; }
.status-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.dot-active    { background: #16A34A; }
.dot-inactive  { background: #94A3B8; }
.dot-suspended { background: #DC2626; }

@media (max-width: 900px) {
    .stats-row { grid-template-columns: repeat(3,1fr); }
}
@media (max-width: 600px) {
    .admin-page { padding: 16px 16px 48px; }
    .stats-row { grid-template-columns: repeat(2,1fr); }
    .toolbar { flex-direction: column; }
    .toolbar-input { min-width: 100%; }
}
</style>

<div class="admin-page">

    {{-- Header --}}
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Manajemen Pengguna</h1>
            <p class="admin-page-sub">Kelola data pengguna platform: student dan administrator.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah User
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <p class="stat-card-label">Total User</p>
            <p class="stat-card-value">{{ number_format($stats['total']) }}</p>
            <p class="stat-card-sub">Semua pengguna</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Aktif</p>
            <p class="stat-card-value" style="color:#16A34A;">{{ number_format($stats['active']) }}</p>
            <p class="stat-card-sub">Status active</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Suspended</p>
            <p class="stat-card-value" style="color:#DC2626;">{{ number_format($stats['suspended']) }}</p>
            <p class="stat-card-sub">Dibekukan</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Student</p>
            <p class="stat-card-value" style="color:var(--color-primary);">{{ number_format($stats['students']) }}</p>
            <p class="stat-card-sub">Role student</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Admin</p>
            <p class="stat-card-value" style="color:#B45309;">{{ number_format($stats['admins']) }}</p>
            <p class="stat-card-sub">Role admin</p>
        </div>
    </div>

    {{-- Toolbar / Filter --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="toolbar" id="filterForm">
        <div class="toolbar-field">
            <label class="toolbar-label">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, username, email, HP..." class="toolbar-input">
        </div>
        <div class="toolbar-field">
            <label class="toolbar-label">Role</label>
            <select name="role" class="toolbar-select" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Student</option>
                <option value="admin"   {{ request('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="toolbar-field">
            <label class="toolbar-label">Status</label>
            <select name="status" class="toolbar-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>Aktif</option>
                <option value="inactive"  {{ request('status') === 'inactive'  ? 'selected' : '' }}>Tidak Aktif</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>
        <div class="toolbar-field">
            <label class="toolbar-label">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="toolbar-input toolbar-date">
        </div>
        <div class="toolbar-field">
            <label class="toolbar-label">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="toolbar-input toolbar-date">
        </div>
        <div class="toolbar-actions">
            <button type="submit" class="btn btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Cari
            </button>
            @if(request()->hasAny(['search','role','status','date_from','date_to']))
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Reset</a>
            @endif
        </div>
        <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
        <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
    </form>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Pengguna
                                @if(request('sort') === 'name')
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        @if(request('direction') === 'asc')<polyline points="18 15 12 9 6 15"/>@else<polyline points="6 9 12 15 18 9"/>@endif
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => request('sort') === 'email' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Email
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'role', 'direction' => request('sort') === 'role' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Role
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Status
                            </a>
                        </th>
                        <th>XP / Level</th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Bergabung
                            </a>
                        </th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        @php
                            $initials = strtoupper(substr($user->name, 0, 2));
                            $avatarTs = $user->profile?->updated_at?->timestamp ?? 0;
                        @endphp
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        @if($user->profile?->avatar_url)
                                            <img src="{{ asset('storage/' . $user->profile->avatar_url) }}?v={{ $avatarTs }}"
                                                 alt="{{ $user->name }}"
                                                 onerror="this.remove();this.parentElement.innerHTML='{{ $initials }}';">
                                        @else
                                            {{ $initials }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-username">{{ $user->username ? '@'.$user->username : $user->phone ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--color-muted);font-size:13px;">{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-student' }}">
                                    {{ $user->role === 'admin' ? 'Admin' : 'Student' }}
                                </span>
                            </td>
                            <td>
                                <div class="status-dropdown-wrap">
                                    <button class="badge {{ match($user->status) { 'active' => 'badge-active', 'inactive' => 'badge-inactive', 'suspended' => 'badge-suspended', default => 'badge-inactive' } }}"
                                            style="cursor:pointer;border:none;font-family:inherit;"
                                            onclick="toggleStatusDropdown(this, event)"
                                            data-user-id="{{ $user->id }}">
                                        {{ match($user->status) { 'active' => 'Aktif', 'inactive' => 'Tidak Aktif', 'suspended' => 'Suspended', default => 'Aktif' } }}
                                        ▾
                                    </button>
                                    @if($user->id !== auth()->id())
                                    <div class="status-dropdown" id="sd-{{ $user->id }}">
                                        @foreach(['active' => 'Aktif', 'inactive' => 'Tidak Aktif', 'suspended' => 'Suspended'] as $val => $label)
                                        <form method="POST" action="{{ route('admin.users.status.toggle', $user) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $val }}">
                                            <button type="submit" class="status-dropdown-item">
                                                <span class="status-dot dot-{{ $val }}"></span>
                                                {{ $label }}
                                            </button>
                                        </form>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($user->profile)
                                    <div style="font-weight:600;color:var(--color-primary);">{{ number_format($user->profile->xp_total) }} XP</div>
                                    <div style="font-size:12px;color:var(--color-muted);">Level {{ $user->profile->current_level }}</div>
                                @else
                                    <span style="color:var(--color-muted);font-size:13px;">—</span>
                                @endif
                            </td>
                            <td style="color:var(--color-muted);font-size:12.5px;white-space:nowrap;">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline btn-sm" title="Detail">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-sm" title="Edit">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <button class="btn btn-danger btn-sm" title="Hapus"
                                            onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    </div>
                                    <p class="empty-state-title">Tidak ada pengguna</p>
                                    <p class="empty-state-desc">Belum ada pengguna yang sesuai filter.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="table-footer">
            <span class="table-info">
                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pengguna
            </span>
            <nav class="pagination">
                @if($users->onFirstPage())
                    <span class="disabled">‹</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}">‹</a>
                @endif

                @foreach($users->getUrlRange(max(1, $users->currentPage()-2), min($users->lastPage(), $users->currentPage()+2)) as $page => $url)
                    @if($page == $users->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}">›</a>
                @else
                    <span class="disabled">›</span>
                @endif
            </nav>
        </div>
        @else
        <div class="table-footer">
            <span class="table-info">{{ $users->total() }} pengguna</span>
        </div>
        @endif
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
        </div>
        <h3 class="modal-title">Hapus Pengguna</h3>
        <p class="modal-desc" id="deleteModalDesc">Pengguna dan seluruh data terkait akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
// Delete Modal
function openDeleteModal(id, name) {
    document.getElementById('deleteModalDesc').textContent =
        'Anda akan menghapus pengguna "' + name + '" beserta seluruh data terkait secara permanen. Tindakan ini tidak dapat dibatalkan.';
    document.getElementById('deleteForm').action = '/admin/users/' + id;
    document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});

// Status Dropdown
function toggleStatusDropdown(btn, e) {
    e.stopPropagation();
    const wrap = btn.closest('.status-dropdown-wrap');
    const dd = wrap.querySelector('.status-dropdown');
    if (!dd) return;
    document.querySelectorAll('.status-dropdown.open').forEach(el => {
        if (el !== dd) el.classList.remove('open');
    });
    dd.classList.toggle('open');
}
document.addEventListener('click', function() {
    document.querySelectorAll('.status-dropdown.open').forEach(el => el.classList.remove('open'));
});
</script>

</x-admin-layout>