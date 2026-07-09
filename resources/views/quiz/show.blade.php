<x-app-layout>

@section('page-title', 'Kerjakan Soal')

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

    .page-wrap { padding: 28px; display: flex; flex-direction: column; gap: 18px; max-width: 720px; margin: 0 auto; }

    .breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; font-weight:500; color:var(--muted); }
    .breadcrumb a { color:var(--muted); text-decoration:none; }
    .breadcrumb a:hover { color:var(--primary); }

    .quiz-topbar { display:flex; align-items:center; justify-content:space-between; }
    .quiz-badge {
        display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700;
        padding:6px 12px; border-radius:99px; background:var(--p10); color:var(--primary);
    }
    .quiz-meta-right { display:flex; align-items:center; gap:10px; }
    .quiz-meta-pill { font-size:12px; font-weight:700; color:var(--muted); background:var(--surface); border:1px solid var(--border); padding:6px 12px; border-radius:99px; }

    .quiz-card { background: var(--surface); border-radius: var(--r-card); box-shadow: var(--shadow); padding: 28px 26px; }

    .mc-question-text { font-size: 17px; font-weight: 800; color: var(--text); line-height: 1.5; margin-bottom: 18px; }
    .mc-question-image { width: 100%; max-height: 260px; object-fit: cover; border-radius: 14px; margin-bottom: 18px; display: block; }

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

    .quiz-actions { display: flex; justify-content: center; gap: 10px; margin-top: 22px; }
    .btn-check {
        padding: 12px 32px; border-radius: 12px; font-size: 14px; font-weight: 700; border: none;
        background: var(--primary); color: #fff; cursor: pointer; font-family: inherit;
    }
    .btn-check:disabled { background: #CBD5E1; cursor: not-allowed; }

    .quiz-feedback { text-align: center; margin-top: 16px; font-weight: 700; font-size: 14px; }
    .quiz-feedback.correct { color: #16A34A; }
    .quiz-feedback.wrong { color: var(--danger); }
    .quiz-explanation { margin-top: 14px; background: var(--bg); border-radius: 10px; padding: 12px 14px; font-size: 13px; color: var(--muted); line-height: 1.6; }

    .essay-fallback { text-align: center; padding: 30px 10px; color: var(--muted); font-size: 13.5px; }

    .lihat-hasil-wrap { display:flex; justify-content:center; }
    .btn-lihat-hasil-page {
        margin-top: 4px; padding:11px 22px; border-radius:12px; background:#fff;
        border:1.5px solid var(--border); color:var(--text); font-size:13.5px; font-weight:700;
        text-decoration:none; display:inline-flex; align-items:center; gap:8px;
    }

    .review-banner {
        display:flex; align-items:center; gap:10px; padding:14px 18px; border-radius:14px;
        font-size:14px; font-weight:700;
    }
    .review-banner.benar { background: var(--s10); color:#16A34A; border:1.5px solid #BBF7D0; }
    .review-banner.salah { background: #FEF2F2; color: var(--danger); border:1.5px solid #FECACA; }
    .review-banner.belum { background: #F1F5F9; color: var(--muted); border:1.5px solid var(--border); }

    .wa-review-answer { display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin-top:6px; }
    .wa-review-chip {
        padding:10px 18px; background: var(--s10); border:2px solid #BBF7D0; border-radius:12px;
        font-size:15px; font-weight:600; color:#16A34A;
    }
</style>

<div class="page-wrap">

    <div class="breadcrumb">
        <a href="{{ route('quiz.index') }}">Quiz</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        @if($quiz->lesson)
            <a href="{{ route('quiz.lesson', $quiz->lesson->id) }}">{{ $quiz->lesson->title }}</a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        @endif
        <span style="color:var(--text);font-weight:600;">{{ $reviewMode ? 'Review Soal' : 'Soal' }}</span>
    </div>

    @if($reviewMode)
        <div class="review-banner {{ $attempt->is_correct === null ? 'belum' : ($attempt->is_correct ? 'benar' : 'salah') }}">
            @if($attempt->is_correct === true)
                ✅ Jawaban kamu benar sebelumnya. +{{ $attempt->xp_earned }} XP
            @elseif($attempt->is_correct === false)
                ❌ Jawaban kamu sebelumnya belum tepat. Ini kunci jawabannya:
            @else
                ⏳ Soal ini masih menunggu koreksi manual.
            @endif
        </div>
    @endif

    <div class="quiz-topbar">
        <span class="quiz-badge">{{ $quiz->question_type_label }}</span>
        <div class="quiz-meta-right">
            <span class="quiz-meta-pill">⚡ {{ $quiz->xp_reward }} XP</span>
            <span class="quiz-meta-pill">⏱ {{ $quiz->time_limit_seconds }} dtk</span>
        </div>
    </div>

    @if($quiz->question_type === 'multiple_choice')
        <div class="quiz-card">
            <div class="mc-question-text">{{ $quiz->question }}</div>

            @if($quiz->image_url)
                <img src="{{ $quiz->image_url }}" alt="Gambar soal" class="mc-question-image">
            @endif

            <div class="mc-options" id="mcOptions" data-quiz-id="{{ $quiz->id }}">
                @foreach(($quiz->options ?? []) as $i => $option)
                    <div class="mc-option {{ $reviewMode && trim($option) === trim((string) $quiz->correct_answer) ? 'correct' : '' }}"
                         data-answer="{{ $option }}"
                         @if(! $reviewMode) onclick="mcSelect(this)" @endif>
                        <div class="mc-option-key">{{ chr(65 + $i) }}</div>
                        <div class="mc-option-text">{{ $option }}</div>
                    </div>
                @endforeach
            </div>

            @unless($reviewMode)
                <div class="quiz-actions">
                    <button type="button" class="btn-check" id="mcCheckBtn" disabled onclick="mcCheckAnswer()">Periksa Jawaban</button>
                </div>
            @endunless

            <div id="mcFeedback">
                @if($reviewMode && $quiz->explanation)
                    <div class="quiz-explanation">{{ $quiz->explanation }}</div>
                @endif
            </div>
        </div>

        @unless($reviewMode)
        <script>
        (function () {
            let mcSelected = null;

            window.mcSelect = function (el) {
                if (el.dataset.locked === '1') return;
                document.querySelectorAll('.mc-option').forEach(function (o) { o.classList.remove('selected'); });
                el.classList.add('selected');
                mcSelected = el;
                document.getElementById('mcCheckBtn').disabled = false;
            };

            window.mcCheckAnswer = function () {
                if (!mcSelected) return;
                const quizId = document.getElementById('mcOptions').dataset.quizId;
                const answer = mcSelected.dataset.answer;

                fetch(`/quiz/${quizId}/check-answer`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ answer: answer }),
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    document.querySelectorAll('.mc-option').forEach(function (o) {
                        o.dataset.locked = '1';
                        o.onclick = null;
                    });

                    const feedback = document.getElementById('mcFeedback');
                    if (data.correct === true) {
                        mcSelected.classList.add('correct');
                        feedback.innerHTML = `<div class="quiz-feedback correct">Benar! +${data.xp_reward ?? 0} XP</div>`;
                    } else if (data.correct === false) {
                        mcSelected.classList.add('wrong');
                        document.querySelectorAll('.mc-option').forEach(function (o) {
                            if (o.dataset.answer === "{{ $quiz->correct_answer }}") o.classList.add('correct');
                        });
                        feedback.innerHTML = `<div class="quiz-feedback wrong">Belum tepat, coba lagi nanti.</div>`;
                    } else {
                        feedback.innerHTML = `<div class="quiz-feedback">Jawaban akan diperiksa manual.</div>`;
                    }

                    if (data.explanation) {
                        feedback.innerHTML += `<div class="quiz-explanation">${data.explanation}</div>`;
                    }

                    document.getElementById('mcCheckBtn').style.display = 'none';
                });
            };
        })();
        </script>
        @endunless

    @elseif($quiz->is_word_arrange)
        <div class="quiz-card">
            @if($reviewMode)
                <div class="mc-question-text" style="text-align:center;">{{ $quiz->question }}</div>
                <div class="wa-review-answer">
                    @foreach($quiz->correct_word_order as $word)
                        <span class="wa-review-chip">{{ $word }}</span>
                    @endforeach
                </div>
                @if($quiz->explanation)
                    <div class="quiz-explanation" style="margin-top:18px;">{{ $quiz->explanation }}</div>
                @endif
            @else
                @include('quiz.partial.word-arrange-question', ['quiz' => $quiz])
            @endif
        </div>

    @else
        <div class="quiz-card">
            <div class="mc-question-text" style="text-align:center;">{{ $quiz->question }}</div>
            <div class="essay-fallback">Tipe soal ini belum didukung tampilan interaktif siswa. Silakan hubungi admin untuk mengubah soal ini menjadi Multiple Choice atau Essay (Susun Kata).</div>
        </div>
    @endif

    <div class="lihat-hasil-wrap">
        <a href="{{ route('quiz.lesson.result', ['lesson' => $quiz->lesson_id, 'type' => $resultType]) }}" class="btn-lihat-hasil-page">
            {{ $reviewMode ? 'Kembali ke Hasil Quiz' : 'Lihat Hasil Sejauh Ini' }}
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
        </a>
    </div>

</div>

</x-app-layout>
