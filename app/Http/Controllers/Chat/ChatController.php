<?php

namespace App\Http\Controllers\Chat;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use \Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Musonza\Chat\Eventing\MessageWasSent;
use Musonza\Chat\Models\Message;
use Musonza\Chat\Models\Participation;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Participation::with('conversation')->where('messageable_id', auth()->user()->id)->get();
        $conversations = $conversations->pluck('conversation.id')->toArray();

        $data = [
            'conversations' => array_map('intval', $conversations),
            'participant' => [
                'id' => auth()->user()->id,
                'type' => get_class(auth()->user())
            ]
        ];

        return view('chat', $data);
    }
}
