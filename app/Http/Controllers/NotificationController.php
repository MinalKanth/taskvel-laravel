<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display all notifications.
     */
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Store a new notification.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => ['nullable', 'exists:tasks,id'],
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'in:task,reminder,focus,system'],
            'priority' => ['required', 'in:low,medium,high'],
            'scheduled_at' => ['nullable', 'date'],
            'data' => ['nullable', 'array'],
        ]);

        $validated['user_id'] = auth()->id();

        Notification::create($validated);

        return back()->with('success', 'Notification created successfully.');
    }

    /**
     * Show a notification.
     */
    public function show(Notification $notification)
    {
        $this->authorizeNotification($notification);

        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return view('notifications.show', compact('notification'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        $this->authorizeNotification($notification);

        $notification->markAsRead();

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()
            ->notifications()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete a notification.
     */
    public function destroy(Notification $notification)
    {
        $this->authorizeNotification($notification);

        $notification->delete();

        return back()->with('success', 'Notification deleted successfully.');
    }

    /**
     * Delete all read notifications.
     */
    public function clearRead(Request $request)
    {
        $request->user()
            ->notifications()
            ->where('is_read', true)
            ->delete();

        return back()->with('success', 'Read notifications cleared.');
    }

    /**
     * Return unread notification count.
     */
    public function unreadCount(Request $request)
    {
        return response()->json([
            'count' => $request->user()
                ->notifications()
                ->where('is_read', false)
                ->count(),
        ]);
    }

    /**
     * Ensure notification belongs to authenticated user.
     */
    private function authorizeNotification(Notification $notification): void
    {
        abort_if($notification->user_id !== auth()->id(), 403);
    }
}