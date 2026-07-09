<x-admin-layout title="Edit Pengguna">

<style>
.admin-page { padding: 28px 28px 48px; }
.page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 24px; }
.back-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 10px; border: 1px solid var(--color-border); background: var(--color-surface); color: var(--color-muted); font-size: 13px; font-weight: 500; text-decoration: none; transition: background 0.12s; }
.back-btn:hover { background: #F1F5F9; color: var(--color-text); }
.admin-page-title { font-size: 20px; font-weight: 800; color: var(--color-text); margin: 0; }

.form-card { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 20px; box-shadow: var(--shadow-card); overflow: hidden; max-width: 820px; }
.form-section { padding: 24px 28px; border-bottom: 1px solid var(--color-border); }
.form-section:last-of-type { border-bottom: none; }
.form-section-title { font-size: 13px; font-weight: 700; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 18px; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group.full { grid-column: 1/-1; }
.form-label { font-size: 13px; font-weight: 600; color: var(--color-text); }
.form-label span { color: var(--color-danger); }
.form-input, .form-select, .form-textarea {
    border: 1px solid var(--color-border); border-radius: 10px; padding: 10px 14px;
    font-size: 13.5px; color: var(--color-text); background: var(--color-bg);
    font-family: inherit; outline: none; transition: border-color 0.15s; width: 100%; box-sizing: border-box;
}
.form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--color-primary); background: var(--color-surface); }
.form-textarea { resize: vertical; min-height: 80px; }
.form-error { font-size: 12px; color: var(--color-danger); }
.form-hint { font-size: 12px; color: var(--color-muted); }

.avatar-upload-wrap { display: flex; align-items: center; gap: 20px; }
.avatar-preview { width: 80px; height: 80px; border-radius: 50%; background: var(--color-primary-20); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 700; flex-shrink: 0; overflow: hidden; border: 2px solid var(--color-border); }
.avatar-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
.avatar-upload-actions { display: flex; flex-direction: column; gap: 8px; }
.btn-upload { display: inline-flex; align-items: center; gap: 7px; padding: 0 14px; height: 36px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; border: 1px solid var(--color-border); background: var(--color-surface); color: var(--color-text); font-family: inherit; transition: background 0.12s; }
.btn-upload:hover { background: #F1F5F9; }
.btn-del-avatar { display: inline-flex; align-items: center; gap: 7px; padding: 0 14px; height: 36px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; border: 1px solid #FECACA; background: #FEF2F2; color: #DC2626; font-family: inherit; transition: background 0.12s; }
.btn-del-avatar:hover { background: #FECACA; }

.form-footer { padding: 20px 28px; background: #FAFBFC; border-top: 1px solid var(--color-border); display: flex; gap: 12px; justify-content: flex-end; }
.btn { display: inline-flex; align-items: center; gap: 7px; padding: 0 20px; height: 40px; border-radius: 10px; font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; text-decoration: none; transition: opacity 0.15s, background 0.15s; }
.btn-primary { background: var(--color-primary); color: #fff; }
.btn-primary:hover { opacity: 0.9; }
.btn-outline { background: transparent; border: 1px solid var(--color-border); color: var(--color-text); }
.btn-outline:hover { background: #F1F5F9; }
.btn-danger { background: var(--color-danger); color: #fff; }
.btn-danger:hover { opacity: 0.9; }

.alert { padding: 12px 16px; border-radius: 10px; font-size: 13.5px; font-weight: 500; margin-bottom: 16px; }
.alert-success { background: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; }
.alert-error { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }

/* Reset Password Section */
.reset-pw-form { display: none; flex-direction: column; gap: 14px; margin-top: 16px; padding: 16px; background: var(--color-bg); border-radius: 12px; border: 1px solid var(--color-border); }
.reset-pw-form.open { display: flex; }

@media(max-width:600px) {
    .admin-page { padding: 16px; }
    .form-grid, .student-grid { grid-template-columns: 1fr; }
}
</style>

<div class="admin-page">

    <div class="page-header">
        <a href="{{ route('admin.users.show', $user) }}" class="back-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
        <h1 class="admin-page-title">Edit Pengguna</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="max-width:820px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error" style="max-width:820px;">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error" style="max-width:820px;">
            <ul style="margin:0;padding:0 0 0 16px;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Main Edit Form --}}
    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="form-card" style="margin-bottom:16px;">
        @csrf @method('PUT')

        <div class="form-section">
            <p class="form-section-title">Informasi Dasar</p>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span>*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-input" placeholder="username (opsional)">
                    @error('username')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email <span>*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input" placeholder="+62...">
                </div>
                <div class="form-group">
                    <label class="form-label">Role <span>*</span></label>
                    <select name="role" class="form-select" id="roleSelect" onchange="handleRoleChange()" required>
                        <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Student</option>
                        <option value="admin"   {{ old('role', $user->role) === 'admin'   ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status <span>*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="active"    {{ old('status', $user->status) === 'active'    ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive"  {{ old('status', $user->status) === 'inactive'  ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Profil Student --}}
        <div class="form-section" id="studentSection">
            <p class="form-section-title">Profil Student</p>

            {{-- Avatar --}}
            <div style="margin-bottom:20px;">
                <label class="form-label" style="display:block;margin-bottom:10px;">Foto Profil</label>
                @php $avatarTs = $user->profile?->updated_at?->timestamp ?? 0; $initials = strtoupper(substr($user->name, 0, 2)); @endphp
                <div class="avatar-upload-wrap">
                    <div class="avatar-preview" id="avatarPreview">
                        @if($user->profile?->avatar_url)
                            <img src="{{ asset('storage/' . $user->profile->avatar_url) }}?v={{ $avatarTs }}"
                                 id="avatarImg" alt="{{ $user->name }}"
                                 onerror="this.remove();document.getElementById('avatarPreview').innerHTML='{{ $initials }}';">
                        @else
                            {{ $initials }}
                        @endif
                    </div>
                    <div class="avatar-upload-actions">
                        <label class="btn-upload">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Ganti Foto
                            <input type="file" name="avatar" id="avatarInput" accept="image/jpg,image/jpeg,image/png,image/webp" style="display:none;" onchange="previewAvatar(this)">
                        </label>
                        @if($user->profile?->avatar_url)
                        <button type="button" class="btn-del-avatar" onclick="confirmDeleteAvatar()">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                            Hapus Foto
                        </button>
                        @endif
                        <span class="form-hint">JPG, PNG, WebP. Maks 2MB.</span>
                    </div>
                </div>
                @error('avatar')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-grid student-grid">
                <div class="form-group">
                    <label class="form-label">Jenjang Pendidikan</label>
                    <select name="educational_level" class="form-select">
                        @foreach(['junior_high' => 'Junior High School', 'senior_high' => 'Senior High School', 'undergraduate' => 'Undergraduate', 'teacher' => 'Teacher'] as $val => $label)
                            <option value="{{ $val }}" {{ old('educational_level', $user->profile?->educational_level ?? 'senior_high') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tujuan Belajar</label>
                    <select name="learning_goal" class="form-select">
                        @foreach(['vocabulary' => 'Improve Mathematical Vocabulary', 'problem_solving' => 'Improve Problem Solving', 'olympiad' => 'Prepare for Olympiad', 'international_exams' => 'Prepare for International Exams'] as $val => $label)
                            <option value="{{ $val }}" {{ old('learning_goal', $user->profile?->learning_goal ?? 'vocabulary') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Negara</label>
                    <input type="text" name="country" value="{{ old('country', $user->profile?->country) }}" class="form-input" placeholder="Indonesia">
                </div>
                <div class="form-group full">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-textarea">{{ old('bio', $user->profile?->bio) }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>

    {{-- Reset Password Section --}}
    <div class="form-card" style="max-width:820px;margin-bottom:16px;">
        <div class="form-section">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <p class="form-section-title" style="margin:0 0 2px;">Reset Password</p>
                    <p style="font-size:13px;color:var(--color-muted);margin:0;">Set password baru untuk pengguna ini.</p>
                </div>
                <button type="button" class="btn btn-outline" style="height:36px;font-size:13px;" onclick="toggleResetPw()">Reset Password</button>
            </div>
            <form method="POST" action="{{ route('admin.users.password.reset', $user) }}" class="reset-pw-form" id="resetPwForm">
                @csrf @method('PATCH')
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Password Baru <span>*</span></label>
                        <input type="password" name="new_password" class="form-input" placeholder="Minimal 8 karakter" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password <span>*</span></label>
                        <input type="password" name="new_password_confirmation" class="form-input" placeholder="Ulangi password baru" required>
                    </div>
                </div>
                <div style="display:flex;justify-content:flex-end;">
                    <button type="submit" class="btn btn-danger" style="height:38px;">Set Password Baru</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete User Section --}}
    @if($user->id !== auth()->id())
    <div class="form-card" style="max-width:820px;">
        <div class="form-section" style="border:1px solid #FECACA;border-radius:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <div>
                    <p class="form-section-title" style="margin:0 0 2px;color:#DC2626;">Hapus Pengguna</p>
                    <p style="font-size:13px;color:var(--color-muted);margin:0;">Hapus permanen pengguna beserta seluruh data terkait. Tidak dapat dibatalkan.</p>
                </div>
                <button type="button" class="btn btn-danger" style="height:36px;font-size:13px;" onclick="document.getElementById('deleteModal').classList.add('open')">
                    Hapus Pengguna
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Delete Avatar Form (tersembunyi) --}}
@if($user->profile?->avatar_url)
<form id="deleteAvatarForm" method="POST" action="{{ route('admin.users.avatar.delete', $user) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
@endif

{{-- Delete Modal --}}
<div class="modal-overlay" id="deleteModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;align-items:center;justify-content:center;padding:20px;">
    <div style="background:var(--color-surface);border-radius:20px;padding:28px;max-width:420px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <div style="width:52px;height:52px;border-radius:16px;background:#FEF2F2;color:#DC2626;display:flex;align-items:center;justify-content:center;margin:0 0 16px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
        </div>
        <h3 style="font-size:17px;font-weight:800;color:var(--color-text);margin:0 0 8px;">Hapus Pengguna</h3>
        <p style="font-size:13.5px;color:var(--color-muted);margin:0 0 24px;line-height:1.6;">Anda akan menghapus <strong>{{ $user->name }}</strong> beserta seluruh data terkait secara permanen.</p>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <button class="btn btn-outline" onclick="document.getElementById('deleteModal').classList.remove('open')">Batal</button>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus Permanen</button>
            </form>
        </div>
    </div>
</div>

<script>
function handleRoleChange() {
    const role = document.getElementById('roleSelect').value;
    document.getElementById('studentSection').style.display = role === 'student' ? 'block' : 'none';
}
handleRoleChange();

function previewAvatar(input) {
    const preview = document.getElementById('avatarPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="width:100%;height:100%;object-fit:cover;">'; };
        reader.readAsDataURL(input.files[0]);
    }
}

function confirmDeleteAvatar() {
    if (confirm('Hapus foto profil pengguna ini?')) {
        document.getElementById('deleteAvatarForm').submit();
    }
}

function toggleResetPw() {
    document.getElementById('resetPwForm').classList.toggle('open');
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
});
document.getElementById('deleteModal').style.display = 'flex';
document.getElementById('deleteModal').style.display = 'none';
</script>

</x-admin-layout>