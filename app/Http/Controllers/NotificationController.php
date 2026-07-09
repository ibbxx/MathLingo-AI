<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Halaman daftar notifikasi (full page).
     */
    public function index(): View
    {
        $notifications = Auth::user()
            ->notifications()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Endpoint JSON untuk dropdown bell + polling realtime.
     */
    public function latest(): JsonResponse
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->latest()
            ->take(8)
            ->get()
            ->map(fn ($n) => [
                'id'         => $n->id,
                'icon'       => $n->data['icon'] ?? 'bell',
                'color'      => $n->data['color'] ?? '#2563EB',
                'title'      => $n->data['title'] ?? '',
                'message'    => $n->data['message'] ?? '',
                'url'        => $n->data['url'] ?? null,
                'is_read'    => $n->read_at !== null,
                'created_at' => $n->created_at->diffForHumans(),
            ]);

        return response()->json([
            'unread_count'  => $user->unreadNotifications()->count(),
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(string $id): JsonResponse
    {
        $notification = Auth::user()->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(): JsonResponse
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    public function destroy(string $id): JsonResponse
    {
        Auth::user()->notifications()->where('id', $id)->delete();

        return response()->json(['success' => true]);
    }
}
