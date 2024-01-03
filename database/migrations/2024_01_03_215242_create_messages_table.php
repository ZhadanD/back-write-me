<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->string('text')->nullable(false);

            $table->unsignedBigInteger('sender_id');
            $table->index('sender_id', 'messages_sender_idx');
            $table->foreign('sender_id', 'messages_sender_fk')->on('users')->references('id');

            $table->unsignedBigInteger('chat_id');
            $table->index('chat_id', 'messages_chat_idx');
            $table->foreign('chat_id', 'messages_chat_fk')->on('chats')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
