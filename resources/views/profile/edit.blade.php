<x-app-layout>

{{--
    ════════════════════════════════════════════════════════════
    BUG FIX — profile/edit.blade.php
    ────────────────────────────────────────────────────────────
    BUG A (Named slot title):
      Fix: <x-slot:title> menggantikan @section('page-title').

    BUG B (Avatar upload — form structure):
      File input <input type="file" name="avatar"> ada di dalam
      <form id="formUploadAvatar"> di dalam <div class="preview-wrap">.
      Struktur ini benar, tapi ada masalah: form hanya muncul setelah
      file dipilih (preview-wrap hidden). Solusi: pindahkan avatarFileInput
      keluar dari preview-wrap agar tidak hilang dari DOM saat hidden,
      dan form tetap submit dengan benar.
      CATATAN: avatarFileInput HARUS berada di dalam formUploadAvatar.
      Kita tidak perlu mengubah ini — sudah benar. Bug avatar bukan di sini.

    BUG C (Avatar cache-bust di edit page):
      Tambah ?v=timestamp + onerror fallback.

    BUG D (optional() accessor):
      Ganti semua optional($profile)->accessor dengan $profile?->accessor.
    ════════════════════════════════════════════════════════════
--}}

<x-slot:title>Edit Profil</x-slot:title>

<style>
    :root {
        --primary:   #2563EB;
        --p10:       #EFF6FF;
        --p20:       #DBEAFE;
        --secondary: #22C55E;
        --s10:       #F0FDF4;
        --accent:    #F59E0B;
        --a10:       #FFFBEB;
        --danger:    #EF4444;
        --d10:       #FEF2F2;
        --bg:        #F8FAFC;
        --surface:   #FFFFFF;
        --border:    #E5E7EB;
        --text:      #1E293B;
        --muted:     #64748B;
        --r-card:    20px;
        --shadow:    0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 8px rgba(0,0,0,0.08),0 12px 32px rgba(0,0,0,0.08);
    }

    .edit-wrap {
        max-width: 900px;
        margin: 0 auto;
        padding: 32px 24px 48px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* ─── PAGE HEADER ────────────────────────────────────── */
    .page-header { display: flex; align-items: center; gap: 16px; }
    .page-header-back {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 10px;
        border: 1px solid var(--border); background: var(--surface);
        color: var(--muted); text-decoration: none;
        transition: background 0.12s, color 0.12s; flex-shrink: 0;
    }
    .page-header-back:hover { background: var(--bg); color: var(--text); }
    .page-header-title { font-size: 20px; font-weight: 800; color: var(--text); letter-spacing: -0.3px; }
    .page-header-sub { font-size: 13px; color: var(--muted); font-weight: 500; }

    /* ─── CARD ──────────────────────────────────────────── */
    .card { background: var(--surface); border-radius: var(--r-card); box-shadow: var(--shadow); overflow: hidden; }
    .card-header {
        display: flex; align-items: center; gap: 10px;
        padding: 20px 24px 16px; border-bottom: 1px solid var(--border);
    }
    .card-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .card-title { font-size: 14px; font-weight: 700; color: var(--text); }
    .card-body { padding: 24px; }

    /* ─── ALERT / STATUS ─────────────────────────────────── */
    .alert {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 10px;
        font-size: 13px; font-weight: 600; margin-bottom: 20px;
    }
    .alert-success { background: var(--s10); color: #15803D; border: 1px solid #BBF7D0; }
    .alert-danger  { background: var(--d10); color: #DC2626; border: 1px solid #FECACA; }

    /* ─── FOTO PROFIL ────────────────────────────────────── */
    .avatar-section {
        display: flex; align-items: center; gap: 24px; padding: 24px; flex-wrap: wrap;
    }
    .avatar-preview-wrap { position: relative; flex-shrink: 0; }
    .avatar-preview {
        width: 96px; height: 96px; border-radius: 50%;
        background: var(--p10); border: 3px solid var(--p20);
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; font-weight: 800; color: var(--primary);
        overflow: hidden; object-fit: cover;
    }
    .avatar-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .avatar-online-dot {
        position: absolute; bottom: 4px; right: 4px;
        width: 16px; height: 16px;
        background: var(--secondary); border: 2px solid #fff; border-radius: 50%;
    }
    .avatar-actions { display: flex; flex-direction: column; gap: 8px; }
    .avatar-actions-title { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 2px; }
    .avatar-actions-sub { font-size: 12px; color: var(--muted); font-weight: 500; margin-bottom: 8px; }
    .avatar-btn-row { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-upload {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; background: var(--primary); color: #fff;
        font-size: 13px; font-weight: 600; border-radius: 9px;
        cursor: pointer; border: none; transition: opacity 0.15s;
    }
    .btn-upload:hover { opacity: 0.88; }
    .btn-delete-avatar {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; background: transparent; color: var(--danger);
        font-size: 13px; font-weight: 600; border-radius: 9px;
        border: 1px solid #FECACA; cursor: pointer; transition: background 0.12s;
    }
    .btn-delete-avatar:hover { background: var(--d10); }

    /* ─── PREVIEW MODAL ─────────────────────────────────── */
    .preview-wrap {
        display: none; margin-top: 12px; background: var(--bg);
        border: 1px solid var(--border); border-radius: 12px; padding: 12px 16px;
        align-items: center; gap: 12px;
    }
    .preview-wrap.show { display: flex; }
    .preview-img { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid var(--p20); }
    .preview-info { flex: 1; }
    .preview-info-name { font-size: 13px; font-weight: 600; color: var(--text); }
    .preview-info-size { font-size: 11px; color: var(--muted); font-weight: 500; }
    .btn-preview-upload {
        padding: 7px 14px; background: var(--primary); color: #fff;
        font-size: 12px; font-weight: 600; border-radius: 8px;
        border: none; cursor: pointer; transition: opacity 0.15s;
    }
    .btn-preview-upload:hover { opacity: 0.88; }
    .btn-preview-cancel {
        padding: 7px 14px; background: transparent; color: var(--muted);
        font-size: 12px; font-weight: 600; border-radius: 8px;
        border: 1px solid var(--border); cursor: pointer; transition: background 0.12s;
    }
    .btn-preview-cancel:hover { background: var(--bg); }

    /* ─── FORM FIELDS ────────────────────────────────────── */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group-full { grid-column: 1 / -1; }
    .form-label { font-size: 12px; font-weight: 700; color: var(--text); letter-spacing: 0.01em; }
    .form-label span { color: var(--danger); margin-left: 2px; }
    .form-input {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid var(--border); border-radius: 10px;
        font-size: 14px; font-weight: 500; color: var(--text);
        background: var(--surface); font-family: inherit;
        transition: border-color 0.15s, box-shadow 0.15s; outline: none;
    }
    .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.08); }
    .form-input.has-error { border-color: var(--danger); box-shadow: 0 0 0 3px rgba(239,68,68,0.08); }
    .form-error { font-size: 11px; font-weight: 600; color: var(--danger); display: flex; align-items: center; gap: 4px; }
    .form-hint { font-size: 11px; color: var(--muted); font-weight: 500; }
    textarea.form-input { resize: vertical; min-height: 90px; }

    /* ─── PASSWORD INPUT WRAP ────────────────────────────── */
    .input-password-wrap { position: relative; }
    .input-password-wrap .form-input { padding-right: 42px; }
    .btn-toggle-pw {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer; color: var(--muted);
        display: flex; align-items: center; justify-content: center;
        padding: 2px; transition: color 0.12s;
    }
    .btn-toggle-pw:hover { color: var(--text); }

    /* ─── PASSWORD STRENGTH ──────────────────────────────── */
    .pw-strength-wrap { display: flex; flex-direction: column; gap: 6px; }
    .pw-strength-bars { display: flex; gap: 4px; }
    .pw-bar { flex: 1; height: 4px; border-radius: 99px; background: var(--border); transition: background 0.3s; }
    .pw-bar.fill-weak     { background: var(--danger); }
    .pw-bar.fill-fair     { background: var(--accent); }
    .pw-bar.fill-good     { background: #3B82F6; }
    .pw-bar.fill-strong   { background: var(--secondary); }
    .pw-strength-label { font-size: 11px; font-weight: 600; color: var(--muted); }
    .pw-checklist { display: grid; grid-template-columns: 1fr 1fr; gap: 4px; margin-top: 4px; }
    .pw-check-item { display: flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 600; color: var(--muted); transition: color 0.2s; }
    .pw-check-item.passed { color: var(--secondary); }
    .pw-check-icon {
        width: 14px; height: 14px; border-radius: 50%;
        border: 1.5px solid var(--border); display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: background 0.2s, border-color 0.2s;
    }
    .pw-check-item.passed .pw-check-icon { background: var(--secondary); border-color: var(--secondary); }

    /* ─── SUBMIT BUTTON ──────────────────────────────────── */
    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 24px; background: var(--primary); color: #fff;
        font-size: 14px; font-weight: 700; border-radius: 10px; border: none;
        cursor: pointer; transition: opacity 0.15s, transform 0.1s; font-family: inherit;
    }
    .btn-submit:hover   { opacity: 0.9; }
    .btn-submit:active  { transform: scale(0.98); }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 20px; background: var(--bg); color: var(--muted);
        font-size: 14px; font-weight: 600; border-radius: 10px;
        border: 1px solid var(--border); cursor: pointer; text-decoration: none;
        font-family: inherit; transition: background 0.12s;
    }
    .btn-cancel:hover { background: #F1F5F9; color: var(--text); }

    /* ─── DANGER ZONE ────────────────────────────────────── */
    .danger-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
    .danger-text-wrap strong { display: block; font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 3px; }
    .danger-text-wrap p { font-size: 12px; color: var(--muted); font-weight: 500; line-height: 1.5; margin: 0; }
    .btn-danger {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px; background: var(--d10); color: var(--danger);
        font-size: 13px; font-weight: 700; border-radius: 9px;
        border: 1px solid #FECACA; cursor: pointer; white-space: nowrap;
        font-family: inherit; transition: background 0.12s; flex-shrink: 0;
    }
    .btn-danger:hover { background: #FEE2E2; }

    /* ─── MODAL ──────────────────────────────────────────── */
    .modal-backdrop {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.45); z-index: 9999;
        align-items: center; justify-content: center;
        padding: 16px; backdrop-filter: blur(4px);
    }
    .modal-backdrop.open { display: flex; }
    .modal-box {
        background: var(--surface); border-radius: 20px; padding: 28px;
        max-width: 420px; width: 100%; box-shadow: var(--shadow-md);
    }
    .modal-title { font-size: 16px; font-weight: 800; color: var(--text); margin: 0 0 6px; }
    .modal-sub { font-size: 13px; color: var(--muted); font-weight: 500; line-height: 1.6; margin: 0 0 20px; }
    .modal-actions { display: flex; gap: 10px; margin-top: 20px; }

    /* ─── TAB ────────────────────────────────────────────── */
    .tab-nav { display: flex; gap: 2px; background: var(--bg); border-radius: 12px; padding: 4px; }
    .tab-btn {
        flex: 1; padding: 9px 16px; border-radius: 9px; border: none;
        background: transparent; font-size: 13px; font-weight: 600; color: var(--muted);
        cursor: pointer; transition: background 0.15s, color 0.15s; font-family: inherit;
        display: flex; align-items: center; justify-content: center; gap: 7px;
    }
    .tab-btn.active { background: var(--surface); color: var(--primary); box-shadow: 0 1px 4px rgba(0,0,0,0.08); }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ─── RESPONSIVE ─────────────────────────────────────── */
    @media (max-width: 640px) {
        .form-grid   { grid-template-columns: 1fr; }
        .pw-checklist { grid-template-columns: 1fr; }
        .avatar-section { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="edit-wrap">

    {{-- ── PAGE HEADER ────────────────────────────────────── --}}
    <div class="page-header">
        <a href="{{ route('profile.index') }}" class="page-header-back" aria-label="Kembali">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
        </a>
        <div>
            <div class="page-header-title">Edit Profil</div>
            <div class="page-header-sub">Kelola informasi akun dan keamanan</div>
        </div>
    </div>

    {{-- ── STATUS ALERTS ───────────────────────────────────── --}}
    @if(session('status') === 'profile-updated')
    <div class="alert alert-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        Informasi profil berhasil diperbarui.
    </div>
    @endif
    @if(session('status') === 'password-updated')
    <div class="alert alert-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        Password berhasil diubah. Silakan login kembali jika diperlukan.
    </div>
    @endif
    @if(session('status') === 'avatar-updated')
    <div class="alert alert-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        Foto profil berhasil diperbarui.
    </div>
    @endif
    @if(session('status') === 'avatar-deleted')
    <div class="alert alert-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        Foto profil berhasil dihapus.
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── TAB NAV ──────────────────────────────────────────── --}}
    <div class="tab-nav" role="tablist">
        <button class="tab-btn {{ !session('open_tab') || session('open_tab') === 'informasi' ? 'active' : '' }}"
                data-tab="informasi" role="tab" type="button">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
            Informasi Akun
        </button>
        <button class="tab-btn {{ session('open_tab') === 'keamanan' ? 'active' : '' }}"
                data-tab="keamanan" role="tab" type="button">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            Keamanan
        </button>
    </div>

    {{-- ══════════════════════════════════════════════════════
         TAB 1 — INFORMASI AKUN
    ══════════════════════════════════════════════════════ --}}
    <div class="tab-panel {{ !session('open_tab') || session('open_tab') === 'informasi' ? 'active' : '' }}"
         id="tab-informasi">

        {{-- Foto Profil --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <div class="card-icon" style="background:#EFF6FF;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </div>
                <span class="card-title">Foto Profil</span>
            </div>

            <div class="avatar-section">
                {{-- Preview Avatar --}}
                @php $avatarTs = $profile?->updated_at?->timestamp ?? 0; @endphp
                <div class="avatar-preview-wrap">
                    <div class="avatar-preview" id="avatarPreviewCircle" @if($profile && $profile->avatar_url) style="background:transparent;" @endif>
                        {{-- BUG FIX C: cache-bust + onerror fallback --}}
                        @if($profile && $profile->avatar_url)
                            <img src="{{ Storage::url($profile->avatar_url) }}?v={{ $avatarTs }}"
                                 alt="Foto profil"
                                 id="avatarCurrentImg"
                                 onerror="this.remove();this.parentElement.style.background='';document.getElementById('avatarInitials').style.display='';">
                        @endif
                        <span id="avatarInitials" {{ ($profile && $profile->avatar_url) ? 'style=display:none;' : '' }}>
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </span>
                    </div>
                    <div class="avatar-online-dot"></div>
                </div>

                <div class="avatar-actions">
                    <div class="avatar-actions-title">Foto Profil</div>
                    <div class="avatar-actions-sub">Format: JPG, JPEG, PNG, WebP · Maks. 2 MB</div>

                    <div class="avatar-btn-row">
                        {{-- Trigger file input — label linked ke avatarFileInput --}}
                        <label for="avatarFileInput" class="btn-upload">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="16 16 12 12 8 16"/>
                                <line x1="12" y1="12" x2="12" y2="21"/>
                                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                            </svg>
                            Unggah Foto
                        </label>

                        {{-- Hapus foto --}}
                        @if($profile && $profile->avatar_url)
                        <form method="POST" action="{{ route('profile.avatar.delete') }}" id="formDeleteAvatar">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-delete-avatar" onclick="openDeleteAvatarModal()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                                Hapus Foto
                            </button>
                        </form>
                        @endif
                    </div>

                    {{--
                        BUG FIX B (Avatar upload form):
                        Form upload avatar dengan enctype multipart/form-data.
                        avatarFileInput HARUS berada di DALAM form ini agar ikut ter-submit.
                        File input hidden, di-trigger oleh <label for="avatarFileInput">.
                        Preview-wrap muncul setelah file dipilih via JS.
                        Submit tombol ada di dalam preview-wrap, yang submit form ini.
                    --}}
                    <form method="POST" action="{{ route('profile.avatar.upload') }}"
                          enctype="multipart/form-data" id="formUploadAvatar">
                        @csrf
                        {{-- File input HARUS di dalam form ini --}}
                        <input type="file" name="avatar" id="avatarFileInput"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               style="display:none;">

                        {{-- Preview sebelum upload --}}
                        <div class="preview-wrap" id="avatarPreviewWrap">
                            <img src="" alt="Preview" class="preview-img" id="avatarPreviewImg">
                            <div class="preview-info">
                                <div class="preview-info-name" id="previewFileName">—</div>
                                <div class="preview-info-size" id="previewFileSize">—</div>
                            </div>
                            <button type="submit" class="btn-preview-upload">Simpan Foto</button>
                            <button type="button" class="btn-preview-cancel" onclick="cancelAvatarPreview()">Batal</button>
                        </div>
                    </form>

                    {{-- Error upload --}}
                    @error('avatar')
                    <div class="alert alert-danger" style="margin-top:8px;margin-bottom:0;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Informasi Akun --}}
        <div class="card">
            <div class="card-header">
                <div class="card-icon" style="background:#EFF6FF;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                </div>
                <span class="card-title">Informasi Akun</span>
            </div>

            <div class="card-body">
                @if($errors->any() && !$errors->hasBag('updatePassword') && !$errors->hasBag('userDeletion'))
                <div class="alert alert-danger" style="margin-bottom:20px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Terdapat kesalahan pada form. Periksa kembali isian Anda.
                </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-grid">
                        {{-- Nama Lengkap --}}
                        <div class="form-group">
                            <label class="form-label" for="name">Nama Lengkap<span>*</span></label>
                            <input type="text" id="name" name="name"
                                   class="form-input {{ $errors->has('name') ? 'has-error' : '' }}"
                                   value="{{ old('name', $user->name) }}"
                                   required autocomplete="name"
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                            <div class="form-error">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="form-group">
                            <label class="form-label" for="username">Username<span>*</span></label>
                            <input type="text" id="username" name="username"
                                   class="form-input {{ $errors->has('username') ? 'has-error' : '' }}"
                                   value="{{ old('username', $user->username) }}"
                                   required autocomplete="username"
                                   placeholder="contoh: miftah_99">
                            @error('username')
                            <div class="form-error">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @else
                            <div class="form-hint">Huruf, angka, strip, dan underscore. Maks 50 karakter.</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label class="form-label" for="email">Email<span>*</span></label>
                            <input type="email" id="email" name="email"
                                   class="form-input {{ $errors->has('email') ? 'has-error' : '' }}"
                                   value="{{ old('email', $user->email) }}"
                                   required autocomplete="email"
                                   placeholder="contoh@email.com">
                            @error('email')
                            <div class="form-error">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- Nomor Telepon --}}
                        <div class="form-group">
                            <label class="form-label" for="phone">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone"
                                   class="form-input {{ $errors->has('phone') ? 'has-error' : '' }}"
                                   value="{{ old('phone', $user->phone) }}"
                                   autocomplete="tel"
                                   placeholder="08xxxxxxxxxx">
                            @error('phone')
                            <div class="form-error">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @else
                            <div class="form-hint">Opsional. Format bebas.</div>
                            @enderror
                        </div>

                        {{-- Bio --}}
                        <div class="form-group form-group-full">
                            <label class="form-label" for="bio">Bio Singkat</label>
                            <textarea id="bio" name="bio"
                                      class="form-input {{ $errors->has('bio') ? 'has-error' : '' }}"
                                      maxlength="500"
                                      placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $profile?->bio) }}</textarea>
                            @error('bio')
                            <div class="form-error">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @else
                            <div class="form-hint" id="bioCounter">
                                <span id="bioCount">{{ strlen(old('bio', $profile?->bio ?? '')) }}</span>/500 karakter
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div style="display:flex;gap:10px;margin-top:24px;flex-wrap:wrap;">
                        <button type="submit" class="btn-submit">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('profile.index') }}" class="btn-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- /tab-informasi --}}

    {{-- ══════════════════════════════════════════════════════
         TAB 2 — KEAMANAN
    ══════════════════════════════════════════════════════ --}}
    <div class="tab-panel {{ session('open_tab') === 'keamanan' ? 'active' : '' }}"
         id="tab-keamanan">

        {{-- Ubah Password --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <div class="card-icon" style="background:#F0FDF4;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>
                <span class="card-title">Ubah Password</span>
            </div>

            <div class="card-body">
                @if($errors->hasBag('updatePassword'))
                <div class="alert alert-danger" style="margin-bottom:20px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    @foreach($errors->getBag('updatePassword')->all() as $err)
                        {{ $err }}
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-grid">
                        {{-- Password Lama --}}
                        <div class="form-group form-group-full">
                            <label class="form-label" for="current_password">
                                Password Lama<span style="color:var(--danger);margin-left:2px;">*</span>
                            </label>
                            <div class="input-password-wrap">
                                <input type="password" id="current_password" name="current_password"
                                       class="form-input {{ $errors->getBag('updatePassword')->has('current_password') ? 'has-error' : '' }}"
                                       autocomplete="current-password"
                                       placeholder="Masukkan password lama">
                                <button type="button" class="btn-toggle-pw" data-target="current_password" aria-label="Tampilkan password">
                                    <svg class="icon-eye" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg class="icon-eye-off" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                        <line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                            @if($errors->getBag('updatePassword')->has('current_password'))
                            <div class="form-error">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $errors->getBag('updatePassword')->first('current_password') }}
                            </div>
                            @endif
                        </div>

                        {{-- Password Baru --}}
                        <div class="form-group">
                            <label class="form-label" for="password">
                                Password Baru<span style="color:var(--danger);margin-left:2px;">*</span>
                            </label>
                            <div class="input-password-wrap">
                                <input type="password" id="password" name="password"
                                       class="form-input {{ $errors->getBag('updatePassword')->has('password') ? 'has-error' : '' }}"
                                       autocomplete="new-password"
                                       placeholder="Min. 8 karakter"
                                       oninput="checkPasswordStrength(this.value)">
                                <button type="button" class="btn-toggle-pw" data-target="password" aria-label="Tampilkan password">
                                    <svg class="icon-eye" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg class="icon-eye-off" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                        <line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                            @if($errors->getBag('updatePassword')->has('password'))
                            <div class="form-error">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $errors->getBag('updatePassword')->first('password') }}
                            </div>
                            @endif
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">
                                Konfirmasi Password Baru<span style="color:var(--danger);margin-left:2px;">*</span>
                            </label>
                            <div class="input-password-wrap">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-input" autocomplete="new-password"
                                       placeholder="Ulangi password baru">
                                <button type="button" class="btn-toggle-pw" data-target="password_confirmation" aria-label="Tampilkan password">
                                    <svg class="icon-eye" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg class="icon-eye-off" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                        <line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Indikator Kekuatan Password --}}
                        <div class="form-group form-group-full" id="pwStrengthWrap" style="display:none;">
                            <div class="pw-strength-wrap">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                                    <span class="form-label" style="margin:0;">Kekuatan Password</span>
                                    <span class="pw-strength-label" id="pwStrengthLabel">—</span>
                                </div>
                                <div class="pw-strength-bars">
                                    <div class="pw-bar" id="pwBar1"></div>
                                    <div class="pw-bar" id="pwBar2"></div>
                                    <div class="pw-bar" id="pwBar3"></div>
                                    <div class="pw-bar" id="pwBar4"></div>
                                </div>
                                <div class="pw-checklist">
                                    <div class="pw-check-item" id="ck-len">
                                        <div class="pw-check-icon">
                                            <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                        Min. 8 karakter
                                    </div>
                                    <div class="pw-check-item" id="ck-upper">
                                        <div class="pw-check-icon">
                                            <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                        Huruf besar (A-Z)
                                    </div>
                                    <div class="pw-check-item" id="ck-lower">
                                        <div class="pw-check-icon">
                                            <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                        Huruf kecil (a-z)
                                    </div>
                                    <div class="pw-check-item" id="ck-num">
                                        <div class="pw-check-icon">
                                            <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                        Angka (0-9)
                                    </div>
                                    <div class="pw-check-item" id="ck-sym">
                                        <div class="pw-check-icon">
                                            <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                        Simbol (!@#$...)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;gap:10px;margin-top:24px;flex-wrap:wrap;">
                        <button type="submit" class="btn-submit">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="card">
            <div class="card-header">
                <div class="card-icon" style="background:#FEF2F2;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                <span class="card-title" style="color:var(--danger);">Zona Berbahaya</span>
            </div>
            <div class="card-body">
                <div class="danger-row">
                    <div class="danger-text-wrap">
                        <strong>Hapus Akun</strong>
                        <p>Aksi ini akan menghapus akun, seluruh progres, XP, streak, dan pencapaian secara permanen. Tidak dapat dibatalkan.</p>
                    </div>
                    <button type="button" class="btn-danger" onclick="openDeleteModal()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        </svg>
                        Hapus Akun
                    </button>
                </div>
            </div>
        </div>

    </div>{{-- /tab-keamanan --}}

</div>{{-- /edit-wrap --}}

{{-- ══════════════════════════════════════════════════════
     MODAL — Konfirmasi Hapus Avatar
══════════════════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalDeleteAvatar">
    <div class="modal-box">
        <div class="modal-title">Hapus foto profil?</div>
        <div class="modal-sub">
            Foto profil Anda akan dihapus dan diganti dengan avatar inisial nama. Aksi ini tidak dapat dibatalkan.
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeDeleteAvatarModal()" style="flex:1;">Batal</button>
            <button type="button" class="btn-danger" onclick="submitDeleteAvatar()" style="flex:1;justify-content:center;">Ya, Hapus</button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     MODAL — Konfirmasi Hapus Akun
══════════════════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modalDeleteAccount">
    <div class="modal-box">
        <div class="modal-title">Hapus akun secara permanen?</div>
        <div class="modal-sub">
            Semua data termasuk profil, progres belajar, XP, streak, dan pencapaian akan dihapus permanen. Aksi ini tidak dapat diurungkan.
        </div>
        <form method="POST" action="{{ route('profile.destroy') }}" id="formDeleteAccount">
            @csrf
            @method('DELETE')
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label" for="delete_password">
                    Konfirmasi Password<span style="color:var(--danger);margin-left:2px;">*</span>
                </label>
                <div class="input-password-wrap">
                    <input type="password" id="delete_password" name="password"
                           class="form-input {{ $errors->hasBag('userDeletion') ? 'has-error' : '' }}"
                           placeholder="Masukkan password Anda" required>
                    <button type="button" class="btn-toggle-pw" data-target="delete_password" aria-label="Tampilkan password">
                        <svg class="icon-eye" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg class="icon-eye-off" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                @error('password', 'userDeletion')
                <div class="form-error">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeDeleteModal()" style="flex:1;">Batal</button>
                <button type="submit" class="btn-danger" style="flex:1;justify-content:center;">Hapus Permanen</button>
            </div>
        </form>
    </div>
</div>

{{-- Buka modal hapus akun otomatis jika ada error validasi --}}
@if($errors->hasBag('userDeletion'))
<script>document.addEventListener('DOMContentLoaded', function() { openDeleteModal(); });</script>
@endif

<script>
(function () {
    /* ── TAB SWITCH ─────────────────────────────── */
    document.querySelectorAll('.tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = this.dataset.tab;
            document.querySelectorAll('.tab-btn').forEach(function (b) { b.classList.remove('active'); });
            document.querySelectorAll('.tab-panel').forEach(function (p) { p.classList.remove('active'); });
            this.classList.add('active');
            document.getElementById('tab-' + target).classList.add('active');
        });
    });

    /* ── SHOW / HIDE PASSWORD ───────────────────── */
    document.querySelectorAll('.btn-toggle-pw').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = document.getElementById(this.dataset.target);
            if (!target) return;
            var isText = target.type === 'text';
            target.type = isText ? 'password' : 'text';
            this.querySelector('.icon-eye').style.display     = isText ? 'block' : 'none';
            this.querySelector('.icon-eye-off').style.display = isText ? 'none'  : 'block';
        });
    });

    /* ── BIO CHARACTER COUNTER ──────────────────── */
    var bioTextarea = document.getElementById('bio');
    var bioCount    = document.getElementById('bioCount');
    if (bioTextarea && bioCount) {
        bioTextarea.addEventListener('input', function () {
            bioCount.textContent = this.value.length;
        });
    }

    /* ── AVATAR FILE PREVIEW ────────────────────── */
    var fileInput    = document.getElementById('avatarFileInput');
    var previewWrap  = document.getElementById('avatarPreviewWrap');
    var previewImg   = document.getElementById('avatarPreviewImg');
    var previewName  = document.getElementById('previewFileName');
    var previewSize  = document.getElementById('previewFileSize');
    var avatarCircle = document.getElementById('avatarPreviewCircle');

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            if (!this.files || !this.files[0]) return;
            var file = this.files[0];

            var allowed = ['image/jpg','image/jpeg','image/png','image/webp'];
            if (!allowed.includes(file.type)) {
                alert('Format foto tidak didukung. Gunakan JPG, JPEG, PNG, atau WebP.');
                this.value = '';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran foto melebihi 2 MB.');
                this.value = '';
                return;
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                if (previewImg)  previewImg.src = e.target.result;
                if (previewName) previewName.textContent = file.name;
                if (previewSize) previewSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
                if (previewWrap) previewWrap.classList.add('show');

                /* Update avatar circle preview */
                if (avatarCircle) {
                    var existing = avatarCircle.querySelector('img');
                    var initials = document.getElementById('avatarInitials');
                    avatarCircle.style.background = 'transparent';
                    if (existing) {
                        existing.src = e.target.result;
                    } else {
                        if (initials) initials.style.display = 'none';
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.cssText = 'width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;';
                        avatarCircle.appendChild(img);
                    }
                }
            };
            reader.readAsDataURL(file);
        });
    }

    /* ── PASSWORD STRENGTH ──────────────────────── */
    window.checkPasswordStrength = function (val) {
        var wrap = document.getElementById('pwStrengthWrap');
        if (wrap) wrap.style.display = val.length > 0 ? 'block' : 'none';

        var checks = {
            len:   val.length >= 8,
            upper: /[A-Z]/.test(val),
            lower: /[a-z]/.test(val),
            num:   /[0-9]/.test(val),
            sym:   /[^A-Za-z0-9]/.test(val),
        };

        Object.keys(checks).forEach(function (key) {
            var el = document.getElementById('ck-' + key);
            if (el) el.classList.toggle('passed', checks[key]);
        });

        var score = Object.values(checks).filter(Boolean).length;
        var bars  = [1,2,3,4].map(function (n) { return document.getElementById('pwBar' + n); });
        var label = document.getElementById('pwStrengthLabel');

        bars.forEach(function (b) { if (b) b.className = 'pw-bar'; });

        var colorClass, labelText;
        if (score <= 1)      { colorClass = 'fill-weak';   labelText = '😟 Sangat Lemah'; }
        else if (score === 2){ colorClass = 'fill-fair';   labelText = '😐 Lemah'; }
        else if (score === 3){ colorClass = 'fill-good';   labelText = '😊 Cukup Kuat'; }
        else if (score === 4){ colorClass = 'fill-strong'; labelText = '😄 Kuat'; }
        else                 { colorClass = 'fill-strong'; labelText = '💪 Sangat Kuat'; }

        for (var i = 0; i < score; i++) {
            if (bars[i]) bars[i].classList.add(colorClass);
        }
        if (label) label.textContent = labelText;
    };

    /* ── MODALS ─────────────────────────────────── */
    window.openDeleteAvatarModal  = function () { document.getElementById('modalDeleteAvatar').classList.add('open'); };
    window.closeDeleteAvatarModal = function () { document.getElementById('modalDeleteAvatar').classList.remove('open'); };
    window.submitDeleteAvatar     = function () { document.getElementById('formDeleteAvatar').submit(); };
    window.openDeleteModal        = function () { document.getElementById('modalDeleteAccount').classList.add('open'); };
    window.closeDeleteModal       = function () { document.getElementById('modalDeleteAccount').classList.remove('open'); };

    ['modalDeleteAvatar','modalDeleteAccount'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('click', function (e) {
                if (e.target === this) this.classList.remove('open');
            });
        }
    });

    /* ── CANCEL AVATAR PREVIEW ──────────────────── */
    window.cancelAvatarPreview = function () {
        var fi = document.getElementById('avatarFileInput');
        if (fi) fi.value = '';
        var wrap = document.getElementById('avatarPreviewWrap');
        if (wrap) wrap.classList.remove('show');
    };

})();
</script>

</x-app-layout>