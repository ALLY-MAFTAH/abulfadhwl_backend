<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Announcement;
use App\Models\Answer;
use App\Models\AnsweredQuestion;
use App\Models\Article;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\History;
use App\Models\Link;
use App\Models\Question;
use App\Models\Slide;
use App\Models\Song;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        $albums = Album::all();
        $songs = Song::all();
        $books = Book::all();
        $links = Link::all();
        $articles = Article::all();
        $streams = Stream::all();
        $questions = AnsweredQuestion::all();
        $slides = Slide::all();
        $histories = History::all();
        $announcements = Announcement::all();
        $comments = Comment::all();
        $users = User::all();

        return view('home')->with(['users' => $users, 'categories' => $categories, 'albums' => $albums, 'songs' => $songs, 'books' => $books, 'links' => $links, 'articles' => $articles, 'comments' => $comments, 'streams' => $streams, 'questions' => $questions, 'histories' => $histories, 'slides' => $slides, 'announcements' => $announcements,]);
    }
}
