@push('styles')
<style>
.admin-page { padding: 28px 28px 40px; max-width: 800px; }
.admin-page-header { margin-bottom: 24px; }
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub   { font-size: 13.5px; color: var(--color-muted); margin: 0; }

.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: var(--color-muted); margin-bottom: 16px; }
.breadcrumb a { color: var(--color-muted); text-decoration: none; }
.breadcrumb a:hover { color: var(--color-primary); }

.panel { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--radius-card); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 16px; }
.panel-header { padding: 18px 24px 16px; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; gap: 10px; }
.panel-header-icon { width: 32px; height: 32px; border-radius: 8px; background: var(--color-primary-10); color: var(--color-primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.panel-title { font-size: 14px; font-weight: 700; color: var(--color-text); }
.panel-body  { padding: 20px 24px; }

.form-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group.full { grid-column: 1 / -1; }
.form-label { font-size: 13px; font-weight: 600; color: var(--color-text); }
.form-label span { color: var(--color-danger); margin-left: 2px; }
.form-input, .form-select, .form-textarea {
    padding: 9px 12px; border: 1.5px solid var(--color-border); border-radius: 9px;
    font-size: 13.5px; font-family: inherit; color: var(--color-text);
    background: #FAFBFC; outline: none; transition: border-color 0.15s, box-shadow 0.15s;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--color-primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.08); background: #fff;
}
.form-textarea { resize: vertical; min-height: 70px; }
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

.form-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 18px 24px; border-top: 1px solid var(--color-border); background: #FAFBFC; }
.btn-cancel {
    padding: 10px 20px; border: 1.5px solid var(--color-border); border-radius: 10px;
    background: transparent; color: var(--color-muted); font-size: 13.5px; font-weight: 600;
    font-family: inherit; cursor: pointer; text-decoration: none; transition: border-color 0.12s, color 0.12s;
}
.btn-cancel:hover { border-color: var(--color-primary); color: var(--color-primary); }
.btn-submit {
    padding: 10px 22px; border: none; border-radius: 10px; background: var(--color-primary); color: #fff;
    font-size: 13.5px; font-weight: 700; font-family: inherit; cursor: pointer;
    display: inline-flex; align-items: center; gap: 7px; transition: opacity 0.15s;
}
.btn-submit:hover { opacity: 0.88; }

@media (max-width: 767px) { .admin-page { padding: 16px 16px 32px; } .form-grid { grid-template-columns: 1fr; } .form-group.full { grid-column: 1; } }
</style>
@endpush

<div class="admin-page">

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('admin.vocabulary.index') }}">Manajemen Kosakata</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--color-text);font-weight:600;">{{ $isEdit ? 'Edit Kosakata' : 'Tambah Kosakata' }}</span>
    </div>

    <div class="admin-page-header">
        <h1 class="admin-page-title">{{ $isEdit ? 'Edit Kosakata' : 'Tambah Kosakata Baru' }}</h1>
        <p class="admin-page-sub">Kosakata terhubung ke sebuah pelajaran (Lesson) dan akan tampil di kartu Vocabulary pada Dashboard Student.</p>
    </div>

    <form method="POST" action="{{ $isEdit ? route('admin.vocabulary.update', $vocabulary) : route('admin.vocabulary.store') }}" enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="panel">
            <div class="panel-header">
                <div class="panel-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <span class="panel-title">Informasi Kosakata</span>
            </div>
            <div class="panel-body">
                <div class="form-grid">

                    <div class="form-group full">
                        <label class="form-label" for="lesson_id">Pelajaran <span>*</span></label>
                        <select id="lesson_id" name="lesson_id" class="form-select" required>
                            <option value="">Pilih Pelajaran...</option>
                            @foreach($lessons as $lesson)
                                <option value="{{ $lesson->id }}"
                                    {{ old('lesson_id', $isEdit ? $vocabulary->lesson_id : $selectedLessonId) == $lesson->id ? 'selected' : '' }}>
                                    {{ $lesson->title }} — {{ optional($courses->firstWhere('id', $lesson->course_id))->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('lesson_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="term">Istilah (Term) <span>*</span></label>
                        <input type="text" id="term" name="term" class="form-input"
                               placeholder="Contoh: Derivative" value="{{ old('term', $isEdit ? $vocabulary->term : '') }}" required>
                        @error('term')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" style="margin-bottom:8px;">Gambar Kosakata (opsional)</label>
                        <div class="image-upload">
                            <div class="image-upload-preview" id="imagePreviewBox">
                                @if($isEdit && $vocabulary->image_url)
                                    <img src="{{ $vocabulary->image_url }}" alt="{{ $vocabulary->term }}" id="imagePreviewImg">
                                @else
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" id="imagePreviewIcon"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                    <img src="" alt="" id="imagePreviewImg" style="display:none;">
                                @endif
                            </div>
                            <div class="image-upload-body">
                                <div class="image-upload-actions">
                                    <label class="btn-file">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Pilih Gambar
                                        <input type="file" id="imageInput" name="image" accept="image/png,image/jpeg,image/webp" onchange="handleImagePreview(this)">
                                    </label>
                                    @if($isEdit && $vocabulary->image_url)
                                        <button type="button" class="btn-remove-image" onclick="markRemoveImage()">Hapus gambar</button>
                                    @endif
                                </div>
                                <div class="image-upload-hint">Format JPG, PNG, atau WEBP, maksimal 2MB.</div>
                                @if($isEdit)
                                <label class="remove-image-flag" id="removeImageFlagWrap" style="display:none;">
                                    <input type="checkbox" name="remove_image" id="removeImageCheckbox" value="1"> Gambar akan dihapus saat disimpan
                                </label>
                                @endif
                            </div>
                        </div>
                        @error('image')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="mathematical_meaning">Arti Matematis</label>
                        <textarea id="mathematical_meaning" name="mathematical_meaning" class="form-textarea"
                                  placeholder="Penjelasan makna istilah ini secara matematis...">{{ old('mathematical_meaning', $isEdit ? $vocabulary->mathematical_meaning : '') }}</textarea>
                        @error('mathematical_meaning')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="translation">Terjemahan (Bahasa Indonesia)</label>
                        <input type="text" id="translation" name="translation" class="form-input"
                               placeholder="Contoh: Turunan" value="{{ old('translation', $isEdit ? $vocabulary->translation : '') }}">
                        @error('translation')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="pronunciation">Pengucapan</label>
                        <input type="text" id="pronunciation" name="pronunciation" class="form-input"
                               placeholder="Contoh: /dɪˈrɪvətɪv/" value="{{ old('pronunciation', $isEdit ? $vocabulary->pronunciation : '') }}">
                        @error('pronunciation')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="formula">Formula (opsional)</label>
                        <input type="text" id="formula" name="formula" class="form-input" style="font-family:monospace;"
                               placeholder="Contoh: f'(x) = lim(h→0) [f(x+h)-f(x)]/h" value="{{ old('formula', $isEdit ? $vocabulary->formula : '') }}">
                        <div class="form-hint">Boleh diisi notasi LaTeX sederhana, ditampilkan apa adanya.</div>
                        @error('formula')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="example">Contoh Penggunaan</label>
                        <textarea id="example" name="example" class="form-textarea"
                                  placeholder="Contoh soal atau penerapan istilah ini...">{{ old('example', $isEdit ? $vocabulary->example : '') }}</textarea>
                        @error('example')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="example_sentence">Contoh Kalimat</label>
                        <textarea id="example_sentence" name="example_sentence" class="form-textarea"
                                  placeholder="Contoh kalimat berbahasa Inggris yang memakai istilah ini...">{{ old('example_sentence', $isEdit ? $vocabulary->example_sentence : '') }}</textarea>
                        @error('example_sentence')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="difficulty">Tingkat Kesulitan <span>*</span></label>
                        <select id="difficulty" name="difficulty" class="form-select" required>
                            @foreach(['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'] as $value => $label)
                                <option value="{{ $value }}" {{ old('difficulty', $isEdit ? $vocabulary->difficulty : 'beginner') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('difficulty')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sort_order">Sort Order <span>*</span></label>
                        <input type="number" id="sort_order" name="sort_order" class="form-input" min="0"
                               value="{{ old('sort_order', $isEdit ? $vocabulary->sort_order : ($maxSortOrder + 1)) }}" required>
                        <div class="form-hint">Urutan tampil dalam daftar kosakata pelajaran (kecil = lebih atas).</div>
                        @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        <div class="panel">
            <div class="form-footer">
                <a href="{{ route('admin.vocabulary.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Kosakata' }}
                </button>
            </div>
        </div>

    </form>
</div>

<script>
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
        const flagWrap = document.getElementById('removeImageFlagWrap');
        const flagBox  = document.getElementById('removeImageCheckbox');
        if (flagWrap) { flagWrap.style.display = 'none'; }
        if (flagBox)  { flagBox.checked = false; }
    }
}

function markRemoveImage() {
    const img  = document.getElementById('imagePreviewImg');
    const icon = document.getElementById('imagePreviewIcon');
    const flagWrap = document.getElementById('removeImageFlagWrap');
    const flagBox  = document.getElementById('removeImageCheckbox');
    img.style.display = 'none';
    if (icon) icon.style.display = 'block';
    if (flagWrap) flagWrap.style.display = 'flex';
    if (flagBox) flagBox.checked = true;
    document.getElementById('imageInput').value = '';
}
</script>
