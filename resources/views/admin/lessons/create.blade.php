<x-admin-layout title="Tambah Pelajaran">

@push('styles')
<style>
.admin-page { padding: 28px 28px 40px; max-width: 960px; }
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
    background: var(--color-surface); border: 1px solid var(--color-border);
    border-radius: var(--radius-card); box-shadow: var(--shadow-card);
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

.form-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group.full { grid-column: 1 / -1; }
.form-group.third { grid-column: span 1; }

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

/* Image upload */
.image-upload {
    border: 1.5px dashed var(--color-border); border-radius: 12px;
    padding: 16px; display: flex; align-items: center; gap: 14px; background: #FAFBFC;
}
.image-upload-preview {
    width: 72px; height: 72px; border-radius: 10px; overflow: hidden; flex-shrink: 0;
    background: #F1F5F9; display: flex; align-items: center; justify-content: center;
    color: var(--color-muted); border: 1px solid var(--color-border);
}
.image-upload-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
.image-upload-body { flex: 1; min-width: 0; }
.image-upload-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.btn-file {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 8px; border: 1.5px solid var(--color-border);
    background: #fff; font-size: 12.5px; font-weight: 600; color: var(--color-text);
    cursor: pointer; transition: border-color 0.12s;
}
.btn-file:hover { border-color: var(--color-primary); color: var(--color-primary); }
.btn-file input[type=file] { display: none; }
.btn-remove-image {
    font-size: 12.5px; font-weight: 600; color: var(--color-danger);
    background: none; border: none; cursor: pointer; padding: 0;
}
.image-upload-hint { font-size: 11.5px; color: var(--color-muted); margin-top: 4px; }
.remove-image-flag { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: var(--color-danger); font-weight: 600; margin-top: 8px; }

.slug-row { display: flex; align-items: center; gap: 8px; }
.slug-row .form-input { flex: 1; }
.btn-generate {
    padding: 9px 13px; border: 1.5px solid var(--color-border);
    border-radius: 9px; background: #F1F5F9; color: var(--color-muted);
    font-size: 12px; font-weight: 600; font-family: inherit; cursor: pointer;
    white-space: nowrap; transition: border-color 0.12s, color 0.12s;
}
.btn-generate:hover { border-color: var(--color-primary); color: var(--color-primary); }

/* Toggle */
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

/* Rich text editor */
.editor-wrap {
    border: 1.5px solid var(--color-border); border-radius: 9px;
    overflow: hidden; transition: border-color 0.15s, box-shadow 0.15s;
}
.editor-wrap:focus-within {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
}
.editor-toolbar {
    display: flex; align-items: center; flex-wrap: wrap; gap: 2px;
    padding: 6px 8px; background: #FAFBFC;
    border-bottom: 1px solid var(--color-border);
}
.editor-toolbar button {
    display: flex; align-items: center; justify-content: center;
    width: 28px; height: 28px; border-radius: 6px; border: none;
    background: transparent; color: var(--color-muted); cursor: pointer;
    font-size: 13px; font-weight: 700; font-family: inherit;
    transition: background 0.1s, color 0.1s;
}
.editor-toolbar button:hover { background: var(--color-primary-10); color: var(--color-primary); }
.editor-toolbar button.active { background: var(--color-primary); color: #fff; }
.editor-toolbar .sep { width: 1px; height: 20px; background: var(--color-border); margin: 0 4px; }
.editor-content {
    min-height: 300px; padding: 16px; outline: none;
    font-size: 14px; line-height: 1.7; color: var(--color-text);
    background: #fff;
}
.editor-content:empty::before {
    content: attr(data-placeholder);
    color: var(--color-muted); pointer-events: none;
}
.editor-content h2 { font-size: 18px; font-weight: 700; margin: 16px 0 8px; color: var(--color-text); }
.editor-content h3 { font-size: 15px; font-weight: 700; margin: 14px 0 6px; color: var(--color-text); }
.editor-content ul, .editor-content ol { padding-left: 20px; margin: 8px 0; }
.editor-content li { margin: 4px 0; }
.editor-content table { border-collapse: collapse; width: 100%; margin: 12px 0; }
.editor-content th, .editor-content td { border: 1px solid var(--color-border); padding: 8px 10px; font-size: 13.5px; }
.editor-content th { background: #F8FAFC; font-weight: 700; }
.editor-content blockquote { border-left: 3px solid var(--color-primary); padding-left: 14px; color: var(--color-muted); margin: 12px 0; }
.editor-content code { background: #F1F5F9; padding: 1px 6px; border-radius: 4px; font-size: 13px; font-family: monospace; }
.editor-content .math-block { background: #F8FAFC; padding: 12px; border-radius: 8px; font-family: monospace; margin: 10px 0; border: 1px solid var(--color-border); }
.editor-content img { max-width: 100%; height: auto; border-radius: 8px; margin: 10px 0; display: block; }
#imageUploadBtn.uploading { opacity: 0.5; pointer-events: none; }

.editor-footer { padding: 6px 10px; background: #FAFBFC; border-top: 1px solid var(--color-border); display: flex; justify-content: space-between; }
.editor-footer-tip { font-size: 11.5px; color: var(--color-muted); }

/* Form footer */
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
        <a href="{{ route('admin.lessons.index') }}">Manajemen Pelajaran</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--color-text);font-weight:600;">Tambah Pelajaran</span>
    </div>

    <div class="admin-page-header">
        <h1 class="admin-page-title">Tambah Pelajaran Baru</h1>
        <p class="admin-page-sub">Isi informasi pelajaran dengan lengkap.</p>
    </div>

    <form method="POST" action="{{ route('admin.lessons.store') }}" id="lessonForm" enctype="multipart/form-data">
        @csrf

        {{-- INFORMASI DASAR --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 12h6M12 9v6"/></svg>
                </div>
                <span class="panel-title">Informasi Dasar</span>
            </div>
            <div class="panel-body">
                <div class="form-grid">

                    {{-- Course --}}
                    <div class="form-group full">
                        <label class="form-label" for="course_id">Kursus <span>*</span></label>
                        <select id="course_id" name="course_id" class="form-select" required onchange="updateSortOrder(this.value)">
                            <option value="">Pilih Kursus...</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ old('course_id', $selectedCourseId) == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                    @if($course->status !== 'published') ({{ $course->status }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Title --}}
                    <div class="form-group full">
                        <label class="form-label" for="title">Judul Pelajaran <span>*</span></label>
                        <input type="text" id="title" name="title" class="form-input"
                               placeholder="Contoh: Introduction to Mathematical Vocabulary"
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
                        <div class="form-hint">Slug unik per kursus. Kosongkan untuk generate otomatis.</div>
                        @error('slug')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group full">
                        <label class="form-label" for="description">Deskripsi Singkat</label>
                        <textarea id="description" name="description" class="form-textarea"
                                  placeholder="Deskripsi singkat tentang isi pelajaran ini...">{{ old('description') }}</textarea>
                        @error('description')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Image --}}
                    <div class="form-group full">
                        <label class="form-label" style="margin-bottom:8px;">Gambar Pelajaran (opsional)</label>
                        <div class="image-upload">
                            <div class="image-upload-preview" id="imagePreviewBox">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" id="imagePreviewIcon"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                <img src="" alt="" id="imagePreviewImg" style="display:none;">
                            </div>
                            <div class="image-upload-body">
                                <div class="image-upload-actions">
                                    <label class="btn-file">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Pilih Gambar
                                        <input type="file" name="image" id="imageInput" accept="image/png,image/jpeg,image/webp" onchange="handleImagePreview(this)">
                                    </label>
                                </div>
                                <div class="image-upload-hint">JPG/PNG/WEBP, maks 2MB. Kosongkan jika tidak perlu gambar sampul.</div>
                            </div>
                        </div>
                        @error('image')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Lesson Type --}}
                    <div class="form-group">
                        <label class="form-label" for="lesson_type">Tipe Pelajaran <span>*</span></label>
                        <select id="lesson_type" name="lesson_type" class="form-select" required>
                            <option value="">Pilih Tipe...</option>
                            @foreach($lessonTypes as $value => $label)
                                <option value="{{ $value }}" {{ old('lesson_type') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('lesson_type')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- XP Reward --}}
                    <div class="form-group">
                        <label class="form-label" for="xp_reward">XP Reward <span>*</span></label>
                        <input type="number" id="xp_reward" name="xp_reward" class="form-input"
                               placeholder="10" value="{{ old('xp_reward', 10) }}" min="0" required>
                        <div class="form-hint">XP yang didapat student setelah menyelesaikan pelajaran ini.</div>
                        @error('xp_reward')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Duration --}}
                    <div class="form-group">
                        <label class="form-label" for="duration_minutes">Durasi (menit) <span>*</span></label>
                        <input type="number" id="duration_minutes" name="duration_minutes" class="form-input"
                               placeholder="10" value="{{ old('duration_minutes', 10) }}" min="0" required>
                        @error('duration_minutes')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Sort Order --}}
                    <div class="form-group">
                        <label class="form-label" for="sort_order">Sort Order <span>*</span></label>
                        <input type="number" id="sort_order" name="sort_order" class="form-input"
                               placeholder="0" value="{{ old('sort_order', $maxSortOrder + 1) }}" min="0" required>
                        <div class="form-hint">Urutan tampil pelajaran dalam kursus (kecil = lebih atas).</div>
                        @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Status Toggle --}}
                    <div class="form-group full">
                        <label class="form-label">Status</label>
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-label">Aktifkan Pelajaran</div>
                                <div class="toggle-hint">Pelajaran aktif akan tampil pada kursus di Student Panel.</div>
                            </div>
                            <label class="toggle-switch {{ old('is_active', true) ? 'on' : '' }}" id="activeToggle" onclick="toggleActive()">
                                <input type="checkbox" name="is_active" id="activeCheck"
                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <div class="toggle-knob"></div>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- KONTEN PELAJARAN --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <span class="panel-title">Konten Pelajaran</span>
            </div>
            <div class="panel-body" style="padding: 16px 24px;">

                <div class="editor-wrap">
                    <div class="editor-toolbar" id="editorToolbar">
                        <button type="button" onclick="execCmd('bold')" title="Bold"><b>B</b></button>
                        <button type="button" onclick="execCmd('italic')" title="Italic"><i>I</i></button>
                        <button type="button" onclick="execCmd('underline')" title="Underline"><u>U</u></button>
                        <div class="sep"></div>
                        <button type="button" onclick="execCmd('formatBlock','h2')" title="Heading 2" style="font-size:11px;font-weight:700;width:auto;padding:0 6px;">H2</button>
                        <button type="button" onclick="execCmd('formatBlock','h3')" title="Heading 3" style="font-size:11px;font-weight:700;width:auto;padding:0 6px;">H3</button>
                        <button type="button" onclick="execCmd('formatBlock','p')" title="Paragraph" style="font-size:11px;width:auto;padding:0 6px;">P</button>
                        <div class="sep"></div>
                        <button type="button" onclick="execCmd('insertUnorderedList')" title="Bullet List">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="9" y1="6" x2="20" y2="6"/><line x1="9" y1="12" x2="20" y2="12"/><line x1="9" y1="18" x2="20" y2="18"/><circle cx="4" cy="6" r="1" fill="currentColor"/><circle cx="4" cy="12" r="1" fill="currentColor"/><circle cx="4" cy="18" r="1" fill="currentColor"/></svg>
                        </button>
                        <button type="button" onclick="execCmd('insertOrderedList')" title="Numbered List">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg>
                        </button>
                        <div class="sep"></div>
                        <button type="button" onclick="insertTable()" title="Insert Table">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                        </button>
                        <button type="button" onclick="insertLink()" title="Link">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </button>
                        <div class="sep"></div>
                        <button type="button" onclick="insertMath()" title="Formula Matematika" style="font-size:11px;font-weight:700;width:auto;padding:0 6px;">∑</button>
                        <button type="button" onclick="execCmd('formatBlock','blockquote')" title="Blockquote">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.756 2.017 2 2h2c0 3-1 5-2 5s0 0 0 0"/><path d="M13 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.755 2.017 2 2h2c0 3-1 5-2 5s0 0 0 0"/></svg>
                        </button>
                        <div class="sep"></div>
                        <button type="button" onclick="triggerImageUpload()" title="Sisipkan Gambar" id="imageUploadBtn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </button>
                        <input type="file" id="contentImageInput" accept="image/png,image/jpeg,image/jpg,image/webp,image/gif" style="display:none;" onchange="handleContentImageUpload(this)">
                        <div class="sep"></div>
                        <button type="button" onclick="execCmd('removeFormat')" title="Clear Format">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 9l10.5-3"/><path d="m6.5 12.5 10-3"/><path d="m3 16 10-3"/><path d="m6.5 19.5 3.5-1"/><path d="M20 4 8.5 15.5"/></svg>
                        </button>
                    </div>
                    <div class="editor-content" id="editorContent"
                         contenteditable="true"
                         data-placeholder="Tulis konten pelajaran di sini...&#10;Bisa berisi teks, daftar, tabel, formula matematika, dan lain-lain.">{!! old('content') !!}</div>
                    <div class="editor-footer">
                        <span class="editor-footer-tip">💡 Gunakan toolbar di atas untuk memformat konten. Formula matematika: klik ∑</span>
                        <span class="editor-footer-tip" id="charCount">0 karakter</span>
                    </div>
                </div>

                <textarea name="content" id="contentHidden" style="display:none;">{{ old('content') }}</textarea>
                @error('content')<div class="form-error" style="margin-top:6px;">{{ $message }}</div>@enderror

            </div>
        </div>

        {{-- Footer --}}
        <div class="panel">
            <div class="form-footer">
                <a href="{{ route('admin.lessons.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Pelajaran
                </button>
            </div>
        </div>

    </form>
</div>

@push('scripts')
<script>
// ── Slug ─────────────────────────────────────────────────────────────────────
const titleInput = document.getElementById('title');
const slugInput  = document.getElementById('slug');

titleInput.addEventListener('input', function () {
    if (slugInput.dataset.manual !== 'true') {
        slugInput.value = slugify(this.value);
    }
});
slugInput.addEventListener('input', function () {
    this.dataset.manual = this.value.length > 0 ? 'true' : 'false';
    this.value = slugify(this.value, true);
});
function slugify(str, preserve = false) {
    if (preserve) return str.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
    return str.toLowerCase().trim().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '').replace(/-+/g, '-');
}
function generateSlug() {
    slugInput.value = slugify(titleInput.value);
    slugInput.dataset.manual = 'false';
}

// ── Toggle active ─────────────────────────────────────────────────────────────
function toggleActive() {
    const toggle = document.getElementById('activeToggle');
    const check  = document.getElementById('activeCheck');
    toggle.classList.toggle('on');
    check.checked = toggle.classList.contains('on');
}

// ── Image preview ────────────────────────────────────────────────────────────
function handleImagePreview(input) {
    const img  = document.getElementById('imagePreviewImg');
    const icon = document.getElementById('imagePreviewIcon');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            img.style.display = 'block';
            if (icon) icon.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ── Update sort order by course ──────────────────────────────────────────────
function updateSortOrder(courseId) {
    if (!courseId) return;
    // Sort order stays as-is; this is a UX hint only
}

// ── Rich Text Editor ─────────────────────────────────────────────────────────
const editorContent = document.getElementById('editorContent');
const contentHidden = document.getElementById('contentHidden');
const charCount     = document.getElementById('charCount');

function execCmd(command, value = null) {
    editorContent.focus();
    document.execCommand(command, false, value);
    syncContent();
}

function syncContent() {
    contentHidden.value = editorContent.innerHTML;
    const text = editorContent.innerText || '';
    charCount.textContent = text.length + ' karakter';
}

editorContent.addEventListener('input', syncContent);
editorContent.addEventListener('keyup', syncContent);

// Initialize
syncContent();

function insertTable() {
    const html = `<table>
<thead><tr><th>Kolom 1</th><th>Kolom 2</th><th>Kolom 3</th></tr></thead>
<tbody>
<tr><td>Data 1</td><td>Data 2</td><td>Data 3</td></tr>
<tr><td>Data 4</td><td>Data 5</td><td>Data 6</td></tr>
</tbody>
</table><p><br></p>`;
    editorContent.focus();
    document.execCommand('insertHTML', false, html);
    syncContent();
}

function insertLink() {
    const url = prompt('Masukkan URL:', 'https://');
    if (url) {
        document.execCommand('createLink', false, url);
        syncContent();
    }
}

function insertMath() {
    const formula = prompt('Masukkan formula LaTeX:', '\\frac{a}{b}');
    if (formula) {
        const html = `<span class="math-block">\\(${formula}\\)</span>&nbsp;`;
        editorContent.focus();
        document.execCommand('insertHTML', false, html);
        syncContent();

        // Load MathJax jika belum
        if (typeof MathJax === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js';
            script.async = true;
            document.head.appendChild(script);
        } else {
            MathJax.typesetPromise && MathJax.typesetPromise();
        }
    }
}

let lastEditorRange = null;
editorContent.addEventListener('mouseup', saveEditorSelection);
editorContent.addEventListener('keyup', saveEditorSelection);
function saveEditorSelection() {
    const sel = window.getSelection();
    if (sel.rangeCount > 0 && editorContent.contains(sel.anchorNode)) {
        lastEditorRange = sel.getRangeAt(0);
    }
}

function triggerImageUpload() {
    document.getElementById('contentImageInput').click();
}

function handleContentImageUpload(input) {
    const file = input.files && input.files[0];
    if (!file) return;
    uploadAndInsertImage(file);
    input.value = '';
}

// ── Upload a File object and insert it at the last known cursor position ────
function uploadAndInsertImage(file) {
    const btn = document.getElementById('imageUploadBtn');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const formData = new FormData();
    formData.append('image', file);

    if (btn) btn.classList.add('uploading');

    return fetch('{{ route("admin.lessons.upload-image") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData,
    })
        .then(res => {
            if (!res.ok) throw new Error('Upload gagal');
            return res.json();
        })
        .then(data => {
            editorContent.focus();

            const sel = window.getSelection();
            sel.removeAllRanges();
            if (lastEditorRange) {
                sel.addRange(lastEditorRange);
            } else {
                const range = document.createRange();
                range.selectNodeContents(editorContent);
                range.collapse(false);
                sel.addRange(range);
            }

            const html = `<img src="${data.url}" alt="Gambar pelajaran"><p><br></p>`;
            document.execCommand('insertHTML', false, html);
            syncContent();
            saveEditorSelection();
        })
        .catch(() => {
            alert('Gagal mengunggah gambar. Coba lagi.');
        })
        .finally(() => {
            if (btn) btn.classList.remove('uploading');
        });
}

// ── Paste images directly into the editor (Ctrl+V), like pasting into Word ──
// Lets an admin copy an image (from a file, a screenshot, or another page)
// and paste it straight into the content area; it uploads automatically and
// drops the image right where the cursor was, so placement stays flexible.
editorContent.addEventListener('paste', function (e) {
    const items = e.clipboardData && e.clipboardData.items;
    if (!items) return;

    let imageFile = null;
    for (let i = 0; i < items.length; i++) {
        if (items[i].type && items[i].type.indexOf('image') === 0) {
            imageFile = items[i].getAsFile();
            break;
        }
    }

    if (imageFile) {
        // It's a pasted image: block the default paste and upload+insert instead.
        e.preventDefault();
        saveEditorSelection();
        uploadAndInsertImage(imageFile);
    }
    // Otherwise let normal text/HTML paste behavior proceed untouched.
});

// Sync on form submit
document.getElementById('lessonForm').addEventListener('submit', function () {
    contentHidden.value = editorContent.innerHTML;
});
</script>
@endpush

</x-admin-layout>