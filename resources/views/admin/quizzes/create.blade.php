<x-admin-layout title="Tambah Banyak Soal">

@section('page-title', 'Tambah Banyak Soal')

<style>
.admin-page { padding: 28px 28px 60px; max-width: 900px; }
.admin-page-header { margin-bottom: 24px; }
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub   { font-size: 13.5px; color: var(--color-muted); margin: 0; }

.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: var(--color-muted); margin-bottom: 16px; }
.breadcrumb a { color: var(--color-muted); text-decoration: none; }
.breadcrumb a:hover { color: var(--color-primary); }

.top-panel {
    background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--radius-card);
    box-shadow: var(--shadow-card); padding: 20px 24px; margin-bottom: 20px;
}
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-label { font-size: 13px; font-weight: 600; color: var(--color-text); }
.form-label span { color: var(--color-danger); margin-left: 2px; }
.form-input, .form-select, .form-textarea {
    padding: 9px 12px; border: 1.5px solid var(--color-border); border-radius: 9px;
    font-size: 13.5px; font-family: inherit; color: var(--color-text);
    background: #FAFBFC; outline: none; width: 100%; box-sizing: border-box;
}
.form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--color-primary); background: #fff; }
.form-textarea { resize: vertical; min-height: 60px; }
.form-select { appearance: none; cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 30px; }
.form-hint  { font-size: 12px; color: var(--color-muted); }
.form-error { font-size: 12px; color: var(--color-danger); font-weight: 600; margin-top: 4px; }

.soal-list-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.soal-list-title { font-size: 16px; font-weight: 800; color: var(--color-text); }
.btn-tambah-soal {
    display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 10px;
    border: none; background: var(--color-primary-10); color: var(--color-primary); font-size: 13px; font-weight: 700;
    cursor: pointer; font-family: inherit;
}
.btn-tambah-soal:hover { opacity: 0.85; }

.soal-card {
    background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--radius-card);
    box-shadow: var(--shadow-card); margin-bottom: 16px; overflow: hidden;
}
.soal-card-header { display:flex; align-items:center; justify-content:space-between; padding: 16px 22px; border-bottom: 1px solid var(--color-border); background:#FAFBFC; }
.soal-card-title { font-size: 14.5px; font-weight: 800; color: var(--color-text); }
.btn-hapus-soal {
    display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:9px; border:none;
    background:#FEF2F2; color:#EF4444; font-size:12.5px; font-weight:700; cursor:pointer; font-family:inherit;
}
.btn-hapus-soal:hover { background:#FEE2E2; }
.soal-card-body { padding: 20px 22px; display:flex; flex-direction:column; gap:16px; }

.form-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.form-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; }

.type-section { display:none; }
.type-section.active { display:block; }

.image-upload { border: 1.5px dashed var(--color-border); border-radius: 12px; padding: 14px; display: flex; align-items: center; gap: 14px; background: #FAFBFC; }
.image-upload-preview { width: 60px; height: 60px; border-radius: 10px; overflow: hidden; flex-shrink: 0; background: #F1F5F9; display: flex; align-items: center; justify-content: center; color: var(--color-muted); border: 1px solid var(--color-border); }
.image-upload-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
.btn-file { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; border: 1.5px solid var(--color-border); background: #fff; font-size: 12.5px; font-weight: 600; color: var(--color-text); cursor: pointer; }
.btn-file input[type=file] { display: none; }
.image-upload-hint { font-size: 11.5px; color: var(--color-muted); margin-top: 4px; }

.mc-option-list { display: flex; flex-direction: column; gap: 8px; }
.mc-option-row { display: flex; align-items: center; gap: 10px; padding: 8px 10px; border: 1.5px solid var(--color-border); border-radius: 10px; background: #FAFBFC; }
.mc-option-row.correct { border-color: #22C55E; background: #F0FDF4; }
.mc-radio { width: 20px; height: 20px; border-radius: 50%; border: 2px solid var(--color-border); flex-shrink: 0; cursor: pointer; position: relative; background: #fff; }
.mc-radio.checked { border-color: #22C55E; }
.mc-radio.checked::after { content: ''; position: absolute; inset: 3px; border-radius: 50%; background: #22C55E; }
.mc-option-input { flex: 1; border: none; background: transparent; font-size: 13.5px; font-family: inherit; color: var(--color-text); outline: none; padding: 4px 0; }
.mc-option-letter { width: 22px; height: 22px; border-radius: 6px; background: var(--color-primary-10); color: var(--color-primary); font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.mc-option-remove { width: 26px; height: 26px; border-radius: 7px; border: none; background: transparent; color: var(--color-muted); cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.mc-option-remove:hover { background: #FEF2F2; color: #EF4444; }
.btn-add-option { display: inline-flex; align-items: center; gap: 6px; margin-top: 10px; padding: 8px 14px; border-radius: 9px; border: 1.5px dashed var(--color-border); background: transparent; color: var(--color-primary); font-size: 12.5px; font-weight: 700; cursor: pointer; }

.wa-bank-add { display: flex; gap: 8px; margin-bottom: 10px; }
.wa-bank-add input { flex: 1; }
.btn-wa-add { padding: 9px 16px; border-radius: 9px; border: none; background: var(--color-primary); color: #fff; font-size: 12.5px; font-weight: 700; cursor: pointer; flex-shrink: 0; }
.wa-bank-chips, .wa-order-chips { display: flex; flex-wrap: wrap; gap: 8px; min-height: 40px; padding: 12px; border-radius: 10px; background: #FAFBFC; border: 1.5px solid var(--color-border); }
.wa-order-chips { background: #EFF6FF; border-color: #BFDBFE; }
.wa-empty-hint { font-size: 12px; color: var(--color-muted); padding: 4px; }
.wa-chip { display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; border-radius: 9px; background: #fff; border: 1.5px solid var(--color-border); font-size: 13px; font-weight: 600; color: var(--color-text); cursor: pointer; user-select: none; }
.wa-chip.in-bank.used { opacity: 0.35; cursor: default; }
.wa-chip-order { background: #DBEAFE; border-color: #93C5FD; color: #1D4ED8; }
.wa-chip-remove { color: var(--color-muted); font-weight: 800; }
.wa-section-label { font-size: 12.5px; font-weight: 700; color: var(--color-text); margin-bottom: 8px; display: block; }
.wa-block { margin-bottom: 14px; }
.wa-block:last-child { margin-bottom: 0; }

.toggle-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.toggle-info .toggle-label { font-size: 13px; font-weight: 600; color: var(--color-text); }
.toggle-switch { width: 40px; height: 22px; border-radius: 99px; background: #CBD5E1; position: relative; cursor: pointer; flex-shrink: 0; }
.toggle-switch input { display: none; }
.toggle-switch .toggle-knob { position: absolute; width: 16px; height: 16px; border-radius: 50%; background: #fff; top: 3px; left: 3px; transition: transform 0.15s; }
.toggle-switch.on { background: var(--color-primary); }
.toggle-switch.on .toggle-knob { transform: translateX(18px); }

.sticky-footer {
    position: sticky; bottom: 0; background: var(--color-surface); border: 1px solid var(--color-border);
    border-radius: var(--radius-card); box-shadow: var(--shadow-card); padding: 16px 22px;
    display: flex; align-items: center; justify-content: space-between; margin-top: 4px;
}
.sticky-footer-count { font-size: 13px; font-weight: 600; color: var(--color-muted); }
.btn-cancel { padding: 10px 20px; border: 1.5px solid var(--color-border); border-radius: 10px; background: transparent; color: var(--color-muted); font-size: 13.5px; font-weight: 600; text-decoration: none; }
.btn-submit { padding: 10px 24px; border: none; border-radius: 10px; background: var(--color-primary); color: #fff; font-size: 13.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; }

@media (max-width: 767px) { .admin-page { padding: 16px 16px 40px; } .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; } }
</style>

<div class="admin-page">

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('admin.quizzes.index') }}">Manajemen Quiz</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--color-text);font-weight:600;">Tambah Quiz</span>
    </div>

    <div class="admin-page-header">
        <h1 class="admin-page-title">Tambah Quiz</h1>
    </div>

    @if ($errors->any())
        <div style="background:#FEF2F2;border:1.5px solid #FCA5A5;color:#B91C1C;border-radius:12px;padding:14px 18px;margin-bottom:18px;font-size:13px;">
            <div style="font-weight:700;margin-bottom:6px;">Periksa kembali isian soal:</div>
            <ul style="margin:0;padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.quizzes.store') }}" enctype="multipart/form-data" id="bulkForm">
        @csrf

        <div class="top-panel">
            <div class="form-group">
                <label class="form-label" for="lesson_id">Pelajaran (berlaku untuk semua soal di bawah) <span>*</span></label>
                <select id="lesson_id" name="lesson_id" class="form-select" required>
                    <option value="">Pilih Pelajaran...</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ old('lesson_id', $selectedLessonId) == $lesson->id ? 'selected' : '' }}>
                            {{ $lesson->title }} — {{ optional($courses->firstWhere('id', $lesson->course_id))->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="soal-list-header">
            <div class="soal-list-title">Daftar Quiz</div>
            <button type="button" class="btn-tambah-soal" onclick="addSoalCard()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Quiz
            </button>
        </div>

        <div id="soalList"></div>

        <div class="sticky-footer">
            <span class="sticky-footer-count" id="soalCountLabel">0 soal ditambahkan</span>
            <div style="display:flex; gap:10px;">
                <a href="{{ route('admin.quizzes.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Semua Soal
                </button>
            </div>
        </div>
    </form>
</div>

<script>
const QUESTION_TYPES = @json($questionTypes);
let cardCounter = 0;
const cards = {}; // cardId -> { type, mcOptions:[{id,text,correct}], mcIdCounter, waBank:[{id,word}], waOrder:[], waIdCounter }

function updateSoalCount() {
    const n = document.querySelectorAll('.soal-card').length;
    document.getElementById('soalCountLabel').textContent = n + ' soal ditambahkan';
}

function cardTypeChanged(cardId) {
    const wrap = document.getElementById('card-' + cardId);
    const type = wrap.querySelector('.f-question-type').value;
    cards[cardId].type = type;
    wrap.querySelectorAll('.type-section').forEach(el => el.classList.remove('active'));
    const section = wrap.querySelector('.section-' + type);
    if (section) section.classList.add('active');
}

function removeSoalCard(cardId) {
    const el = document.getElementById('card-' + cardId);
    if (el) el.remove();
    delete cards[cardId];
    updateSoalCount();
    renumberCardTitles();
}

function renumberCardTitles() {
    document.querySelectorAll('.soal-card').forEach((card, idx) => {
        card.querySelector('.soal-card-title').textContent = 'Soal ' + (idx + 1);
    });
}

function handleImagePreview(input, cardId) {
    const img = document.getElementById('imgPreview-' + cardId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; img.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

function toggleActive(cardId) {
    const toggle = document.getElementById('activeToggle-' + cardId);
    const check = document.getElementById('activeCheck-' + cardId);
    toggle.classList.toggle('on');
    check.checked = toggle.classList.contains('on');
}

/* ══════════ MC BUILDER ══════════ */
function mcRender(cardId) {
    const state = cards[cardId];
    const list = document.getElementById('mcList-' + cardId);
    list.innerHTML = '';
    state.mcOptions.forEach((opt, idx) => {
        const row = document.createElement('div');
        row.className = 'mc-option-row' + (opt.correct ? ' correct' : '');

        const letter = document.createElement('div');
        letter.className = 'mc-option-letter';
        letter.textContent = String.fromCharCode(65 + idx);

        const radio = document.createElement('div');
        radio.className = 'mc-radio' + (opt.correct ? ' checked' : '');
        radio.onclick = () => { state.mcOptions.forEach(o => o.correct = false); opt.correct = true; mcRender(cardId); };

        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'mc-option-input';
        input.placeholder = 'Tulis opsi jawaban...';
        input.value = opt.text;
        input.oninput = () => { opt.text = input.value; };

        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'mc-option-remove';
        remove.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
        remove.onclick = () => { state.mcOptions = state.mcOptions.filter(o => o.id !== opt.id); mcRender(cardId); };

        row.append(letter, radio, input, remove);
        list.appendChild(row);
    });
}

function mcAddOption(cardId, text) {
    const state = cards[cardId];
    state.mcOptions.push({ id: ++state.mcIdCounter, text: text || '', correct: state.mcOptions.length === 0 });
    mcRender(cardId);
}

/* ══════════ WORD ARRANGE BUILDER ══════════ */
function waRenderAll(cardId) {
    const state = cards[cardId];
    const bankBox = document.getElementById('waBank-' + cardId);
    const orderBox = document.getElementById('waOrder-' + cardId);

    bankBox.innerHTML = '';
    if (state.waBank.length === 0) {
        bankBox.innerHTML = '<span class="wa-empty-hint">Belum ada kata. Tambahkan di atas.</span>';
    } else {
        state.waBank.forEach(item => {
            const used = state.waOrder.some(o => o.id === item.id);
            const chip = document.createElement('span');
            chip.className = 'wa-chip in-bank' + (used ? ' used' : '');
            chip.textContent = item.word;
            if (!used) chip.onclick = () => { state.waOrder.push(item); waRenderAll(cardId); };
            const remove = document.createElement('span');
            remove.className = 'wa-chip-remove';
            remove.textContent = ' ×';
            remove.onclick = (e) => { e.stopPropagation(); state.waBank = state.waBank.filter(b => b.id !== item.id); state.waOrder = state.waOrder.filter(o => o.id !== item.id); waRenderAll(cardId); };
            chip.appendChild(remove);
            bankBox.appendChild(chip);
        });
    }

    orderBox.innerHTML = '';
    if (state.waOrder.length === 0) {
        orderBox.innerHTML = '<span class="wa-empty-hint">Klik kata di Word Bank untuk menyusun jawaban.</span>';
    } else {
        state.waOrder.forEach((item, idx) => {
            const chip = document.createElement('span');
            chip.className = 'wa-chip wa-chip-order';
            chip.textContent = item.word;
            chip.onclick = () => { state.waOrder.splice(idx, 1); waRenderAll(cardId); };
            orderBox.appendChild(chip);
        });
    }
}

function waAddWord(cardId) {
    const state = cards[cardId];
    const input = document.getElementById('waWordInput-' + cardId);
    const word = input.value.trim();
    if (!word) return;
    state.waBank.push({ id: ++state.waIdCounter, word });
    input.value = '';
    input.focus();
    waRenderAll(cardId);
}

/* ══════════ CREATE CARD ══════════ */
function addSoalCard() {
    const cardId = ++cardCounter;
    cards[cardId] = { type: 'multiple_choice', mcOptions: [], mcIdCounter: 0, waBank: [], waOrder: [], waIdCounter: 0 };

    const typeOptions = Object.entries(QUESTION_TYPES).map(([val, label]) => `<option value="${val}">${label}</option>`).join('');

    const wrap = document.createElement('div');
    wrap.className = 'soal-card';
    wrap.id = 'card-' + cardId;
    wrap.innerHTML = `
    
        <div class="soal-card-header">
            <div class="soal-card-title">Soal</div>
            <button type="button" class="btn-hapus-soal" onclick="removeSoalCard(${cardId})">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Hapus
            </button>
        </div>
        <div class="soal-card-body">

            <div class="form-group">
                <label class="form-label">Tipe Soal <span>*</span></label>
                <select class="form-select f-question-type" onchange="cardTypeChanged(${cardId})">${typeOptions}</select>
            </div>

            <div class="form-group">
                <label class="form-label">Pertanyaan <span>*</span></label>
                <textarea class="form-textarea f-question" placeholder="Tulis pertanyaan..." required></textarea>
            </div>

            <div class="type-section section-multiple_choice active">
                <label class="form-label" style="margin-bottom:8px;display:block;">Gambar Soal (opsional)</label>
                <div class="image-upload" style="margin-bottom:14px;">
                    <div class="image-upload-preview">
                        <img id="imgPreview-${cardId}" src="" style="display:none;">
                    </div>
                    <div>
                        <label class="btn-file">
                            Pilih Gambar
                            <input type="file" class="f-image" accept="image/*" onchange="handleImagePreview(this, ${cardId})">
                        </label>
                        <div class="image-upload-hint">JPG/PNG, maks 2MB.</div>
                    </div>
                </div>

                <label class="form-label" style="margin-bottom:8px;display:block;">Pilihan Jawaban <span>*</span></label>
                <div class="mc-option-list" id="mcList-${cardId}"></div>
                <button type="button" class="btn-add-option" onclick="mcAddOption(${cardId})">+ Tambah Opsi</button>
                <div class="form-hint" style="margin-top:8px;">Klik lingkaran untuk menandai jawaban benar.</div>
            </div>

            <div class="type-section section-word_arrange">
                <div class="wa-block">
                    <span class="wa-section-label">1. Daftar Kata (Word Bank) <span style="color:#EF4444">*</span></span>
                    <div class="wa-bank-add">
                        <input type="text" class="form-input" id="waWordInput-${cardId}" placeholder="Ketik kata, lalu Tambah" onkeydown="if(event.key==='Enter'){event.preventDefault();waAddWord(${cardId});}">
                        <button type="button" class="btn-wa-add" onclick="waAddWord(${cardId})">+ Tambah</button>
                    </div>
                    <div class="wa-bank-chips" id="waBank-${cardId}"></div>
                </div>
                <div class="wa-block">
                    <span class="wa-section-label">2. Susun Jawaban Benar <span style="color:#EF4444">*</span></span>
                    <div class="wa-order-chips" id="waOrder-${cardId}"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Penjelasan (opsional)</label>
                <textarea class="form-textarea f-explanation" placeholder="Penjelasan setelah siswa menjawab..."></textarea>
            </div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">XP Reward <span>*</span></label>
                    <input type="number" class="form-input f-xp" min="0" value="10" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Batas Waktu (detik) <span>*</span></label>
                    <input type="number" class="form-input f-time" min="5" value="30" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" class="form-input f-sort" min="0" placeholder="Otomatis">
                </div>
            </div>

            <div class="toggle-row">
                <div class="toggle-info"><div class="toggle-label">Aktifkan Soal</div></div>
                <label class="toggle-switch on" id="activeToggle-${cardId}" onclick="toggleActive(${cardId})">
                    <input type="checkbox" class="f-active" id="activeCheck-${cardId}" checked>
                    <div class="toggle-knob"></div>
                </label>
            </div>
        </div>
    `;

    document.getElementById('soalList').appendChild(wrap);
    mcAddOption(cardId, '');
    mcAddOption(cardId, '');
    waRenderAll(cardId);
    updateSoalCount();
    renumberCardTitles();
}

//* ══════════ SUBMIT: build soal[i][...] hidden inputs from state ══════════ *//
document.getElementById('bulkForm').addEventListener('submit', function (e) {
    const soalCards = document.querySelectorAll('.soal-card');

    if (soalCards.length === 0) {
        e.preventDefault();
        alert('Tambahkan minimal 1 soal terlebih dahulu.');
        return;
    }

    soalCards.forEach((card, idx) => {
        const cardId = parseInt(card.id.replace('card-', ''));
        const state = cards[cardId];
        const prefix = 'soal[' + idx + ']';

        const setField = (name, value) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = prefix + '[' + name + ']';
            input.value = value;
            card.appendChild(input);
        };

        // Basic fields — rename real inputs' name attributes directly.
        card.querySelector('.f-question-type').name = prefix + '[question_type]';
        card.querySelector('.f-question').name = prefix + '[question]';
        card.querySelector('.f-explanation').name = prefix + '[explanation]';
        card.querySelector('.f-xp').name = prefix + '[xp_reward]';
        card.querySelector('.f-time').name = prefix + '[time_limit_seconds]';
        card.querySelector('.f-sort').name = prefix + '[sort_order]';
        card.querySelector('.f-image').name = prefix + '[image]';
        card.querySelector('.f-active').name = prefix + '[is_active]';
        card.querySelector('.f-active').value = '1';

        if (state.type === 'multiple_choice') {
            const texts = state.mcOptions.map(o => o.text.trim()).filter(Boolean);
            setField('options_raw', texts.join('\n'));
            const correctOpt = state.mcOptions.find(o => o.correct);
            setField('correct_answer', correctOpt ? correctOpt.text.trim() : '');
        } else if (state.type === 'word_arrange') {
            const bankWords = state.waBank.map(b => b.word.trim()).filter(Boolean);
            setField('options_raw', bankWords.join('\n'));
            state.waOrder.forEach(item => {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = prefix + '[correct_answer_order][]';
                hidden.value = item.word;
                card.appendChild(hidden);
            });
        }
    });
});

/* Mulai dengan 1 soal kosong */
addSoalCard();
</script>

</x-admin-layout>
