<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\SendMessageRequest;
use App\Http\Resources\Client\MessageResource;
use App\Services\MessageService;
use Illuminate\Http\Request;

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
}
