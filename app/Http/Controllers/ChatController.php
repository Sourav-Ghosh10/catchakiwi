<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\MessageSent;
use App\Events\MessageEdited;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Get chat list (users with whom the authenticated user has chatted)
    public function getChatList(Request $request)
    {
        $user = Auth::user();
        
        // Find users with whom the authenticated user has chatted
        $chatUsersIds = \DB::table('messages')
            ->where('receiver_id', $user->id)
            ->select('sender_id as uid')
            ->union(
                \DB::table('messages')
                ->where('sender_id', $user->id)
                ->select('receiver_id as uid')
            )->pluck('uid')->toArray();
        
        $chatUsersIds = collect($chatUsersIds);
        
        // If chat_user_id is provided and filled, ensure it's in the list
        if ($request->filled('chat_user_id')) {
            $chatUserId = $request->chat_user_id;
            if (!$chatUsersIds->contains($chatUserId) && $chatUserId != $user->id) {
                $chatUsersIds->push($chatUserId);
            }
        }

        $chatUsers = User::whereIn('id', $chatUsersIds)->get();

        $chatList = $chatUsers->map(function ($chatUser) use ($user) {
            $lastMessage = Message::where(function ($q) use ($user, $chatUser) {
                $q->where('sender_id', $user->id)->where('receiver_id', $chatUser->id);
            })->orWhere(function ($q) use ($user, $chatUser) {
                $q->where('sender_id', $chatUser->id)->where('receiver_id', $user->id);
            })->latest()->first();

            $unreadCount = Message::where('sender_id', $chatUser->id)
                ->where('receiver_id', $user->id)
                ->where('is_seen', 'false')
                ->count();

            return [
                'id' => $chatUser->id,
                'name' => $chatUser->name,
                'image' => $chatUser->profile_image,
                'last_message' => $lastMessage?->message ?? '',
                'last_message_time' => $lastMessage ? $lastMessage->created_at->format('h:i A, M d') : '',
                'unread_count' => $unreadCount,
            ];
        });

        if ($request->filled('chat_user_id')) {
            $chatUserId = $request->chat_user_id;
            $chatList = $chatList->sortByDesc(function ($item) use ($chatUserId) {
                return $item['id'] == $chatUserId ? 1 : 0;
            })->values();
        }

        return response()->json($chatList);
    }

    // Get messages for a specific user
    public function getMessages($receiverId)
    {
        $user = Auth::user();

        $messages = Message::where(function ($q) use ($user, $receiverId) {
            $q->where('sender_id', $user->id)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($user, $receiverId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')
            ->get();

        // ---- MARK INCOMING MESSAGES AS SEEN ----
        $incoming = $messages->where('receiver_id', $user->id)->where('is_seen', 'false');
        foreach ($incoming as $msg) {
            $msg->update(['is_seen' => 'true']);
        }
        // -----------------------------------------

        $mappedMessages = [];
        $hasReply = false;
        
        // Process in reverse to easily find if a message was replied to
        for ($i = count($messages) - 1; $i >= 0; $i--) {
            $m = $messages[$i];
            
            if ($m->sender_id != $user->id) {
                $hasReply = true;
            }

            $mappedMessages[] = [
                'id' => $m->id,
                'sender' => $m->sender->name,
                'text' => $m->message,
                'type' => $m->sender_id == $user->id ? 'me' : 'other',
                'time' => $m->created_at->format('h:i A, M d'),
                'seen' => $m->is_seen,
                'is_edited' => $m->is_edited ?? 0,
                'can_edit' => ($m->sender_id == $user->id && !$hasReply)
            ];
        }

        // Reverse back to chronological order
        $mappedMessages = array_reverse($mappedMessages);

        return response()->json($mappedMessages);
    }

    // Send a message
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            //'is_seen' => 'false'
        ]);

        $responseData = [
            'id' => $message->id,
            'sender_id' => Auth::user()->id,
            'sender' => Auth::user()->name,
            'text' => $message->message,
            'type' => 'other', // From receiver's perspective
            'time' => $message->created_at->format('h:i A, M d'),
            'seen' => $message->is_seen,
            'is_edited' => 0,
            'can_edit' => true
        ];

        broadcast(new MessageSent($message, $responseData))->toOthers();

        $responseData['type'] = 'me';
        return response()->json($responseData);
    }
    
    // Edit a message
    public function editMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = Message::findOrFail($id);
        
        // Ensure the sender is the authenticated user
        if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if replied to
        $hasReply = Message::where('sender_id', $message->receiver_id)
            ->where('receiver_id', $message->sender_id)
            ->where('created_at', '>', $message->created_at)
            ->exists();

        if ($hasReply) {
            return response()->json(['error' => 'Message has been replied to and cannot be edited'], 403);
        }

        $message->update([
            'message' => $request->message,
            'is_edited' => 1
        ]);

        $responseData = [
            'id' => $message->id,
            'text' => $message->message,
            'time' => $message->created_at->format('h:i A, M d'),
            'is_edited' => 1
        ];

        broadcast(new MessageEdited($message, $responseData))->toOthers();

        return response()->json(['success' => true, 'message' => $responseData]);
    }
    public function unreadCounts()
    {
        $user = Auth::user();

        // Get every user we have ever chatted with
        $chatUserIds = DB::table('messages')
            ->where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->selectRaw('COALESCE(sender_id, receiver_id) as uid')
            ->distinct()
            ->pluck('uid');

        $counts = User::whereIn('id', $chatUserIds)
            ->get()
            ->mapWithKeys(function ($u) use ($user) {
                $cnt = Message::where('sender_id', $u->id)
                    ->where('receiver_id', $user->id)
                    ->where('is_seen', 'false')
                    ->count();
                return [$u->id => $cnt];
            });

        return response()->json($counts);
    }
    public function markSeen($receiverId)
    {
        $user = Auth::user();

        Message::where('sender_id', $receiverId)
            ->where('receiver_id', $user->id)
            ->where('is_seen', 'false')
            ->update(['is_seen' => 'true']);

        return response()->json(['ok' => true]);
    }
}
?>