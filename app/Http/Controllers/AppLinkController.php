<?php

namespace App\Http\Controllers;

/**
 * Landing page for shared links: https://maftah.co.tz/app/{type}/{id}.
 * With the app installed the OS opens the app directly (App Links / Universal
 * Links) and never reaches this page; otherwise people land here and can open
 * the app via its custom scheme or go to a store.
 */
class AppLinkController extends Controller
{
    private const LABELS = [
        'song' => 'Sauti',
        'album' => 'Mkusanyiko wa Sauti',
        'book' => 'Kitabu',
        'article' => 'Makala',
        'fatwa' => 'Fatwa',
        'stream' => 'Darsa Mubaashara',
        'announcement' => 'Tangazo',
        'qna' => 'Maswali na Majibu',
    ];

    public function show(string $type, ?string $id = null)
    {
        abort_unless(isset(self::LABELS[$type]), 404);

        [$title, $desc, $file] = $this->details($type, $id);

        return view('app_link', [
            'label' => self::LABELS[$type],
            'title' => $title,
            'desc' => $desc,
            'fileUrl' => $file ? asset('storage/' . implode('/', array_map('rawurlencode', explode('/', $file)))) : null,
            'isAudio' => $type === 'song',
            'deepLink' => 'abulfadhwl://open/' . $type . ($id !== null ? '/' . $id : ''),
            'iosUrl' => config('app.ios_store_url'),
            'androidUrl' => config('app.android_store_url'),
        ]);
    }

    /** Real name + short text of the shared item, for the link preview (WhatsApp etc.). */
    private function details(string $type, ?string $id): array
    {
        $fallback = ['Abul Fadhwl: ' . self::LABELS[$type], 'Sheikh Abul Fadhwl · Fungua kwenye app', null];
        if ($id === null || !ctype_digit($id)) return $fallback;

        try {
            switch ($type) {
                case 'album':
                    $m = \App\Models\Album::find($id);
                    if ($m) return [$m->name, $this->clip($m->description) ?: 'Mkusanyiko wa sauti · Sheikh Abul Fadhwl', null];
                    break;
                case 'song':
                    $m = \App\Models\Song::find($id);
                    if ($m) return [$m->title, $this->clip($m->description) ?: 'Sauti · Sheikh Abul Fadhwl', $m->file];
                    break;
                case 'book':
                    $m = \App\Models\Book::find($id);
                    if ($m) return [$m->title, $this->clip($m->description) ?: 'Kitabu · ' . ($m->author ?: 'Sheikh Abul Fadhwl'), $m->file];
                    break;
                case 'article':
                    $m = \App\Models\Article::find($id);
                    if ($m) return [$m->title, $this->clip($m->description) ?: 'Makala · Sheikh Abul Fadhwl', $m->file];
                    break;
                case 'stream':
                    $m = \App\Models\Stream::find($id);
                    if ($m) return [$m->title, $this->clip($m->description) ?: 'Darsa mubaashara · Sheikh Abul Fadhwl', null];
                    break;
                case 'announcement':
                    $m = \App\Models\Announcement::find($id);
                    if ($m) return ['Tangazo', $this->clip($m->news), null];
                    break;
            }
        } catch (\Throwable $e) {
            // preview is optional; never break the landing page
        }
        return $fallback;
    }

    private function clip(?string $t, int $n = 150): string
    {
        $t = trim(preg_replace('/\s+/', ' ', strip_tags((string) $t)));
        return mb_strlen($t) > $n ? mb_substr($t, 0, $n - 1) . '…' : $t;
    }
}
