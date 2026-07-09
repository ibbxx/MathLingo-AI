<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminAnnouncement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Halaman kirim pengumuman + riwayat pengumuman yang sudah dikirim.
     */
    public function index(): View
    {
        $students = User::where('role', 'student')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        // Riwayat pengumuman (grupkan berdasarkan judul+pesan+waktu kirim,
        // karena satu pengiriman = banyak baris notifikasi, satu per penerima).
        $history = DatabaseNotification::where('type', AdminAnnouncement::class)
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn ($n) => $n->data['title'] . '|' . $n->created_at->format('Y-m-d H:i:s'))
            ->map(function ($group) {
                $first = $group->first();

                return [
                    'title'         => $first->data['title'] ?? '-',
                    'message'       => $first->data['message'] ?? '-',
                    'recipients'    => $group->count(),
                    'read_count'    => $group->whereNotNull('read_at')->count(),
                    'sent_at'       => $first->created_at,
                ];
            })
            ->take(20)
            ->values();

        return view('admin.notifications.index', compact('students', 'history'));
    }

    /**
     * Kirim pengumuman ke semua siswa atau siswa tertentu.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:150'],
            'message'      => ['required', 'string', 'max:500'],
            'url'          => ['nullable', 'string', 'max:255'],
            'target'       => ['required', 'in:all,specific'],
            'user_ids'     => ['required_if:target,specific', 'array'],
            'user_ids.*'   => ['integer', 'exists:users,id'],
        ]);

        $recipients = $validated['target'] === 'all'
            ? User::where('role', 'student')->get()
            : User::whereIn('id', $validated['user_ids'] ?? [])->where('role', 'student')->get();

        if ($recipients->isEmpty()) {
            return redirect()
                ->route('admin.notifications.index')
                ->with('error', 'Tidak ada penerima yang valid.');
        }

        $notification = new AdminAnnouncement(
            $validated['title'],
            $validated['message'],
            $validated['url'] ?? null,
        );

        Notification::send($recipients, $notification);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', "Pengumuman berhasil dikirim ke {$recipients->count()} siswa.");
    }
}
