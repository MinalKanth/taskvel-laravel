<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index — with filter, type, sort
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = $request->user()
            ->notifications()
            ->latest();

        // Read / unread filter
        match ($request->filter ?? 'all') {
            'unread' => $query->where('is_read', false),
            'read'   => $query->where('is_read', true),
            default  => null,
        };

        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Sort
        match ($request->sort ?? 'newest') {
            'oldest'   => $query->reorder()->oldest(),
            'priority' => $query->reorder()->orderByRaw("FIELD(priority,'high','medium','low')")->latest(),
            default    => null, // already latest()
        };

        $notifications = $query->paginate(20)->withQueryString();

        return view('notifications.index', compact('notifications'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id'      => ['nullable', 'exists:tasks,id'],
            'title'        => ['required', 'string', 'max:255'],
            'message'      => ['required', 'string'],
            'type'         => ['required', 'in:task,reminder,focus,remark,system'],
            'priority'     => ['required', 'in:low,medium,high'],
            'scheduled_at' => ['nullable', 'date'],
            'data'         => ['nullable', 'array'],
        ]);

        $validated['user_id'] = auth()->id();

        Notification::create($validated);

        return back()->with('success', 'Notification created.');
    }

    /*
    |--------------------------------------------------------------------------
    | Show — auto-marks as read
    |--------------------------------------------------------------------------
    */
    public function show(Notification $notification)
    {
        $this->authorizeNotification($notification);

        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return view('notifications.show', compact('notification'));
    }

    /*
    |--------------------------------------------------------------------------
    | Mark single as read
    |--------------------------------------------------------------------------
    */
    public function markAsRead(Notification $notification)
    {
        $this->authorizeNotification($notification);
        $notification->markAsRead();
        return back()->with('success', 'Marked as read.');
    }

    // Route alias used in Blade: notifications.read
    public function read(Notification $notification)
    {
        return $this->markAsRead($notification);
    }

    /*
    |--------------------------------------------------------------------------
    | Mark all as read
    |--------------------------------------------------------------------------
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

    // Route alias used in Blade: notifications.readAll
    public function readAll(Request $request)
    {
        return $this->markAllAsRead($request);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete single
    |--------------------------------------------------------------------------
    */
    public function destroy(Notification $notification)
    {
        $this->authorizeNotification($notification);
        $notification->delete();
        return back()->with('success', 'Notification deleted.');
    }

    /*
    |--------------------------------------------------------------------------
    | Clear all read notifications
    |--------------------------------------------------------------------------
    */
    public function clearRead(Request $request)
    {
        $deleted = $request->user()
            ->notifications()
            ->where('is_read', true)
            ->delete();

        return back()->with('success', $deleted . ' read notification(s) cleared.');
    }

    /*
    |--------------------------------------------------------------------------
    | Unread count (JSON — for navbar badge)
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    | Authorization
    |--------------------------------------------------------------------------
    */
    private function authorizeNotification(Notification $notification): void
    {
        abort_if($notification->user_id !== auth()->id(), 403);
    }
}