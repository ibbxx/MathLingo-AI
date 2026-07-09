<x-admin-layout title="Tambah Pengguna">

<style>
.admin-page { padding: 28px 28px 48px; }
.page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 24px; }
.back-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 10px; border: 1px solid var(--color-border); background: var(--color-surface); color: var(--color-muted); font-size: 13px; font-weight: 500; text-decoration: none; transition: background 0.12s; }
.back-btn:hover { background: #F1F5F9; color: var(--color-text); }
.admin-page-title { font-size: 20px; font-weight: 800; color: var(--color-text); margin: 0; }

.form-card {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 20px;
    box-shadow: var(--shadow-card);
    overflow: hidden;
    max-width: 820px;
}
.form-section { padding: 24px 28px; border-bottom: 1px solid var(--color-border); }
.form-section:last-of-type { border-bottom: none; }
.form-section-title { font-size: 13px; font-weight: 700; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 18px; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group.full { grid-column: 1/-1; }
.form-label { font-size: 13px; font-weight: 600; color: var(--color-text); }
.form-label span { color: var(--color-danger); }
.form-input, .form-select, .form-textarea {
    border: 1px solid var(--color-border);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13.5px;
    color: var(--color-text);
    background: var(--color-bg);
    font-family: inherit;
    outline: none;
    transition: border-color 0.15s;
    width: 100%;
    box-sizing: border-box;
}
.form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--color-primary); background: var(--color-surface); }
.form-textarea { resize: vertical; min-height: 80px; }
.form-error { font-size: 12px; color: var(--color-danger); }
.form-hint { font-size: 12px; color: var(--color-muted); }

/* Avatar Upload */
.avatar-upload-wrap { display: flex; align-items: center; gap: 20px; }
.avatar-preview {
    width: 80px; height: 80px; border-radius: 50%;
    background: var(--color-primary-20);
    color: var(--color-primary);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; font-weight: 700;
    flex-shrink: 0; overflow: hidden;
    border: 2px solid var(--color-border);
}
.avatar-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
.avatar-upload-actions { display: flex; flex-direction: column; gap: 8px; }
.btn-upload { display: inline-flex; align-items: center; gap: 7px; padding: 0 14px; height: 36px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; border: 1px solid var(--color-border); background: var(--color-surface); color: var(--color-text); font-family: inherit; transition: background 0.12s; }
.btn-upload:hover { background: #F1F5F9; }

/* Student fields (hidden when role=admin) */
#studentFields { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

/* Form footer */
.form-footer { padding: 20px 28px; background: #FAFBFC; border-top: 1px solid var(--color-border); display: flex; gap: 12px; justify-content: flex-end; }
.btn { display: inline-flex; align-items: center; gap: 7px; padding: 0 20px; height: 40px; border-radius: 10px; font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; text-decoration: none; transition: opacity 0.15s, background 0.15s; }
.btn-primary { background: var(--color-primary); color: #fff; }
.btn-primary:hover { opacity: 0.9; }
.btn-outline { background: transparent; border: 1px solid var(--color-border); color: var(--color-text); }
.btn-outline:hover { background: #F1F5F9; }

.alert { padding: 12px 16px; border-radius: 10px; font-size: 13.5px; font-weight: 500; margin-bottom: 16px; }
.alert-error { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }

@media(max-width:600px) {
    .admin-page { padding: 16px; }
    .form-grid, #studentFields { grid-template-columns: 1fr; }
}
</style>

<div class="admin-page">

    <div class="page-header">
        <a href="{{ route('admin.users.index') }}" class="back-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
        <h1 class="admin-page-title">Tambah Pengguna Baru</h1>
    </div>

    @if($errors->any())
        <div class="alert alert-error" style="max-width:820px;margin-bottom:16px;">
            <ul style="margin:0;padding:0 0 0 16px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" class="form-card" id="createForm">
        @csrf

        {{-- Informasi Dasar --}}
        <div class="form-section">
            <p class="form-section-title">Informasi Dasar</p>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span>*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Masukkan nama lengkap" required>
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" class="form-input" placeholder="username (opsional)">
                    @error('username')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email <span>*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="email@domain.com" required>
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="+62...">
                    @error('phone')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Password <span>*</span></label>
                    <input type="password" name="password" class="form-input" placeholder="Minimal 8 karakter" required>
                    @error('password')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password <span>*</span></label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Role <span>*</span></label>
                    <select name="role" class="form-select" id="roleSelect" onchange="handleRoleChange()" required>
                        <option value="student" {{ old('role','student') === 'student' ? 'selected' : '' }}>Student</option>
                        <option value="admin"   {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active"    {{ old('status','active') === 'active'    ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive"  {{ old('status') === 'inactive'  ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
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
                <div class="avatar-upload-wrap">
                    <div class="avatar-preview" id="avatarPreview">U</div>
                    <div class="avatar-upload-actions">
                        <label class="btn-upload">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Pilih Foto
                            <input type="file" name="avatar" id="avatarInput" accept="image/jpg,image/jpeg,image/png,image/webp" style="display:none;" onchange="previewAvatar(this)">
                        </label>
                        <span class="form-hint">JPG, PNG, WebP. Maks 2MB.</span>
                    </div>
                </div>
                @error('avatar')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div id="studentFields">
                <div class="form-group">
                    <label class="form-label">Jenjang Pendidikan</label>
                    <select name="educational_level" class="form-select">
                        <option value="junior_high"   {{ old('educational_level') === 'junior_high'   ? 'selected' : '' }}>Junior High School</option>
                        <option value="senior_high"   {{ old('educational_level','senior_high') === 'senior_high'   ? 'selected' : '' }}>Senior High School</option>
                        <option value="undergraduate" {{ old('educational_level') === 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                        <option value="teacher"       {{ old('educational_level') === 'teacher'       ? 'selected' : '' }}>Teacher</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tujuan Belajar</label>
                    <select name="learning_goal" class="form-select">
                        <option value="vocabulary"          {{ old('learning_goal','vocabulary') === 'vocabulary'          ? 'selected' : '' }}>Improve Mathematical Vocabulary</option>
                        <option value="problem_solving"     {{ old('learning_goal') === 'problem_solving'     ? 'selected' : '' }}>Improve Problem Solving</option>
                        <option value="olympiad"            {{ old('learning_goal') === 'olympiad'            ? 'selected' : '' }}>Prepare for Olympiad</option>
                        <option value="international_exams" {{ old('learning_goal') === 'international_exams' ? 'selected' : '' }}>Prepare for International Exams</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Negara</label>
                    <input type="text" name="country" value="{{ old('country') }}" class="form-input" placeholder="Indonesia">
                </div>
                <div class="form-group full">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-textarea" placeholder="Deskripsi singkat tentang pengguna...">{{ old('bio') }}</textarea>
                    <span class="form-hint">Maksimal 500 karakter.</span>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan Pengguna
            </button>
        </div>
    </form>
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
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</x-admin-layout>