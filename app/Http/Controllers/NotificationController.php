<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function unread(Request $request)
    {
        $user = $request->user();

        $notifications = $user->unreadNotifications()
            ->latest()
            ->take(20)
            ->get()
            ->map(fn($n) => [
                'id'      => $n->id,
                'title'   => $n->data['title'] ?? 'Notification',
                'message' => $n->data['message'] ?? '',
                'data'    => $n->data['data'] ?? ($n->data['data'] ?? []),
                'created' => $n->created_at->diffForHumans(),
                'read'    => $n->read_at !== null,
            ]);

        return response()->json([
            'count' => $user->unreadNotifications()->count(),
            'items' => $notifications
        ]);
    }

    public function readAll(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();
        return response()->json(['ok' => true]);
    }
}