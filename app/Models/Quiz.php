<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    // =========================================================
    // KOLOM DATABASE (sesuai migration create_quizzes_table)
    // id, lesson_id, question, question_type
    // (enum: multiple_choice|essay|word_arrange),
    // options (json), correct_answer, explanation,
    // xp_reward, time_limit_seconds, sort_order, is_active,
    // created_at, updated_at
    //
    // Untuk question_type = 'word_arrange':
    // - options       : json array kata/frasa yang ditampilkan sebagai
    //                   "word bank" ke siswa (boleh berisi kata pengecoh
    //                   yang tidak dipakai di jawaban benar).
    // - correct_answer: JSON-encoded array berisi urutan kata yang benar,
    //                   contoh string tersimpan: ["I","eat","rice"]
    // =========================================================

    protected $fillable = [
        'lesson_id',
        'question',
        'question_type',
        'options',
        'image',
        'correct_answer',
        'explanation',
        'xp_reward',
        'time_limit_seconds',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'options'            => 'array',
        'xp_reward'          => 'integer',
        'time_limit_seconds' => 'integer',
        'sort_order'         => 'integer',
        'is_active'          => 'boolean',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function attempts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getQuestionTypeLabelAttribute(): string
    {
        return match ($this->question_type) {
            'multiple_choice' => 'Multiple Choice',
            'word_arrange'    => 'Essay (Susun Kata)',
            // 'essay' adalah tipe lama (essay bebas, tanpa word bank).
            // Tetap dikenali untuk data lama, meski tidak lagi bisa dibuat dari form admin.
            'essay'           => 'Essay (Susun Kata)',
            default           => 'Quiz',
        };
    }

    /**
     * URL publik gambar soal (khusus tipe Multiple Choice, opsional).
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * True jika soal ini seharusnya dirender sebagai "Susun Kata" (klik word bank),
     * baik untuk tipe word_arrange maupun tipe lama "essay" yang kebetulan sudah
     * punya data word bank di kolom options.
     */
    public function getIsWordArrangeAttribute(): bool
    {
        return $this->question_type === 'word_arrange'
            || ($this->question_type === 'essay' && ! empty($this->options));
    }

    public function getQuestionTypeColorAttribute(): string
    {
        return match ($this->question_type) {
            'multiple_choice' => '#2563EB',
            'essay'           => '#EF4444',
            'word_arrange'    => '#8B5CF6',
            default           => '#6B7280',
        };
    }

    public function getQuestionTypeBgAttribute(): string
    {
        return match ($this->question_type) {
            'multiple_choice' => '#DBEAFE',
            'essay'           => '#FEF2F2',
            'word_arrange'    => '#EDE9FE',
            default           => '#F3F4F6',
        };
    }

    /**
     * Ambil urutan kata jawaban benar sebagai array (khusus word_arrange).
     */
    public function getCorrectWordOrderAttribute(): array
    {
        if (! $this->is_word_arrange) {
            return [];
        }

        $decoded = json_decode((string) $this->correct_answer, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Cek jawaban siswa untuk tipe word_arrange.
     * All-or-nothing: urutan harus persis sama, termasuk jumlah kata.
     *
     * @param  array<int, string>  $submittedWords  Urutan kata yang disusun siswa
     */
    public function isCorrectWordArrangeAnswer(array $submittedWords): bool
    {
        $correct = $this->correct_word_order;

        // Normalisasi whitespace supaya perbandingan tidak gagal
        // hanya karena spasi berlebih.
        $normalize = fn ($word) => trim((string) $word);

        return array_map($normalize, $submittedWords) === array_map($normalize, $correct);
    }

    /**
     * Helper generik untuk mengecek jawaban sesuai tipe soal.
     * Mengembalikan null untuk tipe yang butuh koreksi manual (mis. essay bebas).
     *
     * @param  array<int, string>|string  $submitted
     */
    public function checkAnswer(array|string $submitted): ?bool
    {
        if ($this->is_word_arrange) {
            return $this->isCorrectWordArrangeAnswer(
                is_array($submitted) ? $submitted : (json_decode($submitted, true) ?? [])
            );
        }

        return match ($this->question_type) {
            'multiple_choice' => trim((string) $submitted) === trim((string) $this->correct_answer),
            'essay'           => null, // essay bebas tanpa word bank, butuh koreksi manual
            default           => trim((string) $submitted) === trim((string) $this->correct_answer),
        };
    }
}
