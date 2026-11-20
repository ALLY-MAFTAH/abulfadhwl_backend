<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Keep a proper log of every send: where, when, and what Firebase answered. */
    public function up()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->string('topic')->default('all');
            $table->string('status')->default('sent');          // pending | sent | failed
            $table->string('fcm_message_id')->nullable();       // Firebase's receipt
            $table->text('error')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedBigInteger('resent_from')->nullable();
        });

        // Notifications sent before this log existed were never verified.
        \Illuminate\Support\Facades\DB::table('push_notifications')->update(['status' => 'unknown']);
    }

    public function down()
    {
        Schema::table('push_notifications', function (Blueprint $table) {
            $table->dropColumn(['topic', 'status', 'fcm_message_id', 'error', 'sent_at', 'resent_from']);
        });
    }
};
