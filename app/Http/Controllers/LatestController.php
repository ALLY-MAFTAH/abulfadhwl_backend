<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Book;
use App\Models\Song;
use Illuminate\Http\Request;

/**
 * Newest content across the app (audio, books, articles), newest first.
 * Feeds the app's "Vipya" (what's new) button. Public, read-only.
 *
 * GET /api/latest?limit=12   (1 to 30)
 */
class LatestController extends Controller
{
    public function index(Request $request)
    {
        $limit = max(1, min(30, (int) $request->query('limit', 12)));

        $date = fn ($model) => $model->created_at ? $model->created_at->toIso8601String() : null;

        $songs = Song::with('album:id,name')->latest()->latest('id')->take($limit)->get()
            ->map(fn ($s) => [
                'type' => 'song',
                'id' => (int) $s->id,
                'title' => $s->title,
                'subtitle' => optional($s->album)->name,
                'album_id' => (int) $s->album_id,
                'duration' => $s->duration,
                'added_at' => $date($s),
            ]);

        $books = Book::latest()->latest('id')->take($limit)->get()
            ->map(fn ($b) => [
                'type' => 'book',
                'id' => (int) $b->id,
                'title' => $b->title,
                'subtitle' => $b->author,
                'added_at' => $date($b),
            ]);

        $articles = Article::latest()->latest('id')->take($limit)->get()
            ->map(fn ($a) => [
                'type' => 'article',
                'id' => (int) $a->id,
                'title' => $a->title,
                'subtitle' => $a->pub_year,
                'added_at' => $date($a),
            ]);

        $items = collect()
            ->concat($songs)->concat($books)->concat($articles)
            ->sortByDesc(fn ($i) => $i['added_at'] ?? '')
            ->take($limit)
            ->values();

        return response()->json(['items' => $items], 200, ['Cache-Control' => 'public, max-age=120']);
    }
}
