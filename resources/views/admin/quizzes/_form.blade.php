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

.toggle-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.toggle-info .toggle-label { font-size: 13.5px; font-weight: 600; color: var(--color-text); }
.toggle-info .toggle-hint  { font-size: 12px; color: var(--color-muted); margin-top: 2px; }
.toggle-switch { width: 44px; height: 24px; border-radius: 99px; background: #CBD5E1; position: relative; cursor: pointer; flex-shrink: 0; transition: background 0.2s; }
.toggle-switch input { display: none; }
.toggle-switch .toggle-knob { position: absolute; width: 18px; height: 18px; border-radius: 50%; background: #fff; top: 3px; left: 3px; transition: transform 0.2s; box-shadow: 0 1px 4px rgba(0,0,0,0.15); }
.toggle-switch.on { background: var(--color-primary); }
.toggle-switch.on .toggle-knob { transform: translateX(20px); }

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

/* ─── TYPE-SPECIFIC SECTIONS ─────────────────────────────── */
.type-section { display: none; }
.type-section.active { display: block; }

.panel-note {
    display: flex; align-items: flex-start; gap: 8px;
    background: var(--color-primary-10); border-radius: 10px; padding: 10px 12px;
    font-size: 12.5px; color: #1D4ED8; font-weight: 500; line-height: 1.5; margin-bottom: 16px;
}
.panel-note svg { flex-shrink: 0; margin-top: 1px; }

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

/* Multiple choice option builder */
.mc-option-list { display: flex; flex-direction: column; gap: 10px; }
.mc-option-row {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 10px; border: 1.5px solid var(--color-border); border-radius: 10px; background: #FAFBFC;
}
.mc-option-row.correct { border-color: #22C55E; background: #F0FDF4; }
.mc-radio {
    width: 20px; height: 20px; border-radius: 50%; border: 2px solid var(--color-border);
    flex-shrink: 0; cursor: pointer; position: relative; background: #fff;
}
.mc-radio.checked { border-color: #22C55E; }
.mc-radio.checked::after {
    content: ''; position: absolute; inset: 3px; border-radius: 50%; background: #22C55E;
}
.mc-option-input {
    flex: 1; border: none; background: transparent; font-size: 13.5px; font-family: inherit;
    color: var(--color-text); outline: none; padding: 4px 0;
}
.mc-option-letter {
    width: 22px; height: 22px; border-radius: 6px; background: var(--color-primary-10); color: var(--color-primary);
    font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.mc-option-remove {
    width: 26px; height: 26px; border-radius: 7px; border: none; background: transparent;
    color: var(--color-muted); cursor: pointer; display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: background 0.12s, color 0.12s;
}
.mc-option-remove:hover { background: #FEF2F2; color: var(--color-danger); }
.btn-add-option {
    display: inline-flex; align-items: center; gap: 6px; margin-top: 12px;
    padding: 8px 14px; border-radius: 9px; border: 1.5px dashed var(--color-border);
    background: transparent; color: var(--color-primary); font-size: 12.5px; font-weight: 700;
    cursor: pointer; transition: border-color 0.12s, background 0.12s;
}
.btn-add-option:hover { border-color: var(--color-primary); background: var(--color-primary-10); }

/* Word arrange (Essay Susun Kata) builder */
.wa-bank-add { display: flex; gap: 8px; margin-bottom: 12px; }
.wa-bank-add input { flex: 1; }
.btn-wa-add {
    padding: 9px 16px; border-radius: 9px; border: none; background: var(--color-primary);
    color: #fff; font-size: 12.5px; font-weight: 700; cursor: pointer; flex-shrink: 0;
}
.wa-bank-chips, .wa-order-chips {
    display: flex; flex-wrap: wrap; gap: 8px; min-height: 44px;
    padding: 12px; border-radius: 10px; background: #FAFBFC; border: 1.5px solid var(--color-border);
}
.wa-order-chips { background: #EFF6FF; border-color: #BFDBFE; }
.wa-empty-hint { font-size: 12.5px; color: var(--color-muted); padding: 4px; }
.wa-chip {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 12px; border-radius: 9px; background: #fff; border: 1.5px solid var(--color-border);
    font-size: 13px; font-weight: 600; color: var(--color-text); cursor: pointer; user-select: none;
    transition: transform 0.08s;
}
.wa-chip:active { transform: scale(0.96); }
.wa-chip.in-bank.used { opacity: 0.35; cursor: default; }
.wa-chip-order {
    background: #DBEAFE; border-color: #93C5FD; color: #1D4ED8;
}
.wa-chip-remove { color: var(--color-muted); font-weight: 800; line-height: 1; }
.wa-section-label { font-size: 12.5px; font-weight: 700; color: var(--color-text); margin-bottom: 8px; display: block; }
.wa-block { margin-bottom: 18px; }
.wa-block:last-child { margin-bottom: 0; }

@media (max-width: 767px) { .admin-page { padding: 16px 16px 32px; } .form-grid { grid-template-columns: 1fr; } .form-group.full { grid-column: 1; } .image-upload { flex-direction: column; align-items: flex-start; } }
</style>
@endpush

@php
    $optionsArr = $isEdit && $quiz->options ? $quiz->options : [];
    $correctOrderArr = $isEdit ? $quiz->correct_word_order : [];
    $currentType = old('question_type', $isEdit ? ($quiz->question_type === 'essay' ? 'word_arrange' : $quiz->question_type) : 'multiple_choice');
@endphp

<div class="admin-page">

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('admin.quizzes.index') }}">Manajemen Quiz</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--color-text);font-weight:600;">{{ $isEdit ? 'Edit Soal' : 'Tambah Soal' }}</span>
    </div>

    <div class="admin-page-header">
        <h1 class="admin-page-title">{{ $isEdit ? 'Edit Soal Quiz' : 'Tambah Soal Quiz Baru' }}</h1>
        <p class="admin-page-sub">Soal terhubung ke sebuah pelajaran (Lesson) dan akan tampil di kartu Quiz pada Dashboard Student.</p>
    </div>

    <form method="POST" action="{{ $isEdit ? route('admin.quizzes.update', $quiz) : route('admin.quizzes.store') }}" enctype="multipart/form-data" id="quizForm">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="panel">
            <div class="panel-header">
                <div class="panel-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <span class="panel-title">Informasi Soal</span>
            </div>
            <div class="panel-body">
                <div class="form-grid">

                    <div class="form-group full">
                        <label class="form-label" for="lesson_id">Pelajaran <span>*</span></label>
                        <select id="lesson_id" name="lesson_id" class="form-select" required>
                            <option value="">Pilih Pelajaran...</option>
                            @foreach($lessons as $lesson)
                                <option value="{{ $lesson->id }}"
                                    {{ old('lesson_id', $isEdit ? $quiz->lesson_id : $selectedLessonId) == $lesson->id ? 'selected' : '' }}>
                                    {{ $lesson->title }} — {{ optional($courses->firstWhere('id', $lesson->course_id))->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('lesson_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="question_type">Tipe Soal <span>*</span></label>
                        <select id="question_type" name="question_type" class="form-select" onchange="quizTypeChanged()">
                            @foreach($questionTypes as $value => $label)
                                <option value="{{ $value }}" {{ $currentType === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="form-hint">Multiple Choice = pilihan ganda. Essay (Susun Kata) = siswa menyusun kata seperti Duolingo.</div>
                        @error('question_type')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="question">Pertanyaan <span>*</span></label>
                        <textarea id="question" name="question" class="form-textarea" required
                                  placeholder="Tulis pertanyaan soal di sini...">{{ old('question', $isEdit ? $quiz->question : '') }}</textarea>
                        @error('question')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- ══════════ MULTIPLE CHOICE SECTION ══════════ --}}
                    <div class="form-group full type-section" id="section-multiple_choice">

                        <label class="form-label" style="margin-bottom:8px;">Gambar Soal (opsional)</label>
                        <div class="image-upload" style="margin-bottom:18px;">
                            <div class="image-upload-preview" id="imagePreviewBox">
                                @if($isEdit && $quiz->image_url)
                                    <img src="{{ $quiz->image_url }}" alt="Gambar soal" id="imagePreviewImg">
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
                                        <input type="file" name="image" id="imageInput" accept="image/*" onchange="handleImagePreview(this)">
                                    </label>
                                    @if($isEdit && $quiz->image_url)
                                        <button type="button" class="btn-remove-image" onclick="markRemoveImage()">Hapus gambar</button>
                                    @endif
                                </div>
                                <div class="image-upload-hint">JPG/PNG, maks 2MB. Kosongkan jika soal tidak butuh gambar.</div>
                                @if($isEdit)
                                <label class="remove-image-flag" id="removeImageFlagWrap" style="display:none;">
                                    <input type="checkbox" name="remove_image" id="removeImageCheckbox" value="1"> Gambar akan dihapus saat disimpan
                                </label>
                                @endif
                            </div>
                        </div>
                        @error('image')<div class="form-error">{{ $message }}</div>@enderror

                        <label class="form-label" style="margin-bottom:8px;">Pilihan Jawaban <span>*</span></label>
                        <div class="mc-option-list" id="mcOptionList"></div>
                        <button type="button" class="btn-add-option" onclick="mcAddOption()">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Opsi
                        </button>
                        <div class="form-hint" style="margin-top:8px;">Klik lingkaran di sebelah kiri opsi untuk menandai jawaban yang benar.</div>
                        @error('options')<div class="form-error">{{ $message }}</div>@enderror
                        @error('correct_answer')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- ══════════ ESSAY / SUSUN KATA SECTION ══════════ --}}
                    <div class="form-group full type-section" id="section-word_arrange">
                        <div class="panel-note">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            <span>Siswa akan menyusun kata-kata di bawah menjadi jawaban yang benar, mirip fitur susun kata di Duolingo.</span>
                        </div>

                        <div class="wa-block">
                            <span class="wa-section-label">1. Daftar Kata (Word Bank) <span style="color:var(--color-danger)">*</span></span>
                            <div class="wa-bank-add">
                                <input type="text" class="form-input" id="waWordInput" placeholder="Ketik satu kata / frasa, lalu Tambah" onkeydown="if(event.key==='Enter'){event.preventDefault();waAddWord();}">
                                <button type="button" class="btn-wa-add" onclick="waAddWord()">+ Tambah</button>
                            </div>
                            <div class="wa-bank-chips" id="waBankChips">
                                <span class="wa-empty-hint" id="waBankEmpty">Belum ada kata. Tambahkan kata di atas (boleh sisipkan kata pengecoh).</span>
                            </div>
                        </div>

                        <div class="wa-block">
                            <span class="wa-section-label">2. Susun Jawaban Benar (klik kata dari Word Bank di atas, sesuai urutan) <span style="color:var(--color-danger)">*</span></span>
                            <div class="wa-order-chips" id="waOrderChips">
                                <span class="wa-empty-hint" id="waOrderEmpty">Belum ada jawaban tersusun. Klik kata di Word Bank di atas.</span>
                            </div>
                        </div>

                        @error('options')<div class="form-error">{{ $message }}</div>@enderror
                        @error('correct_answer')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Hidden fields synced by JS right before submit --}}
                    <textarea name="options_raw" id="optionsRawField" style="display:none;"></textarea>
                    <input type="hidden" name="correct_answer" id="correctAnswerField">
                    <div id="correctAnswerOrderHiddenWrap"></div>

                    <div class="form-group full">
                        <label class="form-label" for="explanation">Penjelasan (opsional)</label>
                        <textarea id="explanation" name="explanation" class="form-textarea"
                                  placeholder="Penjelasan yang tampil setelah student menjawab...">{{ old('explanation', $isEdit ? $quiz->explanation : '') }}</textarea>
                        @error('explanation')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="xp_reward">XP Reward <span>*</span></label>
                        <input type="number" id="xp_reward" name="xp_reward" class="form-input" min="0" required
                               value="{{ old('xp_reward', $isEdit ? $quiz->xp_reward : 10) }}">
                        @error('xp_reward')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="time_limit_seconds">Batas Waktu (detik) <span>*</span></label>
                        <input type="number" id="time_limit_seconds" name="time_limit_seconds" class="form-input" min="5" required
                               value="{{ old('time_limit_seconds', $isEdit ? $quiz->time_limit_seconds : 30) }}">
                        @error('time_limit_seconds')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sort_order">Sort Order <span>*</span></label>
                        <input type="number" id="sort_order" name="sort_order" class="form-input" min="0" required
                               value="{{ old('sort_order', $isEdit ? $quiz->sort_order : 1) }}">
                        @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Status</label>
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-label">Aktifkan Soal</div>
                                <div class="toggle-hint">Soal aktif akan tampil pada quiz pelajaran di Student Panel.</div>
                            </div>
                            <label class="toggle-switch {{ old('is_active', $isEdit ? $quiz->is_active : true) ? 'on' : '' }}" id="activeToggle" onclick="toggleActive()">
                                <input type="checkbox" name="is_active" id="activeCheck" value="1"
                                       {{ old('is_active', $isEdit ? $quiz->is_active : true) ? 'checked' : '' }}>
                                <div class="toggle-knob"></div>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="panel">
            <div class="form-footer">
                <a href="{{ route('admin.quizzes.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Soal' }}
                </button>
            </div>
        </div>

    </form>
</div>

<script>
function toggleActive() {
    const toggle = document.getElementById('activeToggle');
    const check  = document.getElementById('activeCheck');
    toggle.classList.toggle('on');
    check.checked = toggle.classList.contains('on');
}

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

/* ══════════ TYPE TOGGLE ══════════ */
function quizTypeChanged() {
    const type = document.getElementById('question_type').value;
    document.querySelectorAll('.type-section').forEach(function (el) { el.classList.remove('active'); });
    const section = document.getElementById('section-' + type);
    if (section) section.classList.add('active');
}

/* ══════════ MULTIPLE CHOICE BUILDER ══════════ */
let mcOptions = []; // [{id, text, correct}]
let mcIdCounter = 0;

function mcRender() {
    const list = document.getElementById('mcOptionList');
    list.innerHTML = '';
    mcOptions.forEach(function (opt, idx) {
        const row = document.createElement('div');
        row.className = 'mc-option-row' + (opt.correct ? ' correct' : '');

        const letter = document.createElement('div');
        letter.className = 'mc-option-letter';
        letter.textContent = String.fromCharCode(65 + idx);

        const radio = document.createElement('div');
        radio.className = 'mc-radio' + (opt.correct ? ' checked' : '');
        radio.onclick = function () {
            mcOptions.forEach(function (o) { o.correct = false; });
            opt.correct = true;
            mcRender();
        };

        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'mc-option-input';
        input.placeholder = 'Tulis opsi jawaban...';
        input.value = opt.text;
        input.oninput = function () { opt.text = input.value; };

        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'mc-option-remove';
        remove.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
        remove.onclick = function () {
            mcOptions = mcOptions.filter(function (o) { return o.id !== opt.id; });
            mcRender();
        };

        row.appendChild(letter);
        row.appendChild(radio);
        row.appendChild(input);
        row.appendChild(remove);
        list.appendChild(row);
    });
}

function mcAddOption(text) {
    mcOptions.push({ id: ++mcIdCounter, text: text || '', correct: mcOptions.length === 0 });
    mcRender();
}

/* ══════════ ESSAY / SUSUN KATA BUILDER ══════════ */
let waBank = [];  // [{id, word}]
let waOrder = []; // [{id, word}]
let waIdCounter = 0;

function waRenderBank() {
    const box = document.getElementById('waBankChips');
    const empty = document.getElementById('waBankEmpty');
    box.innerHTML = '';
    if (waBank.length === 0) {
        box.appendChild(empty);
        return;
    }
    waBank.forEach(function (item) {
        const used = waOrder.some(function (o) { return o.id === item.id; });
        const chip = document.createElement('span');
        chip.className = 'wa-chip in-bank' + (used ? ' used' : '');
        chip.textContent = item.word;
        if (!used) {
            chip.onclick = function () {
                waOrder.push(item);
                waRenderAll();
            };
        }
        const remove = document.createElement('span');
        remove.className = 'wa-chip-remove';
        remove.textContent = '×';
        remove.onclick = function (e) {
            e.stopPropagation();
            waBank = waBank.filter(function (b) { return b.id !== item.id; });
            waOrder = waOrder.filter(function (o) { return o.id !== item.id; });
            waRenderAll();
        };
        chip.appendChild(remove);
        box.appendChild(chip);
    });
}

function waRenderOrder() {
    const box = document.getElementById('waOrderChips');
    const empty = document.getElementById('waOrderEmpty');
    box.innerHTML = '';
    if (waOrder.length === 0) {
        box.appendChild(empty);
        return;
    }
    waOrder.forEach(function (item, idx) {
        const chip = document.createElement('span');
        chip.className = 'wa-chip wa-chip-order';
        chip.textContent = item.word;
        chip.onclick = function () {
            waOrder.splice(idx, 1);
            waRenderAll();
        };
        box.appendChild(chip);
    });
}

function waRenderAll() {
    waRenderBank();
    waRenderOrder();
}

function waAddWord() {
    const input = document.getElementById('waWordInput');
    const word = input.value.trim();
    if (!word) return;
    waBank.push({ id: ++waIdCounter, word: word });
    input.value = '';
    input.focus();
    waRenderAll();
}

/* ══════════ SYNC BUILDERS -> HIDDEN FIELDS ON SUBMIT ══════════ */
document.getElementById('quizForm').addEventListener('submit', function () {
    const type = document.getElementById('question_type').value;

    if (type === 'multiple_choice') {
        const texts = mcOptions.map(function (o) { return o.text.trim(); }).filter(Boolean);
        document.getElementById('optionsRawField').value = texts.join('\n');
        const correctOpt = mcOptions.find(function (o) { return o.correct; });
        document.getElementById('correctAnswerField').value = correctOpt ? correctOpt.text.trim() : '';
    } else if (type === 'word_arrange') {
        const bankWords = waBank.map(function (b) { return b.word.trim(); }).filter(Boolean);
        document.getElementById('optionsRawField').value = bankWords.join('\n');
        document.getElementById('correctAnswerField').value = '';

        const wrap = document.getElementById('correctAnswerOrderHiddenWrap');
        wrap.innerHTML = '';
        waOrder.forEach(function (item) {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'correct_answer_order[]';
            hidden.value = item.word;
            wrap.appendChild(hidden);
        });
    }
});

/* ══════════ INITIALIZE ══════════ */
(function init() {
    const isEdit = @json($isEdit);
    const currentType = @json($currentType);
    const existingOptions = @json($optionsArr);
    const existingCorrectAnswer = @json($isEdit ? $quiz->correct_answer : '');
    const existingCorrectOrder = @json($correctOrderArr);

    if (isEdit && currentType === 'multiple_choice' && Array.isArray(existingOptions) && existingOptions.length) {
        existingOptions.forEach(function (text) {
            mcOptions.push({
                id: ++mcIdCounter,
                text: text,
                correct: String(text).trim() === String(existingCorrectAnswer).trim(),
            });
        });
        mcRender();
    } else {
        mcAddOption('');
        mcAddOption('');
    }

    if (isEdit && currentType === 'word_arrange' && Array.isArray(existingOptions) && existingOptions.length) {
        const wordMap = {};
        existingOptions.forEach(function (word) {
            const item = { id: ++waIdCounter, word: word };
            waBank.push(item);
            wordMap[word] = wordMap[word] || [];
            wordMap[word].push(item);
        });
        if (Array.isArray(existingCorrectOrder)) {
            existingCorrectOrder.forEach(function (word) {
                const bucket = wordMap[word];
                if (bucket && bucket.length) {
                    waOrder.push(bucket.shift());
                }
            });
        }
    }
    waRenderAll();

    quizTypeChanged();
})();
</script>
