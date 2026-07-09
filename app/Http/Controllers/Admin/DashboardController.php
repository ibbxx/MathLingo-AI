<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Vocabulary;
use App\Models\AiConversation;
use App\Models\UserAchievement;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $startOfMonth = now()->startOfMonth();

        $stats = [
            'total_users'          => User::count(),
            'new_users_this_month' => User::where('created_at', '>=', $startOfMonth)->count(),

            'total_courses'          => Course::count(),
            'new_courses_this_month' => Course::where('created_at', '>=', $startOfMonth)->count(),

            'total_lessons'    => Lesson::count(),
            'total_vocabulary' => Vocabulary::count(),

            'total_conversations'          => AiConversation::count(),
            'new_conversations_this_month' => AiConversation::where('created_at', '>=', $startOfMonth)->count(),

            'total_achievements'          => UserAchievement::count(),
            'new_achievements_this_month' => UserAchievement::where('earned_at', '>=', $startOfMonth)->count(),
        ];

 
        $days = collect(range(29, 0))->map(fn ($i) => now()->subDays($i)->startOfDay());

        $chartData = [
            'labels' => $days->map(fn (Carbon $d) => $d->translatedFormat('d M Y'))->values()->toArray(),
            'data'   => $days->map(function (Carbon $d) {
                return User::whereDate('created_at', $d->toDateString())->count();
            })->values()->toArray(),
        ];

        // ── Aktivitas Terbaru (gabungan beberapa event) ─────────────────
        $recentUsers = User::latest()->take(5)->get()->map(fn ($u) => [
            'text' => "{$u->name} baru saja mendaftar",
            'time' => $u->created_at,
        ]);

        $recentAchievements = UserAchievement::with(['user', 'achievement'])
            ->latest('earned_at')
            ->take(5)
            ->get()
            ->map(fn ($ua) => [
                'text' => ($ua->user->name ?? 'Pengguna') . ' meraih pencapaian "' .
                          ($ua->achievement->title ?? '-') . '"',
                'time' => $ua->earned_at ?? $ua->created_at,
            ]);

        $recentActivities = $recentUsers
            ->concat($recentAchievements)
            ->filter(fn ($item) => $item['time'] !== null)
            ->sortByDesc('time')
            ->take(8)
            ->values();

        return view('admin.dashboard.index', compact('stats', 'chartData', 'recentActivities'));
    }
}
