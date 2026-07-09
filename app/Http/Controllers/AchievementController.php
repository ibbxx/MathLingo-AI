<?php

namespace App\Http\Controllers;

use App\Http\Requests\AchievementRequest;
use App\Models\Achievement;
use App\Models\UserAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AchievementController extends Controller
{
    // ────────────────────────────────────────────────────────────────────────
    //  INDEX
    // ────────────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $user    = Auth::user();
        $profile = $user->profile ?? null;   // student_profiles

        // ── ID achievement yang sudah diraih user ────────────────────────
        $earnedIds = UserAchievement::where('user_id', $user->id)
            ->pluck('earned_at', 'achievement_id');   // [ achievement_id => earned_at ]

        // ── Base query: hanya yang aktif & tidak hidden ──────────────────
        $query = Achievement::where('is_active', true)
            ->where('is_hidden', false);

        // ── Filter: pencarian ────────────────────────────────────────────
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // ── Filter: kategori ────────────────────────────────────────────
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // ── Filter: rarity ───────────────────────────────────────────────
        if ($rarity = $request->input('rarity')) {
            $query->where('rarity', $rarity);
        }

        // ── Filter: status (unlocked / locked) ──────────────────────────
        if ($status = $request->input('status')) {
            if ($status === 'unlocked') {
                $query->whereIn('id', $earnedIds->keys());
            } elseif ($status === 'locked') {
                $query->whereNotIn('id', $earnedIds->keys());
            }
        }

        // ── Sorting ──────────────────────────────────────────────────────
        $sort = $request->input('sort', 'newest');
        match ($sort) {
            'oldest'   => $query->orderBy('created_at'),
            'xp_high'  => $query->orderByDesc('xp_reward'),
            'xp_low'   => $query->orderBy('xp_reward'),
            'az'       => $query->orderBy('title'),
            'za'       => $query->orderByDesc('title'),
            default    => $query->orderByDesc('created_at'),   // newest
        };

        // ── Pagination ───────────────────────────────────────────────────
        $achievements = $query->paginate(12)->withQueryString();

        // ── Statistik header ─────────────────────────────────────────────
        $totalAchievements = Achievement::where('is_active', true)->where('is_hidden', false)->count();
        $unlockedCount     = $earnedIds->count();
        $lockedCount       = max(0, $totalAchievements - $unlockedCount);

        $xpCollected = Achievement::whereIn('id', $earnedIds->keys())->sum('xp_reward');

        $overallPct = $totalAchievements > 0
            ? round(($unlockedCount / $totalAchievements) * 100)
            : 0;

        // Hitung per rarity
        $rarityStats = Achievement::where('is_active', true)->where('is_hidden', false)
            ->selectRaw('rarity, COUNT(*) as total')
            ->groupBy('rarity')
            ->pluck('total', 'rarity');

        $rarityUnlocked = Achievement::whereIn('id', $earnedIds->keys())
            ->selectRaw('rarity, COUNT(*) as total')
            ->groupBy('rarity')
            ->pluck('total', 'rarity');

        // ── Recent achievements (untuk header) ───────────────────────────
        $recentAchievements = UserAchievement::with('achievement')
            ->where('user_id', $user->id)
            ->orderByDesc('earned_at')
            ->limit(3)
            ->get();

        // ── Learning rank berdasarkan XP ─────────────────────────────────
        $learningRank = $this->calculateRank($profile?->xp_total ?? 0);

        return view('achievements.index', compact(
            'user', 'profile', 'achievements', 'earnedIds',
            'totalAchievements', 'unlockedCount', 'lockedCount',
            'xpCollected', 'overallPct', 'rarityStats', 'rarityUnlocked',
            'recentAchievements', 'learningRank',
        ));
    }

    // ────────────────────────────────────────────────────────────────────────
    //  SHOW
    // ────────────────────────────────────────────────────────────────────────
    public function show(Achievement $achievement)
    {
        $user    = Auth::user();
        $profile = $user->profile ?? null;

        // Cek apakah user sudah unlock
        $userAchievement = UserAchievement::where('user_id', $user->id)
            ->where('achievement_id', $achievement->id)
            ->first();

        $isUnlocked = $userAchievement !== null;

        // Progress user terhadap requirement
        $currentProgress = $this->getUserProgress($user, $achievement);
        $progressPct     = $achievement->requirement_value > 0
            ? min(100, round(($currentProgress / $achievement->requirement_value) * 100))
            : ($isUnlocked ? 100 : 0);

        // Achievement terkait (kategori/rarity sama, bukan ini sendiri)
        $related = Achievement::where('is_active', true)
            ->where('is_hidden', false)
            ->where('id', '!=', $achievement->id)
            ->where(function ($q) use ($achievement) {
                $q->where('category', $achievement->category)
                  ->orWhere('rarity', $achievement->rarity);
            })
            ->limit(4)
            ->get();

        // Siapa saja yang sudah unlock achievement ini (leaderboard kecil)
        $earners = UserAchievement::with('user.profile')
            ->where('achievement_id', $achievement->id)
            ->orderBy('earned_at')
            ->limit(5)
            ->get();

        return view('achievements.show', compact(
            'achievement', 'user', 'profile',
            'isUnlocked', 'userAchievement',
            'currentProgress', 'progressPct',
            'related', 'earners',
        ));
    }

    // ────────────────────────────────────────────────────────────────────────
    //  CREATE
    // ────────────────────────────────────────────────────────────────────────
    public function create()
    {
        $categories = Achievement::categories();
        $rarities   = Achievement::rarities();

        return view('achievements.create', compact('categories', 'rarities'));
    }

    // ────────────────────────────────────────────────────────────────────────
    //  STORE
    // ────────────────────────────────────────────────────────────────────────
    public function store(AchievementRequest $request)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        Achievement::create($data);

        return redirect()->route('achievements.index')
            ->with('success', 'Achievement berhasil dibuat.');
    }

    // ────────────────────────────────────────────────────────────────────────
    //  EDIT
    // ────────────────────────────────────────────────────────────────────────
    public function edit(Achievement $achievement)
    {
        $categories = Achievement::categories();
        $rarities   = Achievement::rarities();

        return view('achievements.edit', compact('achievement', 'categories', 'rarities'));
    }

    // ────────────────────────────────────────────────────────────────────────
    //  UPDATE
    // ────────────────────────────────────────────────────────────────────────
    public function update(AchievementRequest $request, Achievement $achievement)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $achievement->update($data);

        return redirect()->route('achievements.show', $achievement)
            ->with('success', 'Achievement berhasil diperbarui.');
    }

    // ────────────────────────────────────────────────────────────────────────
    //  DESTROY
    // ────────────────────────────────────────────────────────────────────────
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();

        return redirect()->route('achievements.index')
            ->with('success', 'Achievement berhasil dihapus.');
    }

    // ────────────────────────────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Hitung progress user untuk satu achievement.
     */
    private function getUserProgress($user, Achievement $achievement): int
    {
        $profile = $user->profile ?? null;

        return match ($achievement->requirement_type) {
            'xp_total'          => (int) ($profile?->xp_total ?? 0),
            'streak_days'       => (int) ($profile?->streak_days ?? 0),
            'current_level'     => (int) ($profile?->current_level ?? 1),
            'lessons_completed' => \App\Models\UserProgress::where('user_id', $user->id)
                                    ->where('status', 'completed')->count(),
            'courses_completed' => \App\Models\UserProgress::where('user_id', $user->id)
                                    ->where('status', 'completed')
                                    ->whereNull('lesson_id')
                                    ->count(),
            'ai_messages'       => \App\Models\AiMessage::whereHas('conversation', function ($q) use ($user) {
                                        $q->where('user_id', $user->id);
                                    })->where('role', 'user')->count(),
            default             => 0,
        };
    }

    /**
     * Hitung learning rank berdasarkan total XP.
     */
    private function calculateRank(int $xp): string
    {
        return match (true) {
            $xp >= 10000 => 'Grandmaster',
            $xp >= 5000  => 'Master',
            $xp >= 2000  => 'Expert',
            $xp >= 1000  => 'Mahir',
            $xp >= 500   => 'Menengah',
            $xp >= 100   => 'Pemula',
            default      => 'Baru Mulai',
        };
    }
}