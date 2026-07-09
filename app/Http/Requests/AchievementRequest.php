<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AchievementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Tambah gate/policy jika ada role admin
    }

    public function rules(): array
    {
        $achievementId = $this->route('achievement')?->id;

        return [
            'title'             => ['required', 'string', 'max:255'],
            'slug'              => [
                'nullable', 'string', 'max:255',
                Rule::unique('achievements', 'slug')->ignore($achievementId),
            ],
            'description'       => ['nullable', 'string', 'max:2000'],
            'category'          => ['required', 'string', 'max:100'],
            'badge_icon'        => ['nullable', 'string', 'max:255'],
            'icon'              => ['nullable', 'string', 'max:100'],
            'color'             => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'rarity'            => ['required', Rule::in(['common', 'rare', 'epic', 'legendary'])],
            'requirement_type'  => ['nullable', 'string', 'max:100'],
            'requirement_value' => ['required', 'integer', 'min:1'],
            'xp_reward'         => ['required', 'integer', 'min:0'],
            'is_hidden'         => ['boolean'],
            'is_active'         => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'             => 'Judul achievement wajib diisi.',
            'title.max'                  => 'Judul maksimal 255 karakter.',
            'slug.unique'                => 'Slug sudah digunakan, gunakan yang lain.',
            'category.required'          => 'Kategori wajib dipilih.',
            'rarity.required'            => 'Rarity wajib dipilih.',
            'rarity.in'                  => 'Rarity tidak valid.',
            'requirement_value.required' => 'Nilai persyaratan wajib diisi.',
            'requirement_value.integer'  => 'Nilai persyaratan harus berupa angka.',
            'requirement_value.min'      => 'Nilai persyaratan minimal 1.',
            'xp_reward.required'         => 'XP reward wajib diisi.',
            'xp_reward.integer'          => 'XP reward harus berupa angka.',
            'xp_reward.min'              => 'XP reward tidak boleh negatif.',
            'color.regex'                => 'Warna harus format hex, contoh: #2563EB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_hidden' => $this->boolean('is_hidden'),
            'is_active' => $this->has('is_active') ? $this->boolean('is_active') : true,
        ]);
    }
}