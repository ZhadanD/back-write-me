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
        Schema::create('friends_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('friend_id');

            $table->index('user_id', 'friends_user_user_idx');
            $table->index('friend_id', 'friends_user_friend_idx');

            $table->foreign('user_id', 'friends_user_user_fk')->on('users')->references('id');
            $table->foreign('friend_id', 'friends_user_friend_fk')->on('users')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends_user');
    }
};
