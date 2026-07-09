<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($this->user()->id),
            ],
            'email'    => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'phone'    => ['nullable', 'string', 'max:20'],
            'bio'      => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan, pilih yang lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan underscore.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah digunakan akun lain.',
            'bio.max'           => 'Bio maksimal 500 karakter.',
        ];
    }
}