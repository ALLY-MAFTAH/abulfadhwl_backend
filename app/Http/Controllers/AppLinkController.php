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

        return view('app_link', [
            'label' => self::LABELS[$type],
            'deepLink' => 'abulfadhwl://open/' . $type . ($id !== null ? '/' . $id : ''),
            'iosUrl' => config('app.ios_store_url'),
            'androidUrl' => config('app.android_store_url'),
        ]);
    }
}
