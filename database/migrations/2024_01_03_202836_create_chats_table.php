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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('first_participant_id');
            $table->unsignedBigInteger('second_participant_id');

            $table->index('first_participant_id', 'chats_first_participant_idx');
            $table->index('second_participant_id', 'chats_second_participant_idx');

            $table->foreign('first_participant_id', 'chats_first_participant_fk')->on('users')->references('id');
            $table->foreign('second_participant_id', 'chats_second_participant_fk')->on('users')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
