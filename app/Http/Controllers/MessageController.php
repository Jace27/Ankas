<?php

namespace App\Http\Controllers;

use App\Models\messages;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function Add(Request $request){
        $user = null;
        if ($request->input('user') != 'null')
            $user = \App\Models\users::where('email', '=', $request->input('user'))->first()->id;
        messages::create([
            'user_id' => $user,
            'chat_id' => $request->input('chat_id'),
            'text' => $request->input('text')
        ]);
        return ['status'=>'success'];
    }

    public function GetChat(Request $request, $chat_id){
        $chat = [
            'chat_id' => (int)$chat_id,
            'messages' => []
        ];
        if ($chat_id == 0) $chat['chat_id'] = messages::max('chat_id') + 1;
        $chat['messages'] = messages::where('chat_id', '=', $chat['chat_id'])->get();
        foreach ($chat['messages'] as $message){
            $user = null;
            if (!isset($_SESSION)) session_start();
            if (isset($_SESSION['AuthedUser'])) $user = \App\Models\users::where('email', '=', $_SESSION['AuthedUser']['email'])->first();

            if ($message->user_id == null) {
                if ($user == null)
                    $message->user = 'Вы';
                else if ($message->user_id != $user->id)
                    $message->user = 'Клиент';
                else
                    $message->user = 'Вы';
            } else {
                if ($user == null)
                    $message->user = 'Менеджер';
                else if ($message->user_id == $user->id)
                    $message->user = 'Вы';
            }
        }
        return $chat;
    }
    public function GetChats(Request $request){
        if (!\App\Http\Controllers\UserController::UserHaveRole('Менеджер'))
            return ['status'=>'error', 'message'=>'Недостаточно прав'];
        $chats = [];
        $chats = messages::select('chat_id')->groupBy('chat_id')->get();
        foreach ($chats as $chat){
            $last = messages::where('chat_id', '=', $chat->chat_id)->max('created_at');
            $last = messages::where([['chat_id', '=', $chat->chat_id], ['created_at', '=', $last]])->first();
            $chat->message = $last->text;
            $chat->viewed = $last->viewed;
        }
        return $chats->sortBy('viewed')->values();
    }
    public function View($chat_id){
        if (!\App\Http\Controllers\UserController::UserHaveRole('Менеджер'))
            return ['status'=>'error', 'message'=>'Недостаточно прав'];
        $messages = messages::where('chat_id', '=', $chat_id)->get();
        foreach ($messages as $message){
            $message->viewed = 1;
            $message->save();
        }
        return ['status'=>'success'];
    }
}
