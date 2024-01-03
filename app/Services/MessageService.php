<?php

namespace App\Services;

use App\Models\UserMessage;

class MessageService
{
    public function sendMessage($data)
    {
        return UserMessage::create([
            'recipient_id' => $data['recipientId'],
            'sender_id' => auth()->user()->id,
            'message' => $data['message'],
        ]);
    }
}
