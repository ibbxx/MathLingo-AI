<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models\Course;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        $courseId = $this->route('course')->id;

        return [
            'title'             => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255', "unique:courses,slug,{$courseId}"],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'category'          => ['required', 'string', 'max:100'],
            'difficulty'        => ['required', 'in:beginner,intermediate,advanced'],
            'status'            => ['required', 'in:draft,published,archived'],
            'icon'              => ['nullable', 'string', 'max:255'],
            'color'             => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'remove_thumbnail'  => ['nullable', 'boolean'],
            'estimated_minutes' => ['nullable', 'integer', 'min:0', 'max:99999'],
            'total_xp'          => ['nullable', 'integer', 'min:0'],
            'is_featured'       => ['nullable', 'boolean'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'Judul kursus wajib diisi.',
            'category.required' => 'Kategori wajib dipilih.',
            'difficulty.required' => 'Tingkat kesulitan wajib dipilih.',
            'status.required'   => 'Status kursus wajib dipilih.',
            'thumbnail.image'   => 'Thumbnail harus berupa file gambar.',
            'thumbnail.max'     => 'Ukuran thumbnail tidak boleh lebih dari 2MB.',
            'color.regex'       => 'Format warna harus hexadecimal (contoh: #2563EB).',
            'slug.unique'       => 'Slug sudah digunakan oleh kursus lain.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (empty($this->slug) && ! empty($this->title)) {
            $course = $this->route('course');
            $this->merge([
                'slug' => Course::generateUniqueSlug($this->title, $course?->id),
            ]);
        } elseif (! empty($this->slug)) {
            $this->merge(['slug' => Str::slug($this->slug)]);
        }

        $this->merge([
            'is_featured'      => $this->boolean('is_featured'),
            'remove_thumbnail' => $this->boolean('remove_thumbnail'),
            'sort_order'       => (int) ($this->sort_order ?? 0),
            'total_xp'         => (int) ($this->total_xp ?? 0),
        ]);
    }
}