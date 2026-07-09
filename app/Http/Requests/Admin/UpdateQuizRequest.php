<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lesson_id'           => ['required', 'integer', 'exists:lessons,id'],
            'question'            => ['required', 'string'],
            'question_type'       => ['required', Rule::in([
                'multiple_choice', 'word_arrange',
            ])],
            'image'               => ['nullable', 'image', 'max:2048'],
            'remove_image'        => ['nullable', 'boolean'],
            'options'             => [
                Rule::requiredIf(fn () => $this->input('question_type') === 'word_arrange'),
                'nullable', 'array',
            ],
            'options.*'           => ['nullable', 'string'],
            'correct_answer'      => ['required', 'string'],
            'explanation'         => ['nullable', 'string'],
            'xp_reward'           => ['required', 'integer', 'min:0'],
            'time_limit_seconds'  => ['required', 'integer', 'min:5'],
            'sort_order'          => ['required', 'integer', 'min:0'],
            'is_active'           => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);

        // Opsi dikirim sebagai baris teks terpisah dari textarea, buang baris kosong
        if ($this->filled('options_raw')) {
            $options = collect(explode("\n", $this->input('options_raw')))
                ->map(fn ($line) => trim($line))
                ->filter()
                ->values()
                ->all();

            $this->merge(['options' => $options]);
        }

        // Untuk tipe word_arrange, correct_answer dibangun dari urutan kata
        // yang disusun admin di UI (correct_answer_order[]), lalu disimpan
        // sebagai JSON string di kolom correct_answer.
        if ($this->input('question_type') === 'word_arrange' && $this->filled('correct_answer_order')) {
            $order = collect($this->input('correct_answer_order'))
                ->map(fn ($word) => trim((string) $word))
                ->filter()
                ->values()
                ->all();

            $this->merge(['correct_answer' => json_encode($order, JSON_UNESCAPED_UNICODE)]);
        }
    }

    /**
     * Validasi tambahan: pastikan setiap kata di correct_answer_order
     * benar-benar berasal dari daftar options (word bank).
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('question_type') !== 'word_arrange') {
                return;
            }

            $options = collect($this->input('options', []))->map(fn ($o) => trim((string) $o))->filter()->values();

            if ($options->count() < 2) {
                $validator->errors()->add('options', 'Minimal isi 2 kata untuk word bank.');
                return;
            }

            $order = collect(json_decode($this->input('correct_answer', '[]'), true) ?? []);

            if ($order->isEmpty()) {
                $validator->errors()->add('correct_answer', 'Susun urutan jawaban benar dari kata yang tersedia.');
                return;
            }

            foreach ($order as $word) {
                if (! $options->contains(trim((string) $word))) {
                    $validator->errors()->add('correct_answer', "Kata \"{$word}\" pada jawaban benar tidak ada di daftar pilihan kata.");
                    break;
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'lesson_id.required'      => 'Pelajaran wajib dipilih.',
            'lesson_id.exists'        => 'Pelajaran tidak ditemukan.',
            'question.required'       => 'Pertanyaan wajib diisi.',
            'question_type.required'  => 'Tipe soal wajib dipilih.',
            'question_type.in'        => 'Tipe soal tidak valid.',
            'image.image'              => 'File harus berupa gambar (jpg, png, dsb).',
            'image.max'                => 'Ukuran gambar maksimal 2MB.',
            'options.required'        => 'Kata untuk word bank wajib diisi.',
            'options.min'             => 'Minimal isi 2 kata untuk word bank.',
            'correct_answer.required' => 'Jawaban benar wajib diisi.',
            'xp_reward.required'      => 'XP Reward wajib diisi.',
            'time_limit_seconds.required' => 'Batas waktu wajib diisi.',
            'time_limit_seconds.min'  => 'Batas waktu minimal 5 detik.',
            'sort_order.required'     => 'Sort order wajib diisi.',
        ];
    }
}
