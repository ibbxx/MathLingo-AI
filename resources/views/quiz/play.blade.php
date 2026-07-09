<x-app-layout>

@section('page-title', $lesson->title . ' — Kerjakan Quiz')

<style>
    :root {
        --primary:   #2563EB; --p10: #EFF6FF;
        --secondary: #22C55E; --s10: #F0FDF4;
        --danger:    #EF4444;
        --bg:        #F8FAFC; --surface: #FFFFFF; --border: #E5E7EB;
        --text:      #1E293B; --muted: #64748B;
        --r-card:    20px;
        --shadow:    0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05);
    }

    .page-wrap { padding: 28px; display: flex; flex-direction: column; gap: 16px; max-width: 720px; margin: 0 auto; }

    .breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; font-weight:500; color:var(--muted); }
    .breadcrumb a { color:var(--muted); text-decoration:none; }
    .breadcrumb a:hover { color:var(--primary); }

    .progress-wrap { display:flex; flex-direction:column; gap:8px; }
    .progress-track { width:100%; height:8px; background:var(--border); border-radius:99px; overflow:hidden; }
    .progress-fill { height:100%; width:0%; background:var(--primary); border-radius:99px; transition:width .25s ease; }
    .progress-text { text-align:center; font-size:12.5px; font-weight:700; color:var(--muted); }

    .quiz-badge-row { display:flex; align-items:center; justify-content:space-between; }
    .quiz-badge {
        display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700;
        padding:6px 12px; border-radius:99px; background:var(--p10); color:var(--primary);
    }
    .quiz-meta-pill { font-size:12px; font-weight:700; color:var(--muted); background:var(--surface); border:1px solid var(--border); padding:6px 12px; border-radius:99px; }

    .quiz-card { background: var(--surface); border-radius: var(--r-card); box-shadow: var(--shadow); padding: 28px 26px; }

    .q-question-text { font-size: 17px; font-weight: 800; color: var(--text); line-height: 1.5; margin-bottom: 18px; }

    .q-image-wrap { display:flex; justify-content:center; background:var(--bg); border-radius:14px; margin-bottom:18px; padding:10px; }
    .q-image-wrap img { max-width:100%; max-height:340px; width:auto; height:auto; object-fit:contain; border-radius:8px; display:block; }

    .mc-options { display: flex; flex-direction: column; gap: 10px; }
    .mc-option {
        display: flex; align-items: center; gap: 12px; padding: 13px 16px; border-radius: 12px;
        border: 1.5px solid var(--border); cursor: pointer; transition: border-color 0.12s, background 0.12s; background: #FAFBFC;
    }
    .mc-option:hover { border-color: var(--primary); }
    .mc-option.selected { border-color: var(--primary); background: var(--p10); }
    .mc-option.correct { border-color: var(--secondary); background: var(--s10); }
    .mc-option.wrong { border-color: var(--danger); background: #FEF2F2; }
    .mc-option-key {
        width: 26px; height: 26px; border-radius: 8px; background: #EEF2F7; color: var(--muted);
        font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .mc-option.selected .mc-option-key { background: var(--primary); color: #fff; }
    .mc-option.correct .mc-option-key { background: var(--secondary); color: #fff; }
    .mc-option.wrong .mc-option-key { background: var(--danger); color: #fff; }
    .mc-option-text { font-size: 14px; font-weight: 600; color: var(--text); }

    .arrange-answer {
        display:flex; flex-wrap:wrap; gap:8px; min-height:48px; padding:10px; border:1.5px dashed var(--border);
        border-radius:12px; margin-bottom:14px; background:var(--bg);
    }
    .arrange-answer .placeholder { font-size:13px; color:var(--muted); padding:6px 4px; }
    .arrange-bank { display:flex; flex-wrap:wrap; gap:8px; }
    .word-chip {
        padding:9px 16px; border-radius:10px; background:#fff; border:1.5px solid var(--border);
        font-size:13.5px; font-weight:700; color:var(--text); cursor:pointer; user-select:none;
    }
    .word-chip:hover { border-color: var(--primary); }
    .word-chip.used { opacity:0.35; pointer-events:none; }
    .word-chip.placed { background:var(--p10); border-color:var(--primary); color:var(--primary); }

    .q-actions { display: flex; justify-content: center; gap: 10px; margin-top: 22px; }
    .btn-check {
        padding: 12px 32px; border-radius: 12px; font-size: 14px; font-weight: 700; border: none;
        background: var(--primary); color: #fff; cursor: pointer; font-family: inherit;
    }
    .btn-check:disabled { background: #CBD5E1; cursor: not-allowed; }

    .q-feedback { text-align: center; margin-top: 16px; font-weight: 700; font-size: 14px; }
    .q-feedback.correct { color: #16A34A; }
    .q-feedback.wrong { color: var(--danger); }
    .q-explanation { margin-top: 14px; background: var(--bg); border-radius: 10px; padding: 12px 14px; font-size: 13px; color: var(--muted); line-height: 1.6; }

    .nav-bar { display:flex; justify-content:space-between; align-items:center; gap:10px; }
    .btn-nav {
        padding:13px 26px; border-radius:12px; font-size:14px; font-weight:700; border:none; font-family:inherit; cursor:pointer;
        display:inline-flex; align-items:center; gap:8px;
    }
    .btn-nav.secondary { background:#fff; border:1.5px solid var(--border); color:var(--text); }
    .btn-nav.secondary:disabled { opacity:0.4; cursor:not-allowed; }
    .btn-nav.primary { background:var(--primary); color:#fff; margin-left:auto; }
    .btn-nav.primary:disabled { background:#CBD5E1; cursor:not-allowed; }
    .btn-nav.primary.finish { background:var(--secondary); }
</style>

<div class="page-wrap">

    <div class="breadcrumb">
        <a href="{{ route('quiz.index') }}">Quiz</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="{{ route('quiz.lesson', $lesson->id) }}">{{ $lesson->title }}</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--text);font-weight:600;">{{ $type === 'mc' ? 'Multiple Choice' : 'Essay (Susun Kata)' }}</span>
    </div>

    <div class="progress-wrap">
        <div class="progress-track"><div class="progress-fill" id="progressFill"></div></div>
        <div class="progress-text" id="progressText">1 / {{ $quizzes->count() }}</div>
    </div>

    <div class="quiz-badge-row">
        <span class="quiz-badge" id="progressBadge">SOAL 1 DARI {{ $quizzes->count() }}</span>
    </div>

    @foreach($quizzes as $qi => $quiz)
        <div class="q-slide" id="slide-{{ $qi }}" data-index="{{ $qi }}" data-quiz-id="{{ $quiz->id }}" style="display: {{ $qi === 0 ? 'flex' : 'none' }}; flex-direction:column; gap:16px;">

            <div class="quiz-card">

                <div class="quiz-badge-row" style="margin-bottom:14px;">
                    <span class="quiz-meta-pill">⚡ {{ $quiz->xp_reward }} XP</span>
                    <span class="quiz-meta-pill">⏱ {{ $quiz->time_limit_seconds }} dtk</span>
                </div>

                <div class="q-question-text">{{ $quiz->question }}</div>

                @if($quiz->image_url)
                    <div class="q-image-wrap">
                        <img src="{{ $quiz->image_url }}" alt="Gambar soal">
                    </div>
                @endif

                @if($type === 'mc')
                    {{-- ================= MULTIPLE CHOICE ================= --}}
                    <div class="mc-options" data-answer-type="mc" data-correct-answer="{{ $quiz->correct_answer }}">
                        @foreach(($quiz->options ?? []) as $i => $option)
                            <div class="mc-option" data-answer="{{ $option }}" onclick="mcSelect(this)">
                                <div class="mc-option-key">{{ chr(65 + $i) }}</div>
                                <div class="mc-option-text">{{ $option }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- ================= ESSAY / SUSUN KATA ================= --}}
                    <div class="arrange-answer" data-answer-type="arrange">
                        <span class="placeholder">Klik kata di bawah untuk menyusun jawaban...</span>
                    </div>
                    <div class="arrange-bank">
                        @foreach(($quiz->options ?? []) as $i => $word)
                            <div class="word-chip" data-word="{{ $word }}" data-chip-id="chip-{{ $qi }}-{{ $i }}" onclick="arrangePick(this)">{{ $word }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="q-actions">
                    <button type="button" class="btn-check" disabled onclick="submitAnswer(this)">Periksa Jawaban</button>
                </div>

                <div class="q-feedback-slot"></div>
            </div>

        </div>
    @endforeach

    <div class="nav-bar">
        <button type="button" class="btn-nav secondary" id="prevBtn" onclick="goPrev()" disabled>Sebelumnya</button>
        <button type="button" class="btn-nav primary" id="nextBtn" onclick="goNext()" disabled>Selanjutnya</button>
    </div>

</div>

<script>
(function () {
    const TOTAL = {{ $quizzes->count() }};
    const FINISH_URL = @json(route('quiz.lesson.result', ['lesson' => $lesson->id, 'type' => $type]));
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    let current = 0;
    const answered = new Array(TOTAL).fill(false);

    function updateProgress() {
        document.getElementById('progressFill').style.width = ((current + 1) / TOTAL * 100) + '%';
        document.getElementById('progressText').textContent = (current + 1) + ' / ' + TOTAL;
        document.getElementById('progressBadge').textContent = 'SOAL ' + (current + 1) + ' DARI ' + TOTAL;
    }

    function showSlide(i) {
        document.querySelectorAll('.q-slide').forEach(function (s) { s.style.display = 'none'; });
        document.getElementById('slide-' + i).style.display = 'flex';
        current = i;
        updateProgress();

        document.getElementById('prevBtn').disabled = (current === 0);

        const nextBtn = document.getElementById('nextBtn');
        const isLast = current === TOTAL - 1;
        nextBtn.textContent = isLast ? 'Selesai' : 'Selanjutnya';
        nextBtn.classList.toggle('finish', isLast);
        nextBtn.disabled = !answered[current];
    }

    window.goPrev = function () {
        if (current > 0) showSlide(current - 1);
    };

    window.goNext = function () {
        if (!answered[current]) return;
        if (current < TOTAL - 1) {
            showSlide(current + 1);
        } else {
            window.location.href = FINISH_URL;
        }
    };

    // ---------- Multiple choice selection ----------
    window.mcSelect = function (el) {
        if (el.closest('.q-slide').dataset.locked === '1') return;
        el.parentElement.querySelectorAll('.mc-option').forEach(function (o) { o.classList.remove('selected'); });
        el.classList.add('selected');
        const slide = el.closest('.q-slide');
        slide.querySelector('.btn-check').disabled = false;
    };

    // ---------- Word arrange (essay susun kata) ----------
    // Klik kata di word bank -> pindah ke kotak jawaban secara berurutan.
    window.arrangePick = function (chip) {
        if (chip.classList.contains('used')) return;
        const answerBox = chip.closest('.q-slide').querySelector('.arrange-answer');
        const placeholder = answerBox.querySelector('.placeholder');
        if (placeholder) placeholder.remove();

        const placedChip = document.createElement('span');
        placedChip.className = 'word-chip placed';
        placedChip.textContent = chip.dataset.word;
        placedChip.dataset.sourceId = chip.dataset.chipId;
        placedChip.onclick = function () { arrangeUnpick(placedChip); };
        answerBox.appendChild(placedChip);

        chip.classList.add('used');

        const slide = chip.closest('.q-slide');
        const total = slide.querySelectorAll('.word-chip[data-word]').length;
        const placed = answerBox.querySelectorAll('.word-chip.placed').length;
        slide.querySelector('.btn-check').disabled = placed === 0;
    };

    window.arrangeUnpick = function (placedChip) {
        const slide = placedChip.closest('.q-slide');
        if (slide.dataset.locked === '1') return;
        const sourceChip = slide.querySelector('[data-chip-id="' + placedChip.dataset.sourceId + '"]');
        if (sourceChip) sourceChip.classList.remove('used');
        placedChip.remove();

        const answerBox = slide.querySelector('.arrange-answer');
        if (!answerBox.querySelector('.word-chip')) {
            const ph = document.createElement('span');
            ph.className = 'placeholder';
            ph.textContent = 'Klik kata di bawah untuk menyusun jawaban...';
            answerBox.appendChild(ph);
        }
        slide.querySelector('.btn-check').disabled = !answerBox.querySelector('.word-chip');
    };

    // ---------- Submit / check answer ----------
    window.submitAnswer = function (btn) {
        const slide = btn.closest('.q-slide');
        const quizId = slide.dataset.quizId;
        const idx = parseInt(slide.dataset.index, 10);
        let answer;

        if (slide.querySelector('[data-answer-type="mc"]')) {
            const selected = slide.querySelector('.mc-option.selected');
            if (!selected) return;
            answer = selected.dataset.answer;
        } else {
            const placedChips = slide.querySelectorAll('.arrange-answer .word-chip.placed');
            if (!placedChips.length) return;
            answer = Array.from(placedChips).map(function (c) { return c.textContent; });
        }

        btn.disabled = true;

        fetch(`/quiz/${quizId}/check-answer`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
            },
            body: JSON.stringify({ answer: answer }),
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            slide.dataset.locked = '1';
            slide.querySelectorAll('.mc-option').forEach(function (o) { o.onclick = null; });
            slide.querySelectorAll('.word-chip').forEach(function (c) { c.onclick = null; });

            const feedbackSlot = slide.querySelector('.q-feedback-slot');

            if (data.correct === true) {
                if (slide.querySelector('[data-answer-type="mc"]')) {
                    slide.querySelector('.mc-option.selected').classList.add('correct');
                }
                feedbackSlot.innerHTML = `<div class="q-feedback correct">Benar! +${data.xp_reward ?? 0} XP</div>`;
            } else if (data.correct === false) {
                if (slide.querySelector('[data-answer-type="mc"]')) {
                    slide.querySelector('.mc-option.selected').classList.add('wrong');
                    const correctAnswer = slide.querySelector('.mc-options').dataset.correctAnswer;
                    slide.querySelectorAll('.mc-option').forEach(function (o) {
                        if (o.dataset.answer === correctAnswer) o.classList.add('correct');
                    });
                }
                feedbackSlot.innerHTML = `<div class="q-feedback wrong">Belum tepat, coba lagi nanti.</div>`;
            } else {
                feedbackSlot.innerHTML = `<div class="q-feedback">Jawaban akan diperiksa manual.</div>`;
            }

            if (data.explanation) {
                feedbackSlot.innerHTML += `<div class="q-explanation">${data.explanation}</div>`;
            }

            slide.querySelector('.btn-check').style.display = 'none';

            answered[idx] = true;
            document.getElementById('nextBtn').disabled = false;
        })
        .catch(function () {
            btn.disabled = false;
        });
    };

    showSlide(0);
})();
</script>

</x-app-layout>
