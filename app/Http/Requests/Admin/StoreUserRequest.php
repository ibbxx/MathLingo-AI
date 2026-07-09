<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'username'          => ['nullable', 'string', 'max:50', 'alpha_dash', Rule::unique('users', 'username')],
            'email'             => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
            'role'              => ['required', Rule::in(['admin', 'student'])],
            'status'            => ['nullable', Rule::in(['active', 'inactive', 'suspended'])],
            'phone'             => ['nullable', 'string', 'max:20'],
            'bio'               => ['nullable', 'string', 'max:500'],
            'educational_level' => ['nullable', Rule::in(['junior_high', 'senior_high', 'undergraduate', 'teacher'])],
            'learning_goal'     => ['nullable', Rule::in(['vocabulary', 'problem_solving', 'olympiad', 'international_exams'])],
            'country'           => ['nullable', 'string', 'max:100'],
            'avatar'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'username.unique'    => 'Username sudah digunakan.',
            'username.alpha_dash'=> 'Username hanya boleh huruf, angka, strip, underscore.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
            'role.required'      => 'Role wajib dipilih.',
            'avatar.image'       => 'File harus berupa gambar.',
            'avatar.mimes'       => 'Format gambar: jpg, jpeg, png, webp.',
            'avatar.max'         => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}