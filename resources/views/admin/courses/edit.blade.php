<x-admin-layout title="Edit Kursus">

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
.breadcrumb a { color: var(--color-muted); text-decoration: none; }
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

.form-label { font-size: 13px; font-weight: 600; color: var(--color-text); }
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
    background-repeat: no-repeat; background-position: right 10px center; padding-right: 30px;
}
.form-hint  { font-size: 12px; color: var(--color-muted); }
.form-error { font-size: 12px; color: var(--color-danger); font-weight: 600; }

.slug-row { display: flex; align-items: center; gap: 8px; }
.slug-row .form-input { flex: 1; }
.btn-generate {
    padding: 9px 13px; border: 1.5px solid var(--color-border);
    border-radius: 9px; background: #F1F5F9; color: var(--color-muted);
    font-size: 12px; font-weight: 600; font-family: inherit; cursor: pointer;
    white-space: nowrap; transition: border-color 0.12s, color 0.12s;
}
.btn-generate:hover { border-color: var(--color-primary); color: var(--color-primary); }

.color-row { display: flex; align-items: center; gap: 10px; }
.color-preview { width: 36px; height: 36px; border-radius: 8px; border: 2px solid var(--color-border); flex-shrink: 0; }
.color-swatches { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
.swatch { width: 24px; height: 24px; border-radius: 6px; cursor: pointer; border: 2px solid transparent; transition: transform 0.12s, border-color 0.12s; }
.swatch:hover { transform: scale(1.15); }
.swatch.active { border-color: var(--color-text); }

/* Thumbnail section */
.thumb-section { display: flex; flex-direction: column; gap: 10px; }
.thumb-current {
    position: relative; display: inline-block; width: fit-content;
}
.thumb-current img {
    width: 120px; height: 80px; object-fit: cover;
    border-radius: 10px; display: block; box-shadow: var(--shadow-card);
}
.thumb-current-label {
    font-size: 11px; font-weight: 600; color: var(--color-muted);
    margin-bottom: 6px;
}
.btn-remove-thumb {
    position: absolute; top: -6px; right: -6px;
    width: 20px; height: 20px; border-radius: 50%;
    background: #EF4444; color: #fff; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; line-height: 1;
}

.thumb-drop {
    border: 2px dashed var(--color-border); border-radius: 12px;
    padding: 18px; text-align: center; cursor: pointer;
    transition: border-color 0.15s, background 0.15s;
    position: relative; overflow: hidden;
}
.thumb-drop:hover { border-color: var(--color-primary); background: var(--color-primary-10); }
.thumb-drop input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
.thumb-drop-text { font-size: 13px; font-weight: 600; color: var(--color-text); }
.thumb-drop-hint { font-size: 12px; color: var(--color-muted); margin-top: 3px; }
.thumb-preview { margin-top: 10px; display: none; }
.thumb-preview img { max-width: 100px; border-radius: 8px; }

.toggle-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.toggle-info .toggle-label { font-size: 13.5px; font-weight: 600; color: var(--color-text); }
.toggle-info .toggle-hint  { font-size: 12px; color: var(--color-muted); margin-top: 2px; }
.toggle-switch {
    width: 44px; height: 24px; border-radius: 99px; background: #CBD5E1;
    position: relative; cursor: pointer; flex-shrink: 0; transition: background 0.2s;
}
.toggle-switch input { display: none; }
.toggle-switch .toggle-knob {
    position: absolute; width: 18px; height: 18px; border-radius: 50%;
    background: #fff; top: 3px; left: 3px;
    transition: transform 0.2s; box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}
.toggle-switch.on { background: var(--color-primary); }
.toggle-switch.on .toggle-knob { transform: translateX(20px); }

.form-footer {
    display: flex; align-items: center; justify-content: flex-end;
    gap: 10px; padding: 18px 24px;
    border-top: 1px solid var(--color-border); background: #FAFBFC;
}
.btn-cancel {
    padding: 10px 20px; border: 1.5px solid var(--color-border);
    border-radius: 10px; background: transparent; color: var(--color-muted);
    font-size: 13.5px; font-weight: 600; font-family: inherit; cursor: pointer;
    text-decoration: none; transition: border-color 0.12s, color 0.12s;
}
.btn-cancel:hover { border-color: var(--color-primary); color: var(--color-primary); }
.btn-submit {
    padding: 10px 22px; border: none; border-radius: 10px;
    background: var(--color-primary); color: #fff;
    font-size: 13.5px; font-weight: 700; font-family: inherit; cursor: pointer;
    display: inline-flex; align-items: center; gap: 7px; transition: opacity 0.15s;
}
.btn-submit:hover { opacity: 0.88; }

.flash {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 11px;
    font-size: 13.5px; font-weight: 600; margin-bottom: 16px;
}
.flash-success { background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; }

@media (max-width: 767px) {
    .admin-page { padding: 16px 16px 32px; }
    .form-grid { grid-template-columns: 1fr; }
    .form-group.full { grid-column: 1; }
}
</style>
@endpush

<div class="admin-page">

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('admin.courses.index') }}">Manajemen Kursus</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--color-text);font-weight:600;">Edit Kursus</span>
    </div>

    @if(session('success'))
    <div class="flash flash-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="admin-page-header" style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 class="admin-page-title">Edit Kursus</h1>
            <p class="admin-page-sub">{{ $course->title }}</p>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.courses.preview', $course) }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border:1.5px solid var(--color-border);border-radius:9px;font-size:13px;font-weight:600;color:var(--color-muted);text-decoration:none;transition:border-color 0.12s,color 0.12s;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Preview
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data" id="courseForm">
        @csrf @method('PUT')

        {{-- Informasi Dasar --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <span class="panel-title">Informasi Dasar</span>
            </div>
            <div class="panel-body">
                <div class="form-grid">

                    <div class="form-group full">
                        <label class="form-label" for="title">Judul Kursus <span>*</span></label>
                        <input type="text" id="title" name="title" class="form-input"
                               value="{{ old('title', $course->title) }}" required>
                        @error('title')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="slug">Slug URL</label>
                        <div class="slug-row">
                            <input type="text" id="slug" name="slug" class="form-input"
                                   value="{{ old('slug', $course->slug) }}">
                            <button type="button" class="btn-generate" onclick="generateSlug()">Auto Generate</button>
                        </div>
                        @error('slug')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="short_description">Deskripsi Singkat</label>
                        <input type="text" id="short_description" name="short_description" class="form-input"
                               value="{{ old('short_description', $course->short_description) }}" maxlength="500">
                        @error('short_description')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="description">Deskripsi Lengkap</label>
                        <textarea id="description" name="description" class="form-textarea">{{ old('description', $course->description) }}</textarea>
                        @error('description')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category">Kategori <span>*</span></label>
                        <select id="category" name="category" class="form-select" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $course->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="difficulty">Tingkat Kesulitan <span>*</span></label>
                        <select id="difficulty" name="difficulty" class="form-select" required>
                            <option value="beginner"     {{ old('difficulty', $course->difficulty) === 'beginner'     ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('difficulty', $course->difficulty) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced"     {{ old('difficulty', $course->difficulty) === 'advanced'     ? 'selected' : '' }}>Advanced</option>
                        </select>
                        @error('difficulty')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="status">Status <span>*</span></label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="draft"     {{ old('status', $course->status) === 'draft'     ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $course->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived"  {{ old('status', $course->status) === 'archived'  ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="estimated_minutes">Estimasi Durasi (menit)</label>
                        <input type="number" id="estimated_minutes" name="estimated_minutes" class="form-input"
                               value="{{ old('estimated_minutes', $course->estimated_minutes) }}" min="0">
                        @error('estimated_minutes')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="total_xp">Total XP</label>
                        <input type="number" id="total_xp" name="total_xp" class="form-input"
                               value="{{ old('total_xp', $course->total_xp) }}" min="0">
                        @error('total_xp')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sort_order">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-input"
                               value="{{ old('sort_order', $course->sort_order) }}" min="0">
                        @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="icon">Icon (emoji)</label>
                        <input type="text" id="icon" name="icon" class="form-input"
                               value="{{ old('icon', $course->icon) }}" maxlength="10">
                        @error('icon')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- Tampilan --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                </div>
                <span class="panel-title">Tampilan & Media</span>
            </div>
            <div class="panel-body">
                <div class="form-grid">

                    <div class="form-group">
                        <label class="form-label">Warna Tema</label>
                        <div class="color-row">
                            <div class="color-preview" id="colorPreview" style="background:{{ old('color', $course->color) }};"></div>
                            <input type="text" id="colorInput" name="color" class="form-input"
                                   value="{{ old('color', $course->color) }}" maxlength="7" pattern="^#[0-9A-Fa-f]{6}$">
                        </div>
                        <div class="color-swatches">
                            @foreach(['#2563EB','#22C55E','#F59E0B','#EF4444','#8B5CF6','#06B6D4','#EC4899','#F97316','#14B8A6','#6366F1'] as $c)
                                <div class="swatch {{ old('color', $course->color) === $c ? 'active' : '' }}"
                                     style="background:{{ $c }};" data-color="{{ $c }}"
                                     onclick="selectColor('{{ $c }}')"></div>
                            @endforeach
                        </div>
                        @error('color')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Thumbnail</label>
                        <div class="thumb-section">
                            @if($course->thumbnail)
                            <div>
                                <div class="thumb-current-label">Thumbnail saat ini:</div>
                                <div class="thumb-current">
                                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                                    <button type="button" class="btn-remove-thumb" onclick="markRemoveThumb()" title="Hapus thumbnail">×</button>
                                    <input type="hidden" name="remove_thumbnail" id="removeThumbInput" value="0">
                                </div>
                                <div id="removedNotice" style="display:none;font-size:12px;color:#DC2626;font-weight:600;margin-top:4px;">Thumbnail akan dihapus saat disimpan.</div>
                            </div>
                            @endif
                            <div class="thumb-drop">
                                <input type="file" name="thumbnail" id="thumbnailInput"
                                       accept="image/jpeg,image/jpg,image/png,image/webp"
                                       onchange="previewThumb(this)">
                                <div class="thumb-drop-text">{{ $course->thumbnail ? 'Ganti thumbnail' : 'Upload thumbnail' }}</div>
                                <div class="thumb-drop-hint">JPEG, PNG, WebP · Maks 2MB</div>
                                <div class="thumb-preview" id="thumbPreview">
                                    <img id="thumbPreviewImg" src="" alt="Preview">
                                </div>
                            </div>
                        </div>
                        @error('thumbnail')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Featured</label>
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-label">Tampilkan sebagai Featured Course</div>
                                <div class="toggle-hint">Kursus akan ditampilkan di bagian unggulan Student Panel.</div>
                            </div>
                            <label class="toggle-switch {{ old('is_featured', $course->is_featured) ? 'on' : '' }}" id="featuredToggle" onclick="toggleFeature()">
                                <input type="checkbox" name="is_featured" id="featuredCheck"
                                       value="1" {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}>
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
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
const titleInput = document.getElementById('title');
const slugInput  = document.getElementById('slug');

titleInput.addEventListener('input', function() {
    if (slugInput.dataset.manual !== 'true') slugInput.value = slugify(this.value);
});
slugInput.addEventListener('input', function() {
    this.dataset.manual = 'true';
    this.value = slugify(this.value, true);
});
function slugify(str, preserve = false) {
    if (preserve) return str.toLowerCase().replace(/\s+/g,'-').replace(/[^a-z0-9-]/g,'');
    return str.toLowerCase().trim().replace(/\s+/g,'-').replace(/[^a-z0-9-]/g,'').replace(/-+/g,'-');
}
function generateSlug() {
    slugInput.value = slugify(titleInput.value);
    slugInput.dataset.manual = 'false';
}

function selectColor(color) {
    document.getElementById('colorInput').value = color;
    document.getElementById('colorPreview').style.background = color;
    document.querySelectorAll('.swatch').forEach(s => s.classList.toggle('active', s.dataset.color === color));
}
document.getElementById('colorInput').addEventListener('input', function() {
    if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) document.getElementById('colorPreview').style.background = this.value;
});

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

function markRemoveThumb() {
    const input = document.getElementById('removeThumbInput');
    if (!input) return;
    input.value = '1';
    document.getElementById('removedNotice').style.display = 'block';
    const btn = document.querySelector('.btn-remove-thumb');
    if (btn) btn.style.display = 'none';
}

function toggleFeature() {
    const toggle = document.getElementById('featuredToggle');
    const check  = document.getElementById('featuredCheck');
    toggle.classList.toggle('on');
    check.checked = toggle.classList.contains('on');
}
</script>
@endpush

</x-admin-layout>
