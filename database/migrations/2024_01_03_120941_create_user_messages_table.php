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
        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('recipient_id');
            $table->unsignedBigInteger('sender_id');

            $table->string('message')->nullable(false);

            $table->index('recipient_id', 'user_messages_recipient_idx');
            $table->index('sender_id', 'user_messages_sender_idx');

            $table->foreign('recipient_id', 'user_messages_recipient_fk')->on('users')->references('id');
            $table->foreign('sender_id', 'user_messages_sender_fk')->on('users')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_messages');
    }
};
