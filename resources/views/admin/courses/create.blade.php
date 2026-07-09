<x-admin-layout title="Tambah Kursus">

@push('styles')
<style>
.admin-page { padding: 28px 28px 40px; max-width: 900px; }
.admin-page-header { margin-bottom: 24px; }
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub   { font-size: 13.5px; color: var(--color-muted); margin: 0; }

.breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 500; color: var(--color-muted);
    margin-bottom: 16px;
}
.breadcrumb a { color: var(--color-muted); text-decoration: none; transition: color 0.12s; }
.breadcrumb a:hover { color: var(--color-primary); }

.panel {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-card);
    overflow: hidden; margin-bottom: 16px;
}
.panel-header {
    padding: 18px 24px 16px; border-bottom: 1px solid var(--color-border);
    display: flex; align-items: center; gap: 10px;
}
.panel-header-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: var(--color-primary-10); color: var(--color-primary);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.panel-title { font-size: 14px; font-weight: 700; color: var(--color-text); }
.panel-body  { padding: 20px 24px; }

.form-grid   { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.form-group  { display: flex; flex-direction: column; gap: 6px; }
.form-group.full { grid-column: 1 / -1; }

.form-label {
    font-size: 13px; font-weight: 600; color: var(--color-text);
}
.form-label span { color: var(--color-danger); margin-left: 2px; }

.form-input, .form-select, .form-textarea {
    padding: 9px 12px; border: 1.5px solid var(--color-border);
    border-radius: 9px; font-size: 13.5px; font-family: inherit;
    color: var(--color-text); background: #FAFBFC; outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
    background: #fff;
}
.form-input::placeholder, .form-textarea::placeholder { color: var(--color-muted); }
.form-textarea { resize: vertical; min-height: 90px; }

.form-select {
    appearance: none; cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
    padding-right: 30px;
}

.form-hint { font-size: 12px; color: var(--color-muted); }
.form-error { font-size: 12px; color: var(--color-danger); font-weight: 600; }

/* Slug row */
.slug-row { display: flex; align-items: center; gap: 8px; }
.slug-row .form-input { flex: 1; }
.btn-generate {
    padding: 9px 13px; border: 1.5px solid var(--color-border);
    border-radius: 9px; background: #F1F5F9; color: var(--color-muted);
    font-size: 12px; font-weight: 600; font-family: inherit; cursor: pointer;
    white-space: nowrap; transition: border-color 0.12s, color 0.12s;
}
.btn-generate:hover { border-color: var(--color-primary); color: var(--color-primary); }

/* Color picker */
.color-row { display: flex; align-items: center; gap: 10px; }
.color-preview {
    width: 36px; height: 36px; border-radius: 8px;
    border: 2px solid var(--color-border); flex-shrink: 0;
    transition: border-color 0.15s;
}
.color-swatches { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
.swatch {
    width: 24px; height: 24px; border-radius: 6px;
    cursor: pointer; border: 2px solid transparent;
    transition: transform 0.12s, border-color 0.12s;
}
.swatch:hover { transform: scale(1.15); }
.swatch.active { border-color: var(--color-text); }

/* Thumbnail upload */
.thumb-drop {
    border: 2px dashed var(--color-border); border-radius: 12px;
    padding: 24px; text-align: center; cursor: pointer;
    transition: border-color 0.15s, background 0.15s;
    position: relative; overflow: hidden;
}
.thumb-drop:hover { border-color: var(--color-primary); background: var(--color-primary-10); }
.thumb-drop input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
.thumb-drop-icon { color: var(--color-muted); margin-bottom: 8px; }
.thumb-drop-text { font-size: 13.5px; font-weight: 600; color: var(--color-text); margin-bottom: 4px; }
.thumb-drop-hint { font-size: 12px; color: var(--color-muted); }
.thumb-preview { margin-top: 12px; display: none; }
.thumb-preview img { max-width: 120px; border-radius: 10px; box-shadow: var(--shadow-card); }

/* Toggle switch */
.toggle-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.toggle-info .toggle-label { font-size: 13.5px; font-weight: 600; color: var(--color-text); }
.toggle-info .toggle-hint  { font-size: 12px; color: var(--color-muted); margin-top: 2px; }
.toggle-switch {
    width: 44px; height: 24px; border-radius: 99px; background: #CBD5E1;
    position: relative; cursor: pointer; flex-shrink: 0;
    transition: background 0.2s;
}
.toggle-switch input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}
.toggle-switch .toggle-knob {
    position: absolute; width: 18px; height: 18px; border-radius: 50%;
    background: #fff; top: 3px; left: 3px;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}
.toggle-switch.on { background: var(--color-primary); }
.toggle-switch.on .toggle-knob { transform: translateX(20px); }

/* Footer actions */
.form-footer {
    display: flex; align-items: center; justify-content: flex-end;
    gap: 10px; padding: 18px 24px;
    border-top: 1px solid var(--color-border);
    background: #FAFBFC;
}
.btn-cancel {
    padding: 10px 20px; border: 1.5px solid var(--color-border);
    border-radius: 10px; background: transparent; color: var(--color-muted);
    font-size: 13.5px; font-weight: 600; font-family: inherit; cursor: pointer;
    text-decoration: none; transition: border-color 0.12s, color 0.12s;
}
.btn-cancel:hover { border-color: var(--color-primary); color: var(--color-primary); }
.btn-submit {
    padding: 10px 22px; border: none;
    border-radius: 10px; background: var(--color-primary); color: #fff;
    font-size: 13.5px; font-weight: 700; font-family: inherit; cursor: pointer;
    display: inline-flex; align-items: center; gap: 7px;
    transition: opacity 0.15s;
}
.btn-submit:hover { opacity: 0.88; }

@media (max-width: 767px) {
    .admin-page { padding: 16px 16px 32px; }
    .form-grid { grid-template-columns: 1fr; }
    .form-group.full { grid-column: 1; }
}
</style>
@endpush

<div class="admin-page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('admin.courses.index') }}">Manajemen Kursus</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--color-text);font-weight:600;">Tambah Kursus</span>
    </div>

    <div class="admin-page-header">
        <h1 class="admin-page-title">Tambah Kursus Baru</h1>
        <p class="admin-page-sub">Isi informasi kursus dengan lengkap untuk tampil di Student Panel.</p>
    </div>

    <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data" id="courseForm">
        @csrf

        {{-- INFORMASI DASAR --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <span class="panel-title">Informasi Dasar</span>
            </div>
            <div class="panel-body">
                <div class="form-grid">

                    {{-- Title --}}
                    <div class="form-group full">
                        <label class="form-label" for="title">Judul Kursus <span>*</span></label>
                        <input type="text" id="title" name="title" class="form-input"
                               placeholder="Contoh: Mathematics in English — Beginner"
                               value="{{ old('title') }}" required autocomplete="off">
                        @error('title')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Slug --}}
                    <div class="form-group full">
                        <label class="form-label" for="slug">Slug URL</label>
                        <div class="slug-row">
                            <input type="text" id="slug" name="slug" class="form-input"
                                   placeholder="otomatis dari judul"
                                   value="{{ old('slug') }}" autocomplete="off">
                            <button type="button" class="btn-generate" onclick="generateSlug()">Auto Generate</button>
                        </div>
                        <div class="form-hint">Kosongkan untuk generate otomatis dari judul.</div>
                        @error('slug')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Short Description --}}
                    <div class="form-group full">
                        <label class="form-label" for="short_description">Deskripsi Singkat</label>
                        <input type="text" id="short_description" name="short_description" class="form-input"
                               placeholder="Ringkasan 1-2 kalimat untuk card kursus..."
                               value="{{ old('short_description') }}" maxlength="500">
                        <div class="form-hint">Maksimal 500 karakter. Tampil di card kursus Student Panel.</div>
                        @error('short_description')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group full">
                        <label class="form-label" for="description">Deskripsi Lengkap</label>
                        <textarea id="description" name="description" class="form-textarea"
                                  placeholder="Deskripsi lengkap kursus, tujuan pembelajaran, dan konten yang akan dipelajari...">{{ old('description') }}</textarea>
                        @error('description')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Category --}}
                    <div class="form-group">
                        <label class="form-label" for="category">Kategori <span>*</span></label>
                        <select id="category" name="category" class="form-select" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Difficulty --}}
                    <div class="form-group">
                        <label class="form-label" for="difficulty">Tingkat Kesulitan <span>*</span></label>
                        <select id="difficulty" name="difficulty" class="form-select" required>
                            <option value="">Pilih Level...</option>
                            <option value="beginner"     {{ old('difficulty') === 'beginner'     ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('difficulty') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced"     {{ old('difficulty') === 'advanced'     ? 'selected' : '' }}>Advanced</option>
                        </select>
                        @error('difficulty')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label" for="status">Status <span>*</span></label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="draft"     {{ old('status', 'draft') === 'draft'     ? 'selected' : '' }}>Draft — Tidak tampil ke Student</option>
                            <option value="published" {{ old('status') === 'published'           ? 'selected' : '' }}>Published — Tampil ke Student</option>
                            <option value="archived"  {{ old('status') === 'archived'            ? 'selected' : '' }}>Archived — Disembunyikan</option>
                        </select>
                        @error('status')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Estimated Minutes --}}
                    <div class="form-group">
                        <label class="form-label" for="estimated_minutes">Estimasi Durasi (menit)</label>
                        <input type="number" id="estimated_minutes" name="estimated_minutes" class="form-input"
                               placeholder="0" value="{{ old('estimated_minutes', 0) }}" min="0" max="99999">
                        @error('estimated_minutes')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Total XP --}}
                    <div class="form-group">
                        <label class="form-label" for="total_xp">Total XP</label>
                        <input type="number" id="total_xp" name="total_xp" class="form-input"
                               placeholder="0" value="{{ old('total_xp', 0) }}" min="0">
                        @error('total_xp')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Sort Order --}}
                    <div class="form-group">
                        <label class="form-label" for="sort_order">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-input"
                               placeholder="0" value="{{ old('sort_order', $maxSortOrder + 1) }}" min="0">
                        <div class="form-hint">Urutan tampil kursus (kecil = lebih atas).</div>
                        @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Icon --}}
                    <div class="form-group">
                        <label class="form-label" for="icon">Icon (emoji)</label>
                        <input type="text" id="icon" name="icon" class="form-input"
                               placeholder="📚" value="{{ old('icon', '📚') }}" maxlength="10">
                        <div class="form-hint">Emoji atau teks pendek sebagai ikon kursus.</div>
                        @error('icon')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- TAMPILAN --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                </div>
                <span class="panel-title">Tampilan & Media</span>
            </div>
            <div class="panel-body">
                <div class="form-grid">

                    {{-- Color --}}
                    <div class="form-group">
                        <label class="form-label" for="colorInput">Warna Tema</label>
                        <div class="color-row">
                            <div class="color-preview" id="colorPreview" style="background:{{ old('color', '#2563EB') }};"></div>
                            <input type="text" id="colorInput" name="color" class="form-input"
                                   placeholder="#2563EB"
                                   value="{{ old('color', '#2563EB') }}" maxlength="7"
                                   pattern="^#[0-9A-Fa-f]{6}$">
                        </div>
                        <div class="color-swatches" id="colorSwatches">
                            @foreach(['#2563EB','#22C55E','#F59E0B','#EF4444','#8B5CF6','#06B6D4','#EC4899','#F97316','#14B8A6','#6366F1'] as $c)
                                <div class="swatch {{ old('color', '#2563EB') === $c ? 'active' : '' }}"
                                     style="background:{{ $c }};"
                                     data-color="{{ $c }}"
                                     onclick="selectColor('{{ $c }}')"></div>
                            @endforeach
                        </div>
                        @error('color')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Thumbnail --}}
                    <div class="form-group">
                        <label class="form-label">Thumbnail</label>
                        <div class="thumb-drop" id="thumbDrop">
                            <input type="file" name="thumbnail" id="thumbnailInput"
                                   accept="image/jpeg,image/jpg,image/png,image/webp"
                                   onchange="previewThumb(this)">
                            <div class="thumb-drop-icon">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <div class="thumb-drop-text">Klik atau drag gambar ke sini</div>
                            <div class="thumb-drop-hint">JPEG, PNG, WebP · Maks 2MB</div>
                            <div class="thumb-preview" id="thumbPreview">
                                <img id="thumbPreviewImg" src="" alt="Preview">
                            </div>
                        </div>
                        @error('thumbnail')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Featured Toggle --}}
                    <div class="form-group full">
                        <label class="form-label">Featured</label>
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-label">Tampilkan sebagai Featured Course</div>
                                <div class="toggle-hint">Kursus akan ditampilkan di bagian unggulan Student Panel.</div>
                            </div>
                            <label class="toggle-switch {{ old('is_featured') ? 'on' : '' }}" id="featuredToggle">
                                <input type="checkbox"
                                name="is_featured"
                                id="featuredCheck"
                                value="1"
                                {{ old('is_featured') ? 'checked' : '' }}>
                                <div class="toggle-knob"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="panel">
            <div class="form-footer">
                <a href="{{ route('admin.courses.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" name="_action" value="draft" class="btn-cancel" style="color:var(--color-muted);">
                    Simpan Draft
                </button>
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Kursus
                </button>
            </div>
        </div>

    </form>
</div>

@push('scripts')
<script>
// Slug auto generate
const titleInput = document.getElementById('title');
const slugInput  = document.getElementById('slug');

titleInput.addEventListener('input', function() {
    if (slugInput.dataset.manual !== 'true') {
        slugInput.value = slugify(this.value);
    }
});
slugInput.addEventListener('input', function() {
    this.dataset.manual = this.value.length > 0 ? 'true' : 'false';
    this.value = slugify(this.value, true);
});

function slugify(str, preserveInput = false) {
    if (preserveInput) return str.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
    return str.toLowerCase().trim().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '').replace(/-+/g, '-');
}

function generateSlug() {
    slugInput.value = slugify(titleInput.value);
    slugInput.dataset.manual = 'false';
}

// Color picker
function selectColor(color) {
    document.getElementById('colorInput').value = color;
    document.getElementById('colorPreview').style.background = color;
    document.querySelectorAll('.swatch').forEach(s => {
        s.classList.toggle('active', s.dataset.color === color);
    });
}
document.getElementById('colorInput').addEventListener('input', function() {
    if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
        document.getElementById('colorPreview').style.background = this.value;
    }
});

// Thumbnail preview
function previewThumb(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('thumbPreviewImg').src = e.target.result;
            document.getElementById('thumbPreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Featured toggle

const featuredCheck = document.getElementById('featuredCheck');
const featuredToggle = document.getElementById('featuredToggle');

featuredCheck.addEventListener('change', function () {
    featuredToggle.classList.toggle('on', this.checked);
});
</script>
@endpush

</x-admin-layout>