<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'img', 'topic', 'status', 'fcm_message_id', 'error', 'sent_at', 'resent_from', 'translations'];

    protected $casts = ['sent_at' => 'datetime', 'translations' => 'array'];
}
