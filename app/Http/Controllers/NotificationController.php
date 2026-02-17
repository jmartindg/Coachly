<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view('notifications.index', [
            'notifications' => $notifications,
            'layoutComponent' => $request->user()->role === Role::Coach ? 'coach-layout' : 'client-layout',
        ]);
    }

    public function markAsRead(Request $request, Notification $notification): JsonResponse
    {
        $userNotification = $request->user()
            ->appNotifications()
            ->whereKey($notification->getKey())
            ->firstOrFail();

        if (is_null($userNotification->read_at)) {
            $userNotification->markAsRead();
        }

        return response()->json([
            'success' => true,
            'unread_count' => $request->user()->unreadNotifications()->count(),
        ]);
    }
}
