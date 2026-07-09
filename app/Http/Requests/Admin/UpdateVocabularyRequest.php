<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVocabularyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lesson_id'             => ['required', 'integer', 'exists:lessons,id'],
            'term'                  => ['required', 'string', 'max:255'],
            'image'                 => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image'          => ['nullable', 'boolean'],
            'mathematical_meaning'  => ['nullable', 'string'],
            'pronunciation'         => ['nullable', 'string', 'max:255'],
            'audio_path'            => ['nullable', 'string', 'max:255'],
            'example'               => ['nullable', 'string'],
            'example_sentence'      => ['nullable', 'string'],
            'translation'           => ['nullable', 'string', 'max:255'],
            'formula'               => ['nullable', 'string', 'max:255'],
            'difficulty'            => ['required', Rule::in(['beginner', 'intermediate', 'advanced'])],
            'sort_order'            => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'lesson_id.required' => 'Pelajaran wajib dipilih.',
            'lesson_id.exists'   => 'Pelajaran tidak ditemukan.',
            'term.required'      => 'Istilah (term) wajib diisi.',
            'image.image'        => 'File yang diunggah harus berupa gambar.',
            'image.mimes'        => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'image.max'          => 'Ukuran gambar maksimal 2MB.',
            'difficulty.required'=> 'Tingkat kesulitan wajib dipilih.',
            'sort_order.required'=> 'Sort order wajib diisi.',
        ];
    }
}
