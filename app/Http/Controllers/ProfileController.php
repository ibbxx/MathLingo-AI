<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Models\StudentProfile;
use App\Support\PublicStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private function ensureProfile($user): StudentProfile
    {
        if (! $user->profile) {
            $user->profile()->create([
                'educational_level' => 'senior_high',
                'learning_goal'     => 'vocabulary',
                'xp_total'          => 0,
                'xp_today'          => 0,
                'streak_days'       => 0,
                'league'            => 'bronze',
                'current_level'     => 1,
                'gems'              => 0,
                'hearts'            => 5,
                'hearts_max'        => 5,
            ]);
            $user->refresh();
        }
        return $user->profile;
    }

    public function index(Request $request): View
    {
        $user         = $request->user();
        $profile      = $this->ensureProfile($user);
        $totalLessons = $user->progress()->count();
        $achievements = $user->achievements()->orderByPivot('earned_at', 'desc')->take(5)->get();
        return view('profile.index', compact('user', 'profile', 'totalLessons', 'achievements'));
    }

    public function edit(Request $request): View
    {
        $user         = $request->user();
        $profile      = $this->ensureProfile($user);
        $totalLessons = $user->progress()->count();
        $achievements = $user->achievements()->orderByPivot('earned_at', 'desc')->get();
        return view('profile.edit', compact('user', 'profile', 'totalLessons', 'achievements'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user      = $request->user();
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user->name  = $validated['name'];
            $user->phone = $validated['phone'] ?? null;

            if (array_key_exists('username', $validated)) {
                $user->username = $validated['username'] ?: null;
            }

            if ($user->email !== $validated['email']) {
                $user->email             = $validated['email'];
                $user->email_verified_at = null;
            }

            $user->save();

            $profile      = $this->ensureProfile($user);
            $profile->bio = $validated['bio'] ?? null;
            $profile->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return Redirect::route('profile.edit')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function uploadAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'avatar.required' => 'Pilih foto terlebih dahulu.',
            'avatar.image'    => 'File harus berupa gambar.',
            'avatar.mimes'    => 'Format foto harus jpg, jpeg, png, atau webp.',
            'avatar.max'      => 'Ukuran foto maksimal 2 MB.',
        ]);

        $user    = $request->user();
        $profile = $this->ensureProfile($user);

        try {
            $path = PublicStorage::store($request->file('avatar'), 'avatars');

            // Validasi: pastikan file benar-benar tersimpan
            if (! $path) {
                return Redirect::route('profile.edit')
                    ->with('error', 'Gagal menyimpan file. store() mengembalikan false.');
            }

            if (! PublicStorage::exists($path)) {
                return Redirect::route('profile.edit')
                    ->with('error', 'File tidak ditemukan setelah disimpan. Path: ' . $path);
            }

            // Simpan path ke database
            $profile->avatar_url = $path;
            $saved = $profile->save();

            if (! $saved) {
                return Redirect::route('profile.edit')
                    ->with('error', 'Gagal menyimpan avatar_url ke database.');
            }

        } catch (\Throwable $e) {
            return Redirect::route('profile.edit')
                ->with('error', 'Exception saat upload: ' . $e->getMessage());
        }

        return Redirect::route('profile.edit')->with('status', 'avatar-updated');
    }

    public function deleteAvatar(Request $request): RedirectResponse
    {
        $user    = $request->user();
        $profile = $user->profile;

        if ($profile && $profile->avatar_url) {
            $profile->avatar_url = null;
            $profile->save();
        }

        return Redirect::route('profile.edit')->with('status', 'avatar-deleted');
    }

    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return Redirect::route('profile.edit')
                ->withErrors(['current_password' => 'Password lama tidak sesuai.'], 'updatePassword')
                ->with('open_tab', 'keamanan');
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user    = $request->user();
        $profile = $user->profile;

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
