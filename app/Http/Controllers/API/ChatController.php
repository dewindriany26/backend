<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function chats(Request $request)
    {
        $data =  DB::table('chat_dosen_user')->where('id_dosen_sender', $request->q)->get();
        $inUser = DB::table('chat_dosen_user')->where('id_dosen_sender', $request->q)->select('id_user_receiver')->groupBy('id_user_receiver')->pluck('id_user_receiver');
        $groupInUser = $inUser->map(function($item) use($data){
            return [
                'isPinned' => true,
                'msg' => $data->where('id_user_receiver', $item)->values()->map(function($q){
                    return [
                        'isSeen' => true,
                        'isSent' => true,
                        'textContent' => $q->message,
                        'time' => 'Mon Dec 10 2018 07:45:00 GMT+0000 (GMT)'
                    ];
                })
            ];
        });
        $groupInUser = $groupInUser->toArray();
        array_unshift($groupInUser, ['dawda' => 'dawd']);
        unset($groupInUser[0]);
        return $groupInUser;
    }
    public function sendChat(Request $request)
    {
        $input = $request->all();
        $payload =  $input['payload'];

        DB::table('chat_dosen_user')->insert([
            'id_dosen_sender' => $payload['isUser'],
            'id_user_receiver' => $payload['id'],
            'message' => $payload['msg']['textContent'],
            'is_seen' => 1,
        ]);
        return $payload;
    }
}
