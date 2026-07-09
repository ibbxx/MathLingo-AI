<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    // ── Index ─────────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $query = User::with('profile')->latest();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter role
        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        // Filter status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter tanggal bergabung
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Sorting
        $sort      = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        $allowedSorts = ['name', 'email', 'role', 'status', 'created_at'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction === 'asc' ? 'asc' : 'desc');
        }

        $users = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total'     => User::count(),
            'active'    => User::where('status', 'active')->count(),
            'suspended' => User::where('status', 'suspended')->count(),
            'students'  => User::where('role', 'student')->count(),
            'admins'    => User::where('role', 'admin')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    // ── Create ────────────────────────────────────────────────────────────

    public function create(): View
    {
        return view('admin.users.create');
    }

    // ── Store ─────────────────────────────────────────────────────────────

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user = User::create([
                'name'     => $validated['name'],
                'username' => $validated['username'] ?: null,
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => $validated['role'],
                'phone'    => $validated['phone'] ?? null,
                'status'   => $validated['status'] ?? 'active',
            ]);

            // Buat StudentProfile jika role = student
            if ($user->role === 'student') {
                $profileData = [
                    'educational_level' => $validated['educational_level'] ?? 'senior_high',
                    'learning_goal'     => $validated['learning_goal'] ?? 'vocabulary',
                    'bio'               => $validated['bio'] ?? null,
                    'country'           => $validated['country'] ?? null,
                    'xp_total'          => 0,
                    'xp_today'          => 0,
                    'streak_days'       => 0,
                    'league'            => 'bronze',
                    'current_level'     => 1,
                    'gems'              => 0,
                    'hearts'            => 5,
                    'hearts_max'        => 5,
                ];

                // Upload avatar jika ada
                if ($request->hasFile('avatar')) {
                    $path = $request->file('avatar')->store('avatars', 'public');
                    $profileData['avatar_url'] = $path;
                }

                $user->profile()->create($profileData);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('admin.users.create')
                ->with('error', 'Gagal membuat user: ' . $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} berhasil ditambahkan.");
    }

    // ── Show ──────────────────────────────────────────────────────────────

    public function show(User $user): View
    {
        $user->load([
            'profile',
            'achievements' => fn ($q) => $q->orderByPivot('earned_at', 'desc'),
            'progress.course',
            'conversations' => fn ($q) => $q->latest()->take(10),
        ]);

        $completedLessons = $user->progress->where('status', 'completed')->count();
        $totalXp          = $user->profile?->xp_total ?? 0;

        return view('admin.users.show', compact('user', 'completedLessons', 'totalXp'));
    }

    // ── Edit ──────────────────────────────────────────────────────────────

    public function edit(User $user): View
    {
        $user->load('profile');
        return view('admin.users.edit', compact('user'));
    }

    // ── Update ────────────────────────────────────────────────────────────

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user->name     = $validated['name'];
            $user->username = $validated['username'] ?: null;
            $user->phone    = $validated['phone'] ?? null;
            $user->role     = $validated['role'];
            $user->status   = $validated['status'];

            if ($user->email !== $validated['email']) {
                $user->email             = $validated['email'];
                $user->email_verified_at = null;
            }

            $user->save();

            // Kelola StudentProfile
            if ($user->role === 'student') {
                $profileData = [
                    'educational_level' => $validated['educational_level'] ?? 'senior_high',
                    'learning_goal'     => $validated['learning_goal'] ?? 'vocabulary',
                    'bio'               => $validated['bio'] ?? null,
                    'country'           => $validated['country'] ?? null,
                ];

                if ($request->hasFile('avatar')) {
                    // Hapus avatar lama
                    if ($user->profile?->avatar_url && Storage::disk('public')->exists($user->profile->avatar_url)) {
                        Storage::disk('public')->delete($user->profile->avatar_url);
                    }
                    $profileData['avatar_url'] = $request->file('avatar')->store('avatars', 'public');
                }

                if ($user->profile) {
                    $user->profile->update($profileData);
                } else {
                    $user->profile()->create(array_merge($profileData, [
                        'xp_total' => 0, 'xp_today' => 0, 'streak_days' => 0,
                        'league' => 'bronze', 'current_level' => 1,
                        'gems' => 0, 'hearts' => 5, 'hearts_max' => 5,
                    ]));
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('admin.users.edit', $user)
                ->with('error', 'Gagal memperbarui user: ' . $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.users.index')
            ->with('success', "Data user {$user->name} berhasil diperbarui.");
    }

    // ── Delete Avatar ─────────────────────────────────────────────────────

    public function deleteAvatar(User $user): RedirectResponse
    {
        $profile = $user->profile;
        if ($profile && $profile->avatar_url) {
            if (Storage::disk('public')->exists($profile->avatar_url)) {
                Storage::disk('public')->delete($profile->avatar_url);
            }
            $profile->avatar_url = null;
            $profile->save();
        }
        return redirect()->route('admin.users.edit', $user)->with('success', 'Avatar berhasil dihapus.');
    }

    // ── Destroy ───────────────────────────────────────────────────────────

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus avatar dari storage
        $profile = $user->profile;
        if ($profile && $profile->avatar_url && Storage::disk('public')->exists($profile->avatar_url)) {
            Storage::disk('public')->delete($profile->avatar_url);
        }

        $name = $user->name;
        $user->delete(); // cascade otomatis hapus profile, progress, achievements, conversations

        return redirect()->route('admin.users.index')
            ->with('success', "User {$name} berhasil dihapus beserta seluruh data terkait.");
    }

    // ── Reset Password ────────────────────────────────────────────────────

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'new_password.required'  => 'Password baru wajib diisi.',
            'new_password.min'       => 'Password minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('admin.users.show', $user)
            ->with('success', "Password {$user->name} berhasil direset.");
    }

    // ── Toggle Status ─────────────────────────────────────────────────────

    public function toggleStatus(Request $request, User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat mengubah status akun Anda sendiri.');
        }

        $request->validate([
            'status' => ['required', 'in:active,inactive,suspended'],
        ]);

        $user->status = $request->input('status');
        $user->save();

        $label = match($user->status) {
            'active'    => 'Aktif',
            'inactive'  => 'Tidak Aktif',
            'suspended' => 'Suspended',
        };

        return redirect()->back()->with('success', "Status {$user->name} diubah menjadi {$label}.");
    }
}