<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\SendMessageRequest;
use App\Http\Resources\Client\ChatResource;
use App\Http\Resources\Client\MessageResource;
use App\Http\Resources\Client\MessagesChatResource;
use App\Services\MessageService;

class MessageController extends Controller
{
    private MessageService $service;

    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }

    public function sendMessage(SendMessageRequest $request)
    {
        $data = $request->validated();

        $message = $this->service->sendMessage($data);

        return new MessageResource($message);
    }

    public function getChats()
    {
        $chats = $this->service->getChats();

        return ChatResource::collection($chats);
    }

    public function getChat($chatId)
    {
        $chat = $this->service->getChat($chatId);

        return MessagesChatResource::collection($chat);
    }
}
