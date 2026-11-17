<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LatestController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnsweredQuestionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Public, read-only (what the mobile app needs)
|--------------------------------------------------------------------------
| Content only. Nothing here exposes visitor data (comments, questions).
*/
Route::get('categories', [CategoryController::class,'getAllCategories']);
Route::get('category/{categoryId}', [CategoryController::class,'getSingleCategory']);

Route::get('albums', [AlbumController::class,'getAllAlbums']);
Route::get('album/{albumId}', [AlbumController::class,'getSingleAlbum']);

Route::get('song-names', [SongController::class,'getAllSongNames']);
Route::get('songs', [SongController::class,'getAllSongs']);
Route::get('song/{songId}', [SongController::class,'getSingleSong']);
Route::get('song/file/{songId}', [SongController::class,'viewSongFile']);

// Newest audio, books and articles together, for the app's "Vipya" button.
Route::get('latest', [LatestController::class,'index']);

Route::get('books', [BookController::class,'getAllBooks']);
Route::get('book/{bookId}', [BookController::class,'getSingleBook']);
Route::get('book/file/{bookId}', [BookController::class,'viewBookFile']);
Route::get('book/cover/{bookId}', [BookController::class,'viewBookCover']);

Route::get('articles', [ArticleController::class,'getAllArticles']);
Route::get('article/{articleId}', [ArticleController::class,'getSingleArticle']);
Route::get('article/file/{articleId}', [ArticleController::class,'viewArticleFile']);

Route::get('histories', [HistoryController::class,'getAllHistories']);
Route::get('history/{historyId}', [HistoryController::class,'getSingleHistory']);

Route::get('slides', [SlideController::class,'getAllSlides']);
Route::get('slide/{slideId}', [SlideController::class,'getSingleSlide']);
Route::get('slide/file/{slideId}', [SlideController::class,'viewSlideFile']);

Route::get('announcements', [AnnouncementController::class,'getAllAnnouncements']);
Route::get('announcement/{announcementId}', [AnnouncementController::class,'getSingleAnnouncement']);

Route::get('streams', [StreamController::class,'getAllStreams']);
Route::get('stream/{streamId}', [StreamController::class,'getSingleStream']);
Route::get('stream/timetable/{streamId}', [StreamController::class,'viewTimetableFile']);

Route::get('links', [LinkController::class,'getAllLinks']);
Route::get('link/{linkId}', [LinkController::class,'getSingleLink']);
Route::get('link/icon/{linkId}', [LinkController::class,'viewIconFile']);

Route::get('answeredQuestions', [AnsweredQuestionController::class,'getAllAnsweredQuestions']);
Route::get('answer/audioAns/{questionId}', [AnsweredQuestionController::class,'viewAudioAnswer']);

/*
|--------------------------------------------------------------------------
| Public writes: the only two the app performs, rate limited
|--------------------------------------------------------------------------
| 'public-submit' = 5/minute and 30/day per IP (see RouteServiceProvider).
*/
Route::middleware('throttle:public-submit')->group(function () {
    Route::post('question', [AnsweredQuestionController::class,'postQuestion']);
    Route::post('comment', [CommentController::class,'postComment']);
});

/*
|--------------------------------------------------------------------------
| Everything that changes or reveals private data requires authentication
|--------------------------------------------------------------------------
| The admin site does NOT use these: it uses the session-authenticated web
| routes in routes/web.php. They stay available to a future token-based admin
| client via Sanctum.
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('category', [CategoryController::class,'postCategory']);
    Route::put('category/{categoryId}', [CategoryController::class,'putCategory']);
    Route::delete('category/{categoryId}', [CategoryController::class,'deleteCategory']);

    Route::put('album/{albumId}', [AlbumController::class,'putAlbum']);
    Route::post('album/{categoryId}', [AlbumController::class,'postAlbum']);
    Route::delete('album/{albumId}', [AlbumController::class,'deleteAlbum']);

    Route::put('song/{songId}', [SongController::class,'putSong']);
    Route::post('song/{albumId}', [SongController::class,'postSong']);
    Route::delete('song/{songId}', [SongController::class,'deleteSong']);

    Route::post('book', [BookController::class,'postBook']);
    Route::put('book/{bookId}', [BookController::class,'putBook']);
    Route::delete('book/{bookId}', [BookController::class,'deleteBook']);

    Route::post('history', [HistoryController::class,'postHistory']);
    Route::put('history/{historyId}', [HistoryController::class,'putHistory']);
    Route::delete('history/{historyId}', [HistoryController::class,'deleteHistory']);

    Route::post('slide', [SlideController::class,'postSlide']);
    Route::delete('slide/{slideId}', [SlideController::class,'deleteSlide']);

    Route::post('article', [ArticleController::class,'postArticle']);
    Route::put('article/{articleId}', [ArticleController::class,'putArticle']);
    Route::delete('article/{articleId}', [ArticleController::class,'deleteArticle']);

    Route::post('announcement', [AnnouncementController::class,'postAnnouncement']);
    Route::put('announcement/{announcementId}', [AnnouncementController::class,'putAnnouncement']);
    Route::delete('announcement/{announcementId}', [AnnouncementController::class,'deleteAnnouncement']);

    Route::post('stream', [StreamController::class,'postStream']);
    Route::put('stream/{streamId}', [StreamController::class,'putStream']);
    Route::delete('stream/{streamId}', [StreamController::class,'deleteStream']);

    Route::post('link', [LinkController::class,'postLink']);
    Route::put('link/{linkId}', [LinkController::class,'putLink']);
    Route::delete('link/{linkId}', [LinkController::class,'deleteLink']);

    // Visitor submissions contain names and phone numbers: never public.
    Route::get('comments', [CommentController::class,'getAllComments']);
    Route::get('comment/{commentId}', [CommentController::class,'getSingleComment']);
    Route::put('comment/{commentId}', [CommentController::class,'putComment']);
    Route::delete('comment/{commentId}', [CommentController::class,'deleteComment']);
});
