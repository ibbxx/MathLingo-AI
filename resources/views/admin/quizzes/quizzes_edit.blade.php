<x-app-layout>

@section('page-title', 'Edit Soal Kuis')

<style>
    :root { --primary:#2563EB; --border:#E5E7EB; --text:#1E293B; --muted:#64748B; --surface:#FFFFFF; --r-card:16px; --shadow:0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05); --danger:#EF4444; --s10:#F0FDF4; }
    .form-card { background:var(--surface); border-radius:var(--r-card); box-shadow:var(--shadow); padding:24px; max-width:720px; }
    .form-title { font-size:18px; font-weight:800; color:var(--text); margin-bottom:20px; }
    .form-group { margin-bottom:16px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-row-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; }
    label { display:block; font-size:13px; font-weight:700; color:var(--text); margin-bottom:6px; }
    input[type=text], input[type=number], textarea, select {
        width:100%; padding:10px 12px; border:1.5px solid var(--border); border-radius:9px;
        font-size:14px; font-family:inherit; color:var(--text); background:#fff;
    }
    textarea { resize:vertical; min-height:70px; }
    .error-msg { color:var(--danger); font-size:12px; margin-top:4px; }
    .btn-primary { padding:11px 22px; background:var(--primary); color:#fff; font-size:14px; font-weight:700; border-radius:10px; border:none; cursor:pointer; }
    .btn-outline { padding:11px 18px; background:#F8FAFC; color:var(--muted); font-size:14px; font-weight:600; border-radius:10px; border:1.5px solid var(--border); text-decoration:none; }
    .btn-small { padding:7px 12px; font-size:12px; font-weight:700; border-radius:8px; border:1.5px solid var(--border); background:#fff; color:var(--text); cursor:pointer; }
    .option-row { display:flex; gap:8px; margin-bottom:8px; align-items:center; }
    .option-row input { flex:1; }
    .option-remove { color:var(--danger); background:none; border:none; cursor:pointer; font-size:16px; padding:0 4px; }
    .toggle-row { display:flex; align-items:center; gap:8px; }
    .toggle-row label { margin:0; font-weight:600; }
    #options-wrap { display:none; }
    #word-arrange-wrap { display:none; }
    .help-text { font-size:12px; color:var(--muted); margin-top:4px; }
    .word-bank { display:flex; flex-wrap:wrap; gap:8px; padding:12px; border:1.5px dashed var(--border); border-radius:9px; min-height:44px; margin-bottom:10px; }
    .word-chip { padding:7px 14px; background:#EDE9FE; color:#6D28D9; border:1.5px solid #DDD6FE; border-radius:20px; font-size:13px; font-weight:600; cursor:pointer; user-select:none; }
    .word-chip:hover { background:#DDD6FE; }
    .word-chip.used { opacity:0.35; cursor:not-allowed; }
    .sequence-box { display:flex; flex-wrap:wrap; gap:8px; padding:12px; background:#F8FAFC; border:1.5px solid var(--border); border-radius:9px; min-height:44px; }
    .sequence-chip { padding:7px 14px; background:#2563EB; color:#fff; border-radius:20px; font-size:13px; font-weight:600; cursor:pointer; user-select:none; display:flex; align-items:center; gap:6px; }
    .sequence-chip .x { opacity:0.7; }
    .sequence-empty { font-size:12px; color:var(--muted); padding:8px 4px; }
</style>

@if(session('success'))
<div style="background:var(--s10);color:#15803D;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px;max-width:720px;">
    {{ session('success') }}
</div>
@endif

<div class="form-card">
    <div class="form-title">Edit Soal Kuis</div>

    <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST" id="quiz-form">
        @csrf @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Kursus</label>
                <select id="course_id" onchange="filterLessons()">
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" @selected(old('course_id', $quiz->lesson->course_id) == $c->id)>{{ $c->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Lesson <span style="color:var(--danger);">*</span></label>
                <select name="lesson_id" id="lesson_id" required>
                    @foreach($lessons as $l)
                        <option value="{{ $l->id }}" data-course="{{ $l->course_id }}" @selected(old('lesson_id', $quiz->lesson_id) == $l->id)>{{ $l->title }}</option>
                    @endforeach
                </select>
                @error('lesson_id')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label>Pertanyaan <span style="color:var(--danger);">*</span></label>
            <textarea name="question">{{ old('question', $quiz->question) }}</textarea>
            @error('question')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Tipe Soal <span style="color:var(--danger);">*</span></label>
            <select name="question_type" id="question_type" onchange="toggleOptions(true)">
                @foreach($questionTypes as $val => $label)
                    <option value="{{ $val }}" @selected(old('question_type', $quiz->question_type) === $val)>{{ $label }}</option>
                @endforeach
            </select>
            @error('question_type')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-group" id="options-wrap">
            <label id="options-label">Pilihan Jawaban</label>
            <div id="options-list"></div>
            <button type="button" class="btn-small" onclick="addOption()">+ Tambah Pilihan</button>
            <div class="help-text" id="options-help"></div>
            @error('options')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-group" id="word-arrange-wrap">
            <label>Susun Urutan Jawaban Benar <span style="color:var(--danger);">*</span></label>
            <div class="help-text" style="margin-bottom:8px;">Klik kata di bawah sesuai urutan yang benar. Kata yang tidak diklik akan jadi pengecoh.</div>
            <div class="word-bank" id="word-bank"></div>
            <div class="sequence-box" id="sequence-box">
                <span class="sequence-empty">Belum ada kata dipilih</span>
            </div>
            <div id="correct-answer-order-inputs"></div>
            @error('correct_answer')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-group" id="correct-answer-wrap">
            <label>Jawaban Benar <span style="color:var(--danger);">*</span></label>
            <input type="text" name="correct_answer" id="correct_answer_input" value="{{ old('correct_answer', $quiz->correct_answer) }}">
            @error('correct_answer')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Penjelasan (opsional)</label>
            <textarea name="explanation">{{ old('explanation', $quiz->explanation) }}</textarea>
        </div>

        <div class="form-row-3">
            <div class="form-group">
                <label>XP Reward</label>
                <input type="number" name="xp_reward" value="{{ old('xp_reward', $quiz->xp_reward) }}" min="0">
                @error('xp_reward')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Batas Waktu (detik)</label>
                <input type="number" name="time_limit_seconds" value="{{ old('time_limit_seconds', $quiz->time_limit_seconds) }}" min="5">
                @error('time_limit_seconds')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $quiz->sort_order) }}" min="0">
                @error('sort_order')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group toggle-row">
            <input type="checkbox" name="is_active" value="1" id="is_active" style="width:auto;" @checked(old('is_active', $quiz->is_active))>
            <label for="is_active">Aktifkan soal ini</label>
        </div>

        <div style="display:flex;gap:10px;margin-top:20px;">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.quizzes.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>

<script>
    const lessonOptions = Array.from(document.querySelectorAll('#lesson_id option'));
    function filterLessons() {
        const courseId = document.getElementById('course_id').value;
        const lessonSelect = document.getElementById('lesson_id');
        const current = lessonSelect.value;
        lessonSelect.innerHTML = '';
        lessonOptions.forEach(opt => {
            if (!courseId || opt.dataset.course === courseId) {
                const clone = opt.cloneNode(true);
                if (clone.value === current) clone.selected = true;
                lessonSelect.appendChild(clone);
            }
        });
    }

    const typesWithOptions = ['multiple_choice', 'word_arrange'];
    const existingOptions = @json(old('options', $quiz->options ?? []));
    // Urutan jawaban benar tersimpan (khusus word_arrange), correct_answer di DB berupa JSON string
    const existingCorrectOrder = @json(
        old('correct_answer_order', $quiz->question_type === 'word_arrange'
            ? (json_decode($quiz->correct_answer, true) ?? [])
            : [])
    );
    let wordSequence = [];
    let wordArrangeInitialized = false;

    function addOption(value = '') {
        const wrap = document.createElement('div');
        wrap.className = 'option-row';
        wrap.innerHTML = `<input type="text" name="options[]" value="${String(value).replace(/"/g, '&quot;')}" placeholder="Teks pilihan/kata" oninput="syncWordBank()">
                           <button type="button" class="option-remove" onclick="this.parentElement.remove(); syncWordBank();">&times;</button>`;
        document.getElementById('options-list').appendChild(wrap);
    }

    function getOptionValues() {
        return Array.from(document.querySelectorAll('#options-list input'))
            .map(i => i.value.trim())
            .filter(v => v.length > 0);
    }

    function syncWordBank() {
        const words = getOptionValues();
        wordSequence = wordSequence.filter(w => words.includes(w));
        renderWordBank(words);
        renderSequence();
    }

    function renderWordBank(words) {
        const bank = document.getElementById('word-bank');
        if (!bank) return;
        bank.innerHTML = '';
        if (words.length === 0) {
            bank.innerHTML = '<span class="sequence-empty">Isi dulu kata-kata di "Pilihan Jawaban" di atas</span>';
            return;
        }
        words.forEach((word) => {
            const chip = document.createElement('span');
            const usedCount = wordSequence.filter(w => w === word).length;
            const totalCount = words.filter(w => w === word).length;
            const isFullyUsed = usedCount >= totalCount;
            chip.className = 'word-chip' + (isFullyUsed ? ' used' : '');
            chip.textContent = word;
            chip.onclick = () => {
                if (isFullyUsed) return;
                wordSequence.push(word);
                renderWordBank(words);
                renderSequence();
            };
            bank.appendChild(chip);
        });
    }

    function renderSequence() {
        const box = document.getElementById('sequence-box');
        const inputsWrap = document.getElementById('correct-answer-order-inputs');
        if (!box || !inputsWrap) return;
        box.innerHTML = '';
        inputsWrap.innerHTML = '';
        if (wordSequence.length === 0) {
            box.innerHTML = '<span class="sequence-empty">Belum ada kata dipilih</span>';
            return;
        }
        wordSequence.forEach((word, idx) => {
            const chip = document.createElement('span');
            chip.className = 'sequence-chip';
            chip.innerHTML = `${idx + 1}. ${word} <span class="x">&times;</span>`;
            chip.onclick = () => {
                wordSequence.splice(idx, 1);
                renderWordBank(getOptionValues());
                renderSequence();
            };
            box.appendChild(chip);

            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'correct_answer_order[]';
            hidden.value = word;
            inputsWrap.appendChild(hidden);
        });
    }

    function renderWordArrangeBuilder() {
        if (!wordArrangeInitialized && existingCorrectOrder && existingCorrectOrder.length) {
            wordSequence = existingCorrectOrder.slice();
            wordArrangeInitialized = true;
        }
        syncWordBank();
    }

    function toggleOptions(userTriggered = false) {
        const type = document.getElementById('question_type').value;
        const wrap = document.getElementById('options-wrap');
        const wordArrangeWrap = document.getElementById('word-arrange-wrap');
        const correctAnswerWrap = document.getElementById('correct-answer-wrap');
        const correctAnswerInput = document.getElementById('correct_answer_input');
        const optionsLabel = document.getElementById('options-label');
        const optionsHelp = document.getElementById('options-help');

        if (typesWithOptions.includes(type)) {
            wrap.style.display = 'block';
            if (document.getElementById('options-list').children.length === 0) {
                if (existingOptions && existingOptions.length && !userTriggered) {
                    existingOptions.forEach(opt => addOption(opt));
                } else {
                    addOption(); addOption();
                }
            }
        } else {
            wrap.style.display = 'none';
        }

        if (type === 'word_arrange') {
            optionsLabel.textContent = 'Kata untuk Word Bank';
            optionsHelp.textContent = 'Masukkan semua kata/frasa yang akan ditampilkan ke siswa, termasuk kata pengecoh (opsional).';
            wordArrangeWrap.style.display = 'block';
            correctAnswerWrap.style.display = 'none';
            correctAnswerInput.required = false;
            renderWordArrangeBuilder();
        } else {
            optionsLabel.textContent = 'Pilihan Jawaban';
            optionsHelp.textContent = '';
            wordArrangeWrap.style.display = 'none';
            correctAnswerWrap.style.display = 'block';
            correctAnswerInput.required = true;
        }
    }

    document.getElementById('quiz-form').addEventListener('submit', function () {
        if (document.getElementById('question_type').value === 'word_arrange') {
            renderSequence();
        }
    });

    toggleOptions();
</script>

</x-app-layout>
