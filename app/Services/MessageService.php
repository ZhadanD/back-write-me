<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class MessageService
{
    public function sendMessage($data)
    {
        $currentUserId = auth()->user()->id;
        $chatId = 0;

        $chat = Chat::where('first_participant_id', $currentUserId)
                      ->where('second_participant_id', $data['recipientId'])
                      ->orWhere('first_participant_id', $data['recipientId'])
                      ->where('second_participant_id', $currentUserId)
                      ->get('id');

        if($chat->modelKeys() === []) {
            $newChat = Chat::create([
                'first_participant_id' => $currentUserId,
                'second_participant_id' => $data['recipientId'],
            ]);
            $chatId = $newChat->id;
        } else $chatId = $chat->modelKeys()[0];

        return Message::create([
            'text' => $data['message'],
            'sender_id' => $currentUserId,
            'chat_id' => $chatId,
        ]);
    }

    public function checkChats($chats, $currentUserId)
    {
        for ($i = 0; $i < count($chats); $i++) {
            if($chats[$i]->first_id === $currentUserId) $chats[$i]->name_interlocutor = $chats[$i]->second_name;
            else if($chats[$i]->second_id === $currentUserId) $chats[$i]->name_interlocutor = $chats[$i]->first_name;
        }

        return $chats;
    }

    public function getChats()
    {
        $currentUserId = auth()->user()->id;

        $chats = Chat::where('first_participant_id', $currentUserId)
                     ->orWhere('second_participant_id', $currentUserId)
                     ->join('users as first_participants', 'first_participants.id', '=', 'chats.first_participant_id')
                     ->join('users as second_participants', 'second_participants.id', '=', 'chats.second_participant_id')
                     ->select('chats.id', 'first_participants.name as first_name', 'first_participants.id as first_id', 'second_participants.id as second_id', 'second_participants.name as second_name')
                     ->get();

        return $this->checkChats($chats, $currentUserId);
    }

    public function checkMessages($messages, $currentUserId)
    {
        for ($i = 0; $i < count($messages); $i++) {
            if($messages[$i]->sender_id === $currentUserId) $messages[$i]->my = true;
            else $messages[$i]->my = false;
        }

        return $messages;
    }

    public function getChat($chatId)
    {
        $currentUserId = auth()->user()->id;

        $chat = Chat::where(function ($query) use ($currentUserId) {
            $query->orWhere('first_participant_id', '=', $currentUserId)
                  ->orWhere('second_participant_id', '=', $currentUserId);
            })
            ->where('id', $chatId)
            ->first();

        if(!$chat) throw new HttpResponseException(response()->json(['error' => 'Not Found'], 404));

        return $this->checkMessages($chat->messages, $currentUserId);
    }
}
