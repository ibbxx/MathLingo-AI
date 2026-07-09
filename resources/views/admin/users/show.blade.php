<x-admin-layout title="Detail Pengguna">

<style>
.admin-page { padding: 28px 28px 48px; }
.page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 24px; }
.back-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 10px; border: 1px solid var(--color-border); background: var(--color-surface); color: var(--color-muted); font-size: 13px; font-weight: 500; text-decoration: none; transition: background 0.12s; }
.back-btn:hover { background: #F1F5F9; color: var(--color-text); }
.admin-page-title { font-size: 20px; font-weight: 800; color: var(--color-text); margin: 0; }

.detail-grid { display: grid; grid-template-columns: 300px 1fr; gap: 20px; align-items: start; }

/* Profile Card */
.profile-card { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 20px; box-shadow: var(--shadow-card); overflow: hidden; }
.profile-card-top { padding: 28px 24px 20px; text-align: center; border-bottom: 1px solid var(--color-border); }
.profile-avatar-lg {
    width: 88px; height: 88px; border-radius: 50%;
    background: var(--color-primary-20); color: var(--color-primary);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; font-weight: 800; margin: 0 auto 14px;
    overflow: hidden; border: 3px solid var(--color-border);
}
.profile-avatar-lg img { width: 100%; height: 100%; object-fit: cover; display: block; }
.profile-name { font-size: 17px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; }
.profile-username { font-size: 13px; color: var(--color-muted); margin: 0 0 12px; }
.profile-badges { display: flex; justify-content: center; gap: 6px; flex-wrap: wrap; }

.profile-card-body { padding: 20px 24px; }
.profile-meta-item { display: flex; align-items: flex-start; gap: 10px; padding: 8px 0; border-bottom: 1px solid var(--color-border); }
.profile-meta-item:last-child { border-bottom: none; }
.profile-meta-icon { width: 32px; height: 32px; border-radius: 8px; background: var(--color-primary-10); color: var(--color-primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px; }
.profile-meta-label { font-size: 11px; font-weight: 600; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.4px; margin: 0 0 2px; }
.profile-meta-value { font-size: 13.5px; color: var(--color-text); font-weight: 500; margin: 0; word-break: break-all; }

.profile-actions { padding: 16px 24px; border-top: 1px solid var(--color-border); display: flex; flex-direction: column; gap: 8px; }
.btn { display: inline-flex; align-items: center; gap: 7px; padding: 0 16px; height: 38px; border-radius: 10px; font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; text-decoration: none; transition: opacity 0.15s, background 0.15s; justify-content: center; }
.btn-primary { background: var(--color-primary); color: #fff; }
.btn-primary:hover { opacity: 0.9; }
.btn-outline { background: transparent; border: 1px solid var(--color-border); color: var(--color-text); }
.btn-outline:hover { background: #F1F5F9; }
.btn-danger { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
.btn-danger:hover { background: #FECACA; }

/* Right column */
.right-col { display: flex; flex-direction: column; gap: 16px; }

/* Stats Grid */
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
.stat-box { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 16px; padding: 16px; box-shadow: var(--shadow-card); text-align: center; }
.stat-box-value { font-size: 24px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; line-height: 1; }
.stat-box-label { font-size: 12px; color: var(--color-muted); font-weight: 500; }

/* Sections */
.section-card { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 16px; box-shadow: var(--shadow-card); overflow: hidden; }
.section-header { padding: 16px 20px; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; justify-content: space-between; }
.section-title { font-size: 14px; font-weight: 700; color: var(--color-text); margin: 0; }
.section-body { padding: 16px 20px; }

/* Achievement badges */
.achievement-list { display: flex; flex-wrap: wrap; gap: 10px; }
.achievement-badge { display: flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 20px; background: #F8FAFC; border: 1px solid var(--color-border); font-size: 12.5px; font-weight: 600; color: var(--color-text); }
.achievement-dot { width: 10px; height: 10px; border-radius: 50%; }

/* Progress Table */
.prog-table { width: 100%; border-collapse: collapse; }
.prog-table td { padding: 8px 0; font-size: 13px; border-bottom: 1px solid var(--color-border); }
.prog-table tr:last-child td { border-bottom: none; }
.prog-status { display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 10px; font-size: 11.5px; font-weight: 600; }
.prog-completed  { background: #F0FDF4; color: #16A34A; }
.prog-progress   { background: #EFF6FF; color: #2563EB; }
.prog-notstarted { background: #F8FAFC; color: #64748B; }

/* AI History */
.ai-item { padding: 10px 0; border-bottom: 1px solid var(--color-border); font-size: 13px; color: var(--color-text); display: flex; align-items: center; justify-content: space-between; gap: 10px; }
.ai-item:last-child { border-bottom: none; }
.ai-item-title { font-weight: 500; }
.ai-item-date { font-size: 11.5px; color: var(--color-muted); white-space: nowrap; }

/* Badges */
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; }
.badge-student   { background: #EFF6FF; color: #2563EB; }
.badge-admin     { background: #FEF3C7; color: #B45309; }
.badge-active    { background: #F0FDF4; color: #16A34A; }
.badge-inactive  { background: #F8FAFC; color: #64748B; border: 1px solid #E5E7EB; }
.badge-suspended { background: #FEF2F2; color: #DC2626; }

.empty-text { font-size: 13px; color: var(--color-muted); text-align: center; padding: 20px 0; }

.alert { padding: 12px 16px; border-radius: 10px; font-size: 13.5px; font-weight: 500; margin-bottom: 16px; }
.alert-success { background: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; }
.alert-error { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }

@media(max-width:900px) {
    .detail-grid { grid-template-columns: 1fr; }
    .stats-grid { grid-template-columns: repeat(2,1fr); }
}
@media(max-width:600px) {
    .admin-page { padding: 16px; }
    .stats-grid { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="admin-page">

    <div class="page-header">
        <a href="{{ route('admin.users.index') }}" class="back-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
        <h1 class="admin-page-title">Detail Pengguna</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @php
        $profile  = $user->profile;
        $initials = strtoupper(substr($user->name, 0, 2));
        $avatarTs = $profile?->updated_at?->timestamp ?? 0;
    @endphp

    <div class="detail-grid">

        {{-- Left: Profile Card --}}
        <div>
            <div class="profile-card">
                <div class="profile-card-top">
                    <div class="profile-avatar-lg">
                        @if($profile?->avatar_url)
                            <img src="{{ asset('storage/' . $profile->avatar_url) }}?v={{ $avatarTs }}"
                                 alt="{{ $user->name }}"
                                 onerror="this.remove();this.parentElement.innerHTML='{{ $initials }}';">
                        @else
                            {{ $initials }}
                        @endif
                    </div>
                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <p class="profile-username">{{ $user->username ? '@'.$user->username : 'Tidak ada username' }}</p>
                    <div class="profile-badges">
                        <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-student' }}">{{ ucfirst($user->role) }}</span>
                        <span class="badge {{ match($user->status) { 'active' => 'badge-active', 'inactive' => 'badge-inactive', 'suspended' => 'badge-suspended', default => 'badge-inactive' } }}">
                            {{ match($user->status) { 'active' => 'Aktif', 'inactive' => 'Tidak Aktif', 'suspended' => 'Suspended', default => 'Aktif' } }}
                        </span>
                    </div>
                </div>

                <div class="profile-card-body">
                    <div class="profile-meta-item">
                        <div class="profile-meta-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div>
                            <p class="profile-meta-label">Email</p>
                            <p class="profile-meta-value">{{ $user->email }}</p>
                        </div>
                    </div>
                    @if($user->phone)
                    <div class="profile-meta-item">
                        <div class="profile-meta-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.5 2 2 0 0 1 3.6 1.32h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.13 6.13l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div>
                            <p class="profile-meta-label">Nomor HP</p>
                            <p class="profile-meta-value">{{ $user->phone }}</p>
                        </div>
                    </div>
                    @endif
                    @if($profile?->country)
                    <div class="profile-meta-item">
                        <div class="profile-meta-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <div>
                            <p class="profile-meta-label">Negara</p>
                            <p class="profile-meta-value">{{ $profile->country }}</p>
                        </div>
                    </div>
                    @endif
                    @if($profile)
                    <div class="profile-meta-item">
                        <div class="profile-meta-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        </div>
                        <div>
                            <p class="profile-meta-label">Jenjang</p>
                            <p class="profile-meta-value">{{ $profile->educational_level_label }}</p>
                        </div>
                    </div>
                    <div class="profile-meta-item">
                        <div class="profile-meta-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                        <div>
                            <p class="profile-meta-label">Tujuan Belajar</p>
                            <p class="profile-meta-value">{{ $profile->learning_goal_label }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="profile-meta-item">
                        <div class="profile-meta-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <p class="profile-meta-label">Bergabung</p>
                            <p class="profile-meta-value">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    @if($profile?->bio)
                    <div class="profile-meta-item">
                        <div>
                            <p class="profile-meta-label">Bio</p>
                            <p class="profile-meta-value" style="font-size:13px;line-height:1.5;">{{ $profile->bio }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="profile-actions">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Pengguna
                    </a>
                    @if($user->id !== auth()->id())
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteModal').classList.add('open')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                        Hapus Pengguna
                    </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div class="right-col">

            {{-- Stats --}}
            @if($profile)
            <div class="stats-grid">
                <div class="stat-box">
                    <p class="stat-box-value" style="color:var(--color-primary);">{{ number_format($profile->xp_total) }}</p>
                    <p class="stat-box-label">Total XP</p>
                </div>
                <div class="stat-box">
                    <p class="stat-box-value">{{ $profile->current_level }}</p>
                    <p class="stat-box-label">Level</p>
                </div>
                <div class="stat-box">
                    <p class="stat-box-value" style="color:#F59E0B;">{{ $profile->streak_days }}</p>
                    <p class="stat-box-label">Streak Hari</p>
                </div>
                <div class="stat-box">
                    <p class="stat-box-value" style="color:#8B5CF6;">{{ $profile->gems }}</p>
                    <p class="stat-box-label">Gems</p>
                </div>
                <div class="stat-box">
                    <p class="stat-box-value" style="color:#EF4444;">{{ $profile->hearts }}</p>
                    <p class="stat-box-label">Hearts</p>
                </div>
                <div class="stat-box">
                    <p class="stat-box-value">{{ $completedLessons }}</p>
                    <p class="stat-box-label">Pelajaran Selesai</p>
                </div>
                <div class="stat-box">
                    <p class="stat-box-value" style="font-size:16px;">{{ $profile->league_emoji }} {{ ucfirst($profile->league) }}</p>
                    <p class="stat-box-label">Liga</p>
                </div>
                <div class="stat-box">
                    <p class="stat-box-value">{{ $user->achievements->count() }}</p>
                    <p class="stat-box-label">Achievement</p>
                </div>
            </div>
            @endif

            {{-- Achievements --}}
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">Achievement</h3>
                </div>
                <div class="section-body">
                    @if($user->achievements->count())
                        <div class="achievement-list">
                            @foreach($user->achievements as $ach)
                                <div class="achievement-badge">
                                    <span class="achievement-dot" style="background:{{ $ach->color }};"></span>
                                    {{ $ach->title }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-text">Belum ada achievement.</p>
                    @endif
                </div>
            </div>

            {{-- Course Progress --}}
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">Progress Kursus</h3>
                </div>
                <div class="section-body">
                    @if($user->progress->count())
                        <table class="prog-table">
                            @foreach($user->progress->unique('course_id')->take(10) as $prog)
                            <tr>
                                <td style="font-weight:500;">{{ $prog->course?->title ?? 'Kursus Dihapus' }}</td>
                                <td style="text-align:right;">
                                    <span class="prog-status {{ match($prog->status) { 'completed' => 'prog-completed', 'in_progress' => 'prog-progress', default => 'prog-notstarted' } }}">
                                        {{ match($prog->status) { 'completed' => 'Selesai', 'in_progress' => 'Sedang Belajar', default => 'Belum Mulai' } }}
                                    </span>
                                </td>
                                <td style="text-align:right;color:var(--color-muted);font-size:12px;">{{ $prog->xp_earned }} XP</td>
                            </tr>
                            @endforeach
                        </table>
                    @else
                        <p class="empty-text">Belum ada progress kursus.</p>
                    @endif
                </div>
            </div>

            {{-- AI Tutor History --}}
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">Riwayat AI Tutor</h3>
                    <span style="font-size:12px;color:var(--color-muted);">{{ $user->conversations->count() }} percakapan</span>
                </div>
                <div class="section-body">
                    @if($user->conversations->count())
                        @foreach($user->conversations as $conv)
                            <div class="ai-item">
                                <span class="ai-item-title">{{ Str::limit($conv->title, 60) }}</span>
                                <span class="ai-item-date">{{ $conv->created_at->format('d M Y') }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="empty-text">Belum ada riwayat AI Tutor.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Delete Modal --}}
@if($user->id !== auth()->id())
<div class="modal-overlay" id="deleteModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;align-items:center;justify-content:center;padding:20px;">
    <div style="background:var(--color-surface);border-radius:20px;padding:28px;max-width:420px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <div style="width:52px;height:52px;border-radius:16px;background:#FEF2F2;color:#DC2626;display:flex;align-items:center;justify-content:center;margin:0 0 16px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
        </div>
        <h3 style="font-size:17px;font-weight:800;color:var(--color-text);margin:0 0 8px;">Hapus Pengguna</h3>
        <p style="font-size:13.5px;color:var(--color-muted);margin:0 0 24px;line-height:1.6;">Anda akan menghapus <strong>{{ $user->name }}</strong> beserta seluruh data terkait secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <button class="btn btn-outline" onclick="document.getElementById('deleteModal').classList.remove('open')">Batal</button>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" style="background:#DC2626;color:#fff;border:none;">Ya, Hapus Permanen</button>
            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('deleteModal').style.display = 'flex';
document.getElementById('deleteModal').style.display = 'none';
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
});
</script>
@endif

</x-admin-layout>