{{--
    Partial: Soal tipe "Susun Kata" (ala Duolingo) untuk siswa.

    Cara pakai di halaman quiz siswa:
        @include('quiz.partials.word-arrange-question', ['quiz' => $quiz])

    $quiz->options        -> array kata (word bank), termasuk pengecoh
    $quiz->correct_answer -> JSON string urutan benar, contoh: ["I","eat","rice"]

    Saat siswa submit, JS akan mengirim urutan yang disusun ke endpoint
    pengecekan jawaban (lihat contoh controller di StudentQuizController.php).
--}}

<style>
    .wa-container { max-width:600px; margin:0 auto; }
    .wa-question { font-size:16px; font-weight:700; color:#1E293B; margin-bottom:20px; text-align:center; }
    .wa-answer-box {
        display:flex; flex-wrap:wrap; gap:8px; min-height:56px;
        padding:12px; border-bottom:2px solid #E5E7EB; margin-bottom:24px;
        align-items:center;
    }
    .wa-answer-box.empty::after { content:"Susun kata di bawah ini"; color:#94A3B8; font-size:14px; }
    .wa-word-bank { display:flex; flex-wrap:wrap; gap:10px; justify-content:center; }
    .wa-chip {
        padding:10px 18px; background:#fff; border:2px solid #E5E7EB; border-radius:12px;
        font-size:15px; font-weight:600; color:#1E293B; cursor:pointer; user-select:none;
        transition:transform .1s ease;
    }
    .wa-chip:active { transform:scale(0.95); }
    .wa-chip.placed { visibility:hidden; }
    .wa-chip-answer {
        padding:10px 18px; background:#DBEAFE; border:2px solid #93C5FD; border-radius:12px;
        font-size:15px; font-weight:600; color:#1D4ED8; cursor:pointer; user-select:none;
    }
    .wa-actions { display:flex; gap:10px; justify-content:center; margin-top:24px; }
    .wa-btn { padding:12px 28px; border-radius:12px; font-size:14px; font-weight:700; border:none; cursor:pointer; }
    .wa-btn-check { background:#2563EB; color:#fff; }
    .wa-btn-check:disabled { background:#CBD5E1; cursor:not-allowed; }
    .wa-btn-clear { background:#F1F5F9; color:#64748B; }
    .wa-feedback { text-align:center; margin-top:16px; font-weight:700; font-size:14px; }
    .wa-feedback.correct { color:#16A34A; }
    .wa-feedback.wrong { color:#EF4444; }
</style>

<div class="wa-container" id="wa-container" data-quiz-id="{{ $quiz->id }}">
    <div class="wa-question">{{ $quiz->question }}</div>

    <div class="wa-answer-box empty" id="wa-answer-box"></div>

    <div class="wa-word-bank" id="wa-word-bank">
        @foreach($quiz->options as $i => $word)
            <span class="wa-chip" data-word="{{ $word }}" data-idx="{{ $i }}" onclick="waSelectWord(this)">{{ $word }}</span>
        @endforeach
    </div>

    <div class="wa-actions">
        <button type="button" class="wa-btn wa-btn-clear" onclick="waClear()">Hapus Semua</button>
        <button type="button" class="wa-btn wa-btn-check" id="wa-check-btn" disabled onclick="waCheckAnswer()">Periksa Jawaban</button>
    </div>

    <div id="wa-feedback"></div>
</div>

<script>
(function () {
    let waSequence = []; // [{word, idx}]

    window.waSelectWord = function (chip) {
        const word = chip.dataset.word;
        const idx = chip.dataset.idx;
        chip.classList.add('placed');
        waSequence.push({ word, idx });
        renderAnswerBox();
    };

    function renderAnswerBox() {
        const box = document.getElementById('wa-answer-box');
        box.innerHTML = '';
        box.classList.toggle('empty', waSequence.length === 0);

        waSequence.forEach((item, position) => {
            const chip = document.createElement('span');
            chip.className = 'wa-chip-answer';
            chip.textContent = item.word;
            chip.onclick = () => {
                waSequence.splice(position, 1);
                document.querySelector(`.wa-chip[data-idx="${item.idx}"]`).classList.remove('placed');
                renderAnswerBox();
            };
            box.appendChild(chip);
        });

        document.getElementById('wa-check-btn').disabled = waSequence.length === 0;
    }

    window.waClear = function () {
        waSequence.forEach(item => {
            document.querySelector(`.wa-chip[data-idx="${item.idx}"]`).classList.remove('placed');
        });
        waSequence = [];
        renderAnswerBox();
        document.getElementById('wa-feedback').innerHTML = '';
    };

    window.waCheckAnswer = function () {
        const quizId = document.getElementById('wa-container').dataset.quizId;
        const words = waSequence.map(item => item.word);

        // Sesuaikan URL endpoint ini dengan route yang kamu buat,
        // contoh: /quiz/{quiz}/check-answer
        fetch(`/quiz/${quizId}/check-answer`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ answer: words }),
        })
        .then(res => res.json())
        .then(data => {
            const feedback = document.getElementById('wa-feedback');
            if (data.correct) {
                feedback.innerHTML = `<div class="wa-feedback correct">Benar! +${data.xp_reward ?? ''} XP</div>`;
            } else {
                feedback.innerHTML = `<div class="wa-feedback wrong">Belum tepat, coba lagi.</div>`;
            }
        });
    };
})();
</script>
