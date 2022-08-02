<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
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

//  Routes for Album
Route::get('albums', [AlbumController::class,'getAllAlbums']);
Route::put('album/{albumId}', [AlbumController::class,'putAlbum']);
Route::post('album/{categoryId}', [AlbumController::class,'postAlbum']);
Route::get('album/{albumId}', [AlbumController::class,'getSingleAlbum']);
Route::delete('album/{albumId}', [AlbumController::class,'deleteAlbum']);


//  Routes for Song
Route::get('song-names', [SongController::class,'getAllSongNames']);
Route::get('songs', [SongController::class,'getAllSongs']);
Route::put('song/{songId}', [SongController::class,'putSong']);
Route::post('song/{albumId}', [SongController::class,'postSong']);
Route::get('song/{songId}', [SongController::class,'getSingleSong']);
Route::delete('song/{songId}', [SongController::class,'deleteSong']);
Route::get('song/file/{songId}', [SongController::class,'viewSongFile']);

//  Routes for Book
Route::post('book', [BookController::class,'postBook']);
Route::get('books', [BookController::class,'getAllBooks']);
Route::put('book/{bookId}', [BookController::class,'putBook']);
Route::get('book/{bookId}', [BookController::class,'getSingleBook']);
Route::delete('book/{bookId}', [BookController::class,'deleteBook']);
Route::get('book/file/{bookId}', [BookController::class,'viewBookFile']);
Route::get('book/cover/{bookId}', [BookController::class,'viewBookCover']);



//  Routes for Category
Route::post('category', [CategoryController::class,'postCategory']);
Route::get('categories', [CategoryController::class,'getAllCategories']);
Route::put('category/{categoryId}', [CategoryController::class,'putCategory']);
Route::get('category/{categoryId}', [CategoryController::class,'getSingleCategory']);
Route::delete('category/{categoryId}', [CategoryController::class,'deleteCategory']);


//  Routes for History
Route::post('history', [HistoryController::class,'postHistory']);
Route::get('histories', [HistoryController::class,'getAllHistories']);
Route::put('history/{historyId}', [HistoryController::class,'putHistory']);
Route::get('history/{historyId}', [HistoryController::class,'getSingleHistory']);
Route::delete('history/{historyId}', [HistoryController::class,'deleteHistory']);


//  Routes for Questions and Answers
Route::get('answeredQuestions', [AnsweredQuestionController::class,'getAllAnsweredQuestions']);
Route::post('question', [AnsweredQuestionController::class,'postQuestion']);
Route::get('questions', [QuestionController::class,'getAllQuestions']);
Route::get('answer/audioAns/{questionId}', [AnsweredQuestionController::class,'viewAudioAnswer']);


//  Routes for Slides
Route::post('slide', [SlideController::class,'postSlide']);
Route::get('slides', [SlideController::class,'getAllSlides']);
Route::get('slide/{slideId}', [SlideController::class,'getSingleSlide']);
Route::delete('slide/{slideId}', [SlideController::class,'deleteSlide']);
Route::get('slide/file/{slideId}', [SlideController::class,'viewSlideFile']);



//  Routes for Articles
Route::post('article', [ArticleController::class,'postArticle']);
Route::get('articles', [ArticleController::class,'getAllArticles']);
Route::put('article/{articleId}', [ArticleController::class,'putArticle']);
Route::get('article/{articleId}', [ArticleController::class,'getSingleArticle']);
Route::delete('article/{articleId}', [ArticleController::class,'deleteArticle']);
Route::get('article/file/{articleId}', [ArticleController::class,'viewArticleFile']);
Route::get('article/cover/{articleId}', [ArticleController::class,'viewArticleCover']);


//  Routes for Announcement
Route::post('announcement', [AnnouncementController::class,'postAnnouncement']);
Route::get('announcements', [AnnouncementController::class,'getAllAnnouncements']);
Route::put('announcement/{announcementId}', [AnnouncementController::class,'putAnnouncement']);
Route::get('announcement/{announcementId}', [AnnouncementController::class,'getSingleAnnouncement']);
Route::delete('announcement/{announcementId}', [AnnouncementController::class,'deleteAnnouncement']);


//  Routes for Streams
Route::post('stream', [StreamController::class,'postStream']);
Route::get('streams', [StreamController::class,'getAllStreams']);
Route::put('stream/{streamId}', [StreamController::class,'putStream']);
Route::get('stream/{streamId}', [StreamController::class,'getSingleStream']);
Route::delete('stream/{streamId}', [StreamController::class,'deleteStream']);
Route::get('stream/timetable/{streamId}', [StreamController::class,'viewTimetableFile']);



//  Routes for Links
Route::post('link', [LinkController::class,'postLink']);
Route::get('links', [LinkController::class,'getAllLinks']);
Route::put('link/{linkId}', [LinkController::class,'putLink']);
Route::get('link/{linkId}', [LinkController::class,'getSingleLink']);
Route::delete('link/{linkId}', [LinkController::class,'deleteLink']);
Route::get('link/icon/{linkId}', [LinkController::class,'viewIconFile']);


//  Routes for Comments
Route::post('comment', [CommentController::class,'postComment']);
Route::get('comments', [CommentController::class,'getAllComments']);
Route::put('comment/{commentId}', [CommentController::class,'putComment']);
Route::get('comment/{commentId}', [CommentController::class,'getSingleComment']);
Route::delete('comment/{commentId}', [CommentController::class,'deleteComment']);

// // Routes for Users
//  Route::post('login', [UserController::class,'login']);
// Route::post('logout', [UserController::class,'logout']);
// Route::get('users', [UserController::class,'getAllUsers']);
// Route::get('user/{userId}', [UserController::class,'getUser']);
// Route::put('user/{userId}', [UserController::class,'putUser']);
// Route::post('register', [UserController::class,'registerUser']);
// Route::delete('user/{userId}', [UserController::class,'deleteUser']);
// Route::post('user/{userId}', [UserController::class,'assignRole']);
