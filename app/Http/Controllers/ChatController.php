<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Events\MessageSent;
use App\Notifications\ChatMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {

            // ADMIN: sees all conversations
            $conversations = Conversation::with(['user', 'messages'])
                ->latest()
                ->get();

        } else {

            // USER: sees only their own conversation with admin
            $conversations = Conversation::with(['messages'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('chat.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $user = auth()->user();

        // SECURITY RULE
        if (!$user->hasRole('admin') && $conversation->user_id !== $user->id) {
            abort(403);
        }

        $conversation->load(['messages.sender', 'user']);

        return view('chat.show', compact('conversation'));
    }

    public function start()

    {

        $user = auth()->user();

        $adminId = User::role('admin')->first()->id;

        $conversation = Conversation::firstOrCreate([

            'user_id' => $user->id,

            'admin_id' => $adminId,

        ]);

        return redirect()->route('chat.show', $conversation->id);

    }

    
    public function send(Request $request, ?Conversation $conversation = null)

{

    $user = auth()->user();

    $request->validate([

        'message' => 'required|string'

    ]);

    /**

     * STEP 1: Resolve admin

     */

    $adminId = User::role('admin')->first()?->id;

    if (!$adminId) {

        return response()->json([

            'success' => false,

            'message' => 'Admin not configured'

        ], 500);

    }

    /**

     * STEP 2: Auto-create conversation if missing OR invalid

     */

    if (!$conversation) {

        $conversation = Conversation::firstOrCreate([

            'user_id' => $user->hasRole('admin') ? $user->id : $user->id,

            'admin_id' => $adminId,

        ]);

    }

    /**

     * STEP 3: SECURITY CHECK (strict)

     */

    if (!in_array($user->id, [$conversation->user_id, $conversation->admin_id])) {

        abort(403);

    }

    /**

     * STEP 4: Create message

     */

    $message = $conversation->messages()->create([

        'sender_id' => $user->id,

        'message' => $request->message,

    ]);

    return response()->json([

        'success' => true,

        'message' => $message

    ]);

}

    public function messages(Conversation $conversation)
    {
        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('id')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'sender_id' => $msg->sender_id,
                    'sender_name' => $msg->sender->name ?? 'User',
                    'time' => $msg->created_at->format('h:i A'),
                ];
            });

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function inboxData()
    {
        $user = auth()->user();

        $conversations = Conversation::with(['user', 'messages'])
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                ->orWhere('admin_id', $user->id);
            })
            ->latest()
            ->get()
            ->map(function ($conv) use ($user) {

                $lastMessage = $conv->messages->last();

                return [
                    'id' => $conv->id,
                    'user_name' => $conv->user->name ?? 'Client',
                    'last_message' => $lastMessage->message ?? 'No messages yet',
                    'unread' => $conv->messages()
                        ->whereNull('read_at')
                        ->where('sender_id', '!=', $user->id)
                        ->count(),
                ];
            });

        return response()->json([
            'conversations' => $conversations
        ]);
    }

}