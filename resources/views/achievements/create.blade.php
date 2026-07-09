<x-app-layout>

@section('page-title', 'Buat Achievement')

<style>
:root {
    --primary:   #2563EB; --p10: #EFF6FF; --p20: #DBEAFE;
    --success:   #10B981; --s10: #ECFDF5;
    --warning:   #F59E0B; --w10: #FFFBEB;
    --danger:    #EF4444; --d10: #FEF2F2;
    --bg:        #F8FAFC; --surface: #FFFFFF; --border: #E5E7EB;
    --text:      #111827; --muted: #6B7280;
    --r-card:    20px;
    --shadow:    0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.05);
    --shadow-md: 0 4px 8px rgba(0,0,0,0.08), 0 12px 32px rgba(0,0,0,0.08);
}

/* Breadcrumb */
.breadcrumb { display:flex; align-items:center; gap:8px; font-size:13px; color:var(--muted); margin-bottom:24px; }
.breadcrumb a { color:var(--muted); text-decoration:none; }
.breadcrumb a:hover { color:var(--primary); }
.breadcrumb-sep { color:#D1D5DB; }
.breadcrumb-current { color:var(--text); font-weight:600; }

/* Layout */
.form-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 28px;
    align-items: start;
}

/* Card */
.card { background:var(--surface); border-radius:var(--r-card); box-shadow:var(--shadow); }
.card-header {
    padding: 22px 28px 18px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items:center; gap:12px;
}
.card-header-icon {
    width: 38px; height: 38px; border-radius: 11px;
    display: flex; align-items:center; justify-content:center;
    flex-shrink: 0;
}
.card-header-title  { font-size:16px; font-weight:700; color:var(--text); }
.card-header-sub    { font-size:12px; color:var(--muted); margin-top:2px; }
.card-body { padding: 24px 28px; }

/* Form elements */
.form-section-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 14px;
    margin-top: 24px;
    padding-bottom: 8px;
    border-bottom: 1px solid #F3F4F6;
}
.form-section-label:first-child { margin-top: 0; }

.form-group { margin-bottom: 18px; }
.form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 7px;
}
.form-label span { color: var(--danger); margin-left: 2px; }
.form-control {
    width: 100%;
    padding: 10px 14px;
    background: #F8FAFC;
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    color: var(--text);
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    box-sizing: border-box;
}
.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    background: #fff;
}
.form-control.error { border-color: var(--danger); }
textarea.form-control { resize: vertical; min-height: 90px; }
select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 38px;
}
.form-hint { font-size: 12px; color: var(--muted); margin-top: 5px; line-height: 1.4; }
.form-error { font-size: 12px; color: var(--danger); margin-top: 5px; display:flex; align-items:center; gap:4px; }

/* Toggle / checkbox */
.toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #F3F4F6;
}
.toggle-row:last-child { border-bottom: none; }
.toggle-label { font-size:13px; font-weight:600; color:var(--text); }
.toggle-sub   { font-size:12px; color:var(--muted); margin-top:2px; }
.toggle-switch {
    position: relative;
    width: 44px; height: 24px;
    flex-shrink: 0;
}
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
    position: absolute;
    inset: 0;
    background: #E5E7EB;
    border-radius: 99px;
    cursor: pointer;
    transition: background 0.2s;
}
.toggle-slider::before {
    content: '';
    position: absolute;
    top: 3px; left: 3px;
    width: 18px; height: 18px;
    background: #fff;
    border-radius: 50%;
    transition: transform 0.2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}
.toggle-switch input:checked + .toggle-slider { background: var(--primary); }
.toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }

/* Grid 2 col */
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

/* Buttons */
.btn {
    display: inline-flex; align-items:center; gap:8px;
    padding: 11px 22px; border-radius: 11px;
    font-size: 14px; font-weight: 600; font-family: inherit;
    cursor: pointer; text-decoration: none; border: none;
    transition: all 0.15s;
}
.btn-primary { background: var(--primary); color: #fff; }
.btn-primary:hover { background: #1D4ED8; }
.btn-ghost   { background: #F8FAFC; color: var(--muted); border: 1px solid var(--border); }
.btn-ghost:hover { background: #F1F5F9; color: var(--text); }
.form-actions { display: flex; gap: 12px; margin-top: 8px; }

/* Preview sidebar */
.preview-card {
    background: var(--surface);
    border-radius: var(--r-card);
    box-shadow: var(--shadow);
    overflow: hidden;
    position: sticky;
    top: 88px;
}
.preview-top {
    height: 100px;
    display: flex; align-items:center; justify-content:center;
    position: relative;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    transition: background 0.3s;
}
.preview-icon-big { font-size: 44px; line-height: 1; }
.preview-body { padding: 18px 20px 20px; }
.preview-title-text { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
.preview-desc-text { font-size: 12px; color: var(--muted); margin-bottom: 12px; line-height:1.5; }
.preview-xp-badge {
    display: inline-flex; align-items:center; gap:4px;
    background: var(--w10); color: #92400E;
    font-size: 12px; font-weight: 700;
    padding: 4px 10px; border-radius: 99px;
}
.preview-label { font-size:10px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:10px; }

/* Rarity colors */
.rarity-common    { background: linear-gradient(135deg,#10B981 0%,#059669 100%); }
.rarity-rare      { background: linear-gradient(135deg,#2563EB 0%,#06B6D4 100%); }
.rarity-epic      { background: linear-gradient(135deg,#8B5CF6 0%,#EC4899 100%); }
.rarity-legendary { background: linear-gradient(135deg,#F59E0B 0%,#EF4444 100%); }

/* Flash/errors */
.alert-danger {
    background: var(--d10);
    border: 1px solid #FECACA;
    border-radius: 12px;
    padding: 14px 18px;
    font-size: 13px;
    color: var(--danger);
    margin-bottom: 20px;
}
.alert-danger ul { margin: 6px 0 0 16px; padding: 0; }
.alert-danger li { margin-bottom: 3px; }

.fade-in { animation: fadeIn 0.35s ease both; }
@keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }

@media (max-width: 900px) {
    .form-layout { grid-template-columns: 1fr; }
    .form-row    { grid-template-columns: 1fr; }
    .preview-card { position: static; }
}
</style>

<div style="padding: 28px 32px;">

    {{-- Breadcrumb --}}
    <div class="breadcrumb fade-in">
        <a href="{{ route('achievements.index') }}">Pencapaian</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Buat Baru</span>
    </div>

    @if($errors->any())
    <div class="alert-danger fade-in">
        <strong>Ada beberapa kesalahan:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('achievements.store') }}" id="ach-form">
    @csrf

    <div class="form-layout">

        {{-- ── KIRI: Form utama ────────────────────────────────────────── --}}
        <div>
            <div class="card fade-in">
                <div class="card-header">
                    <div class="card-header-icon" style="background: var(--p10);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                        </svg>
                    </div>
                    <div>
                        <div class="card-header-title">Buat Achievement Baru</div>
                        <div class="card-header-sub">Isi semua detail achievement yang ingin kamu buat.</div>
                    </div>
                </div>

                <div class="card-body">

                    {{-- ── INFORMASI DASAR ─────────────────────────────── --}}
                    <div class="form-section-label">Informasi Dasar</div>

                    <div class="form-group">
                        <label class="form-label">Judul <span>*</span></label>
                        <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'error' : '' }}"
                               value="{{ old('title') }}" placeholder="Contoh: Langkah Pertama" id="title-input">
                        @error('title')
                            <div class="form-error">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control {{ $errors->has('slug') ? 'error' : '' }}"
                               value="{{ old('slug') }}" placeholder="langkah-pertama (otomatis jika kosong)" id="slug-input">
                        <div class="form-hint">Akan dibuat otomatis dari judul jika dikosongkan.</div>
                        @error('slug') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control {{ $errors->has('description') ? 'error' : '' }}"
                                  placeholder="Jelaskan achievement ini secara singkat..." id="desc-input">{{ old('description') }}</textarea>
                        @error('description') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kategori <span>*</span></label>
                            <select name="category" class="form-control {{ $errors->has('category') ? 'error' : '' }}">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Rarity <span>*</span></label>
                            <select name="rarity" class="form-control {{ $errors->has('rarity') ? 'error' : '' }}" id="rarity-select">
                                @foreach($rarities as $rar)
                                    <option value="{{ $rar }}" {{ old('rarity', 'common') === $rar ? 'selected' : '' }}>
                                        {{ ucfirst($rar) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rarity') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- ── TAMPILAN ─────────────────────────────────────── --}}
                    <div class="form-section-label">Tampilan</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Icon (Emoji)</label>
                            <input type="text" name="icon" class="form-control {{ $errors->has('icon') ? 'error' : '' }}"
                                   value="{{ old('icon', '🏅') }}" placeholder="🏅" id="icon-input"
                                   style="font-size:22px; text-align:center;">
                            <div class="form-hint">Gunakan satu emoji sebagai ikon.</div>
                            @error('icon') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Warna</label>
                            <input type="text" name="color" class="form-control {{ $errors->has('color') ? 'error' : '' }}"
                                   value="{{ old('color', '#2563EB') }}" placeholder="#2563EB">
                            <div class="form-hint">Format hex, contoh: #2563EB</div>
                            @error('color') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- ── PERSYARATAN ──────────────────────────────────── --}}
                    <div class="form-section-label">Persyaratan & Reward</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Tipe Persyaratan</label>
                            <select name="requirement_type" class="form-control {{ $errors->has('requirement_type') ? 'error' : '' }}">
                                <option value="">— Tidak ada —</option>
                                <option value="xp_total"          {{ old('requirement_type') === 'xp_total'          ? 'selected' : '' }}>Total XP</option>
                                <option value="streak_days"       {{ old('requirement_type') === 'streak_days'       ? 'selected' : '' }}>Streak Hari</option>
                                <option value="lessons_completed" {{ old('requirement_type') === 'lessons_completed' ? 'selected' : '' }}>Pelajaran Selesai</option>
                                <option value="courses_completed" {{ old('requirement_type') === 'courses_completed' ? 'selected' : '' }}>Kursus Selesai</option>
                                <option value="current_level"     {{ old('requirement_type') === 'current_level'     ? 'selected' : '' }}>Level Dicapai</option>
                                <option value="ai_messages"       {{ old('requirement_type') === 'ai_messages'       ? 'selected' : '' }}>Pesan ke AI Tutor</option>
                            </select>
                            @error('requirement_type') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nilai Persyaratan <span>*</span></label>
                            <input type="number" name="requirement_value" class="form-control {{ $errors->has('requirement_value') ? 'error' : '' }}"
                                   value="{{ old('requirement_value', 1) }}" min="1" placeholder="1">
                            @error('requirement_value') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">XP Reward <span>*</span></label>
                        <input type="number" name="xp_reward" class="form-control {{ $errors->has('xp_reward') ? 'error' : '' }}"
                               value="{{ old('xp_reward', 50) }}" min="0" id="xp-input" placeholder="50">
                        <div class="form-hint">Jumlah XP yang diberikan saat achievement dibuka.</div>
                        @error('xp_reward') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- ── PENGATURAN ───────────────────────────────────── --}}
                    <div class="form-section-label">Pengaturan</div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-label">Achievement Tersembunyi</div>
                            <div class="toggle-sub">Jika aktif, achievement tidak tampil di daftar publik.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_hidden" value="1" {{ old('is_hidden') ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-label">Achievement Aktif</div>
                            <div class="toggle-sub">Hanya achievement aktif yang dapat diraih.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    {{-- Actions --}}
                    <div class="form-actions" style="margin-top:28px;">
                        <button type="submit" class="btn btn-primary">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Simpan Achievement
                        </button>
                        <a href="{{ route('achievements.index') }}" class="btn btn-ghost">Batal</a>
                    </div>

                </div>
            </div>
        </div>{{-- /left --}}

        {{-- ── KANAN: Preview ──────────────────────────────────────────── --}}
        <div>
            <div class="preview-card fade-in">
                <div style="padding: 16px 20px 12px; border-bottom: 1px solid var(--border);">
                    <div class="preview-label">Pratinjau</div>
                    <div style="font-size:11px; color:var(--muted);">Tampilan card achievement</div>
                </div>

                <div id="preview-top" class="preview-top rarity-common">
                    <div class="preview-icon-big" id="preview-icon">🏅</div>
                </div>

                <div class="preview-body">
                    <div class="preview-title-text" id="preview-title">Judul Achievement</div>
                    <div class="preview-desc-text" id="preview-desc">Deskripsi achievement akan muncul di sini...</div>
                    <div class="preview-xp-badge">
                        ⭐ <span id="preview-xp">50</span> XP
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /form-layout --}}
    </form>

</div>

<script>
(function () {
    // Auto-slug dari title
    const titleInput = document.getElementById('title-input');
    const slugInput  = document.getElementById('slug-input');
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function () {
            if (!slugInput._edited) {
                slugInput.value = titleInput.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .trim()
                    .replace(/\s+/g, '-');
            }
            document.getElementById('preview-title').textContent = titleInput.value || 'Judul Achievement';
        });
        slugInput.addEventListener('input', function () { slugInput._edited = true; });
    }

    // Preview desc
    const descInput = document.getElementById('desc-input');
    if (descInput) {
        descInput.addEventListener('input', function () {
            document.getElementById('preview-desc').textContent = descInput.value || 'Deskripsi achievement akan muncul di sini...';
        });
    }

    // Preview icon
    const iconInput = document.getElementById('icon-input');
    if (iconInput) {
        iconInput.addEventListener('input', function () {
            document.getElementById('preview-icon').textContent = iconInput.value || '🏅';
        });
    }

    // Preview XP
    const xpInput = document.getElementById('xp-input');
    if (xpInput) {
        xpInput.addEventListener('input', function () {
            document.getElementById('preview-xp').textContent = xpInput.value || '0';
        });
    }

    // Preview rarity gradient
    const raritySelect = document.getElementById('rarity-select');
    const previewTop   = document.getElementById('preview-top');
    const gradients = {
        common:    'rarity-common',
        rare:      'rarity-rare',
        epic:      'rarity-epic',
        legendary: 'rarity-legendary',
    };
    if (raritySelect && previewTop) {
        raritySelect.addEventListener('change', function () {
            previewTop.className = 'preview-top ' + (gradients[this.value] || 'rarity-common');
        });
    }
})();
</script>

</x-app-layout>