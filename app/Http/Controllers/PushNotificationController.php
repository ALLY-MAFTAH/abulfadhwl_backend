<?php

namespace App\Http\Controllers;

use App\Models\PushNotification;
use App\Services\FcmV1;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    private const TOPIC = 'all';

    public function index()
    {
        $notifications = PushNotification::orderBy('created_at', 'desc')->take(200)->get();
        return view('notifications.index', compact('notifications'));
    }

    /** New notification typed in the form. */
    public function bulksend(Request $req)
    {
        $data = $req->validate([
            'title' => 'required|string|max:120',
            'body' => 'required|string|max:500',
            'img' => 'nullable|url|max:500',
        ]);

        $n = PushNotification::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'img' => $data['img'] ?? null,
            'topic' => self::TOPIC,
            'status' => 'pending',
            'translations' => \App\Support\Translations::collect($req, ['title', 'body']),
        ]);

        return $this->deliver($n);
    }

    /** Send an old notification again. It is logged as its own entry. */
    public function resend(PushNotification $notification)
    {
        $n = PushNotification::create([
            'title' => $notification->title,
            'body' => $notification->body,
            'img' => $notification->img,
            'topic' => $notification->topic ?: self::TOPIC,
            'status' => 'pending',
            'resent_from' => $notification->id,
            'translations' => $notification->translations,
        ]);

        return $this->deliver($n);
    }

    /** Send and record exactly what Firebase answered. */
    private function deliver(PushNotification $n)
    {
        $variants = ['sw' => [(string) $n->title, (string) $n->body]];
        foreach (['en', 'ar'] as $lang) {
            $t = $n->translations[$lang] ?? [];
            if (!empty($t['title']) || !empty($t['body'])) {
                $variants[$lang] = [$t['title'] ?? $n->title, $t['body'] ?? $n->body];
            }
        }
        $result = FcmV1::sendLocalized(
            $variants,
            $n->img,
            ['click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'id' => $n->id, 'status' => 'done']
        );

        $n->status = $result['ok'] ? 'sent' : 'failed';
        $n->fcm_message_id = $result['message_id'] ?? null;
        $n->error = $result['ok'] ? null : mb_substr((string) ($result['error'] ?? $result['body']), 0, 1000);
        $n->sent_at = $result['ok'] ? now() : null;
        $n->save();

        if (!$result['ok']) {
            return back()->with('error', 'Arifa HAIKUTUMWA: ' . $n->error . ' (imehifadhiwa kwenye historia, unaweza kujaribu tena)');
        }
        return back()->with('success', 'Firebase imekubali arifa (' . implode(', ', array_map('strtoupper', $result['langs'] ?? [])) . '). Kitambulisho: ' . basename(explode(',', (string) $n->fcm_message_id)[0]));
    }

    public function destroy(PushNotification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Imefutwa kwenye historia');
    }
}
