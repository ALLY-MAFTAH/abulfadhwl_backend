<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Announcement;
use App\Models\AnsweredQuestion;
use App\Models\Article;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\History;
use App\Models\Link;
use App\Models\Slide;
use App\Models\Song;
use App\Models\Stream;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        // Public landing page for guests; the dashboard needs a login.
        $this->middleware('auth')->except('landing');
    }

    /** "/" — dashboard for admins, public landing page for everyone else. */
    public function landing()
    {
        $lang = in_array(request('lang'), ['sw', 'en', 'ar'], true) ? request('lang')
            : (in_array(request()->cookie('lang'), ['sw', 'en', 'ar'], true) ? request()->cookie('lang') : 'sw');
        return response()->view('site', [
            'lang' => $lang,
            'songs' => collect(),
            'books' => collect(),
            'stream' => Stream::where('status', 1)->latest()->first(),
            'histories' => collect(), // history lives inside the app only
            'links' => collect(), // social links live inside the app only
            'counts' => [
                'songs' => Song::count(),
                'books' => Book::count(),
                'articles' => Article::count(),
                'albums' => Album::count(),
                'answers' => AnsweredQuestion::where(function ($q) { $q->whereNotNull('textAns')->orWhereNotNull('audioAns'); })->count(),
            ],
        ])->cookie('lang', $lang, 525600);
    }

    public function index()
    {
        $stats = [
            ['Sauti', Song::count(), 'fa-headphones', '#3b63d6', 'categories'],
            ['Vitabu', Book::count(), 'fa-book', '#e9b23c', 'books'],
            ['Makala', Article::count(), 'fa-file-alt', '#22c27a', 'articles'],
            ['Matangazo', Announcement::count(), 'fa-bullhorn', '#f2762e', 'announcements'],
            ['Maoni', Comment::count(), 'fa-comments', '#8b6cf0', 'comments'],
            ['Watumiaji', User::count(), 'fa-users', '#3fc8e4', 'users'],
        ];

        $pendingQuestions = AnsweredQuestion::whereNull('textAns')->whereNull('audioAns')->latest()->take(5)->get();

        return view('home', [
            'stats' => $stats,
            'liveStream' => Stream::where('status', 1)->first() ?: Stream::forToday(),
            'pendingQuestions' => $pendingQuestions,
            'pendingCount' => AnsweredQuestion::whereNull('textAns')->whereNull('audioAns')->count(),
            'latestComments' => Comment::latest()->take(5)->get(),
            'latestSongs' => Song::latest()->take(5)->get(),
            'latestBooks' => Book::latest()->take(4)->get(),
            'latestArticles' => Article::latest()->take(4)->get(),
        ]);
    }
}
