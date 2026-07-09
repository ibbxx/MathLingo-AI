<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lesson_id'                       => ['required', 'integer', 'exists:lessons,id'],
            'soal'                             => ['required', 'array', 'min:1'],
            'soal.*.question_type'             => ['required', Rule::in(['multiple_choice', 'word_arrange'])],
            'soal.*.question'                  => ['required', 'string'],
            'soal.*.image'                     => ['nullable', 'image', 'max:2048'],
            'soal.*.options'                   => ['nullable', 'array'],
            'soal.*.options.*'                 => ['nullable', 'string'],
            'soal.*.correct_answer'            => ['required', 'string'],
            'soal.*.explanation'               => ['nullable', 'string'],
            'soal.*.xp_reward'                 => ['required', 'integer', 'min:0'],
            'soal.*.time_limit_seconds'        => ['required', 'integer', 'min:5'],
            'soal.*.sort_order'                => ['nullable', 'integer', 'min:0'],
            'soal.*.is_active'                 => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $soal = $this->input('soal', []);

        foreach ($soal as $i => $item) {
            $soal[$i]['is_active'] = filter_var($item['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN);

            // options_raw (textarea, 1 baris = 1 opsi/kata) -> array options
            if (! empty($item['options_raw'])) {
                $soal[$i]['options'] = collect(explode("\n", $item['options_raw']))
                    ->map(fn ($line) => trim($line))
                    ->filter()
                    ->values()
                    ->all();
            }

            // Untuk word_arrange, correct_answer dibangun dari urutan kata (correct_answer_order[])
            if (($item['question_type'] ?? null) === 'word_arrange' && ! empty($item['correct_answer_order'])) {
                $order = collect($item['correct_answer_order'])
                    ->map(fn ($word) => trim((string) $word))
                    ->filter()
                    ->values()
                    ->all();

                $soal[$i]['correct_answer'] = json_encode($order, JSON_UNESCAPED_UNICODE);
            }
        }

        $this->merge(['soal' => $soal]);
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $soal = $this->input('soal', []);

            foreach ($soal as $i => $item) {
                if (($item['question_type'] ?? null) !== 'word_arrange') {
                    continue;
                }

                $options = collect($item['options'] ?? [])->map(fn ($o) => trim((string) $o))->filter()->values();

                if ($options->count() < 2) {
                    $validator->errors()->add("soal.{$i}.options", 'Minimal isi 2 kata untuk word bank pada Soal ' . ($i + 1) . '.');
                    continue;
                }

                $order = collect(json_decode($item['correct_answer'] ?? '[]', true) ?? []);

                if ($order->isEmpty()) {
                    $validator->errors()->add("soal.{$i}.correct_answer", 'Susun urutan jawaban benar pada Soal ' . ($i + 1) . '.');
                    continue;
                }

                foreach ($order as $word) {
                    if (! $options->contains(trim((string) $word))) {
                        $validator->errors()->add("soal.{$i}.correct_answer", "Kata \"{$word}\" pada Soal " . ($i + 1) . ' tidak ada di daftar pilihan kata.');
                        break;
                    }
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'lesson_id.required'           => 'Pelajaran wajib dipilih.',
            'soal.required'                => 'Tambahkan minimal 1 soal.',
            'soal.min'                     => 'Tambahkan minimal 1 soal.',
            'soal.*.question.required'     => 'Pertanyaan wajib diisi.',
            'soal.*.question_type.required'=> 'Tipe soal wajib dipilih.',
            'soal.*.correct_answer.required' => 'Jawaban benar wajib diisi.',
            'soal.*.xp_reward.required'    => 'XP Reward wajib diisi.',
            'soal.*.time_limit_seconds.required' => 'Batas waktu wajib diisi.',
            'soal.*.time_limit_seconds.min' => 'Batas waktu minimal 5 detik.',
        ];
    }
}
