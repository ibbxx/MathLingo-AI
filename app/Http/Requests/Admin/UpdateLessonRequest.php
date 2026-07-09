<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $lesson   = $this->route('lesson');
        $courseId = $this->input('course_id', $lesson->course_id);

        return [
            'course_id'        => ['required', 'integer', 'exists:courses,id'],
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('lessons')
                    ->where('course_id', $courseId)
                    ->ignore($lesson->id),
            ],
            'description'      => ['nullable', 'string'],
            'image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image'     => ['nullable', 'boolean'],
            'content'          => ['nullable', 'string'],
            'lesson_type'      => ['required', Rule::in(['vocabulary', 'reading', 'grammar', 'practice', 'quiz'])],
            'xp_reward'        => ['required', 'integer', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:0'],
            'sort_order'       => ['required', 'integer', 'min:0'],
            'is_active'        => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function messages(): array
    {
        return [
            'course_id.required'   => 'Kursus wajib dipilih.',
            'course_id.exists'     => 'Kursus tidak ditemukan.',
            'title.required'       => 'Judul pelajaran wajib diisi.',
            'image.image'          => 'File yang diunggah harus berupa gambar.',
            'image.mimes'          => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'image.max'            => 'Ukuran gambar maksimal 2MB.',
            'slug.unique'          => 'Slug sudah digunakan pada kursus ini.',
            'slug.regex'           => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'lesson_type.required' => 'Tipe pelajaran wajib dipilih.',
            'lesson_type.in'       => 'Tipe pelajaran tidak valid.',
            'xp_reward.required'   => 'XP Reward wajib diisi.',
            'xp_reward.integer'    => 'XP Reward harus berupa angka.',
            'duration_minutes.required' => 'Durasi wajib diisi.',
            'duration_minutes.integer'  => 'Durasi harus berupa angka.',
            'sort_order.required'  => 'Sort order wajib diisi.',
            'sort_order.integer'   => 'Sort order harus berupa angka.',
        ];
    }
}