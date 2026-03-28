<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Get chat list (users with whom the authenticated user has chatted)
    public function getChatList()
    {
        $user = Auth::user();
        $chatUsers = User::whereIn('id', function ($query) use ($user) {
            $query->select('sender_id')
                ->from('messages')
                ->where('receiver_id', $user->id)
                ->union(
                    \DB::table('messages')->select('receiver_id')->where('sender_id', $user->id)
                );
        })->get();

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
                'id'              => $chatUser->id,
                'name'            => $chatUser->name,
                'image'           => $chatUser->profile_image,
                'last_message'    => $lastMessage?->message ?? '',
                'last_message_time'=> $lastMessage?->created_at->format('h:i A, M d') ?? '',
                'unread_count'    => $unreadCount,               // <-- NEW
            ];
        });

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

        return response()->json($messages->map(function ($m) use ($user) {
            return [
                'id'     => $m->id,
                'sender' => $m->sender->name,
                'text'   => $m->message,
                'type'   => $m->sender_id == $user->id ? 'me' : 'other',
                'time'   => $m->created_at->format('h:i A, M d'),
                'seen'   => $m->is_seen,               // <-- NEW
            ];
        }));
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

        return response()->json([
            'sender' => Auth::user()->name,
            'text' => $message->message,
            'type' => 'me',
            'time' => $message->created_at->format('h:i A, M d')
        ]);
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