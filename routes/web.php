<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnsweredQuestionController;
use App\Http\Controllers\PushNotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => 'auth'], function () {

    // CATEGORIES ROUTES
    Route::get('categories', [App\Http\Controllers\CategoryController::class, 'getAllCategories'])->name('categories');
    Route::post('category',  [App\Http\Controllers\CategoryController::class, 'postCategory'])->name('add_category');
    Route::get('delete_category/{categoryId}', [App\Http\Controllers\CategoryController::class, 'deleteCategory'])->name('delete_category');
    Route::get('category/{categoryId}',  [App\Http\Controllers\CategoryController::class, 'getSingleCategory'])->name('category');
    Route::get('edit_category/{categoryId}', [App\Http\Controllers\CategoryController::class, 'putCategory'])->name('edit_category');

    // ALBUMS ROUTES
    Route::get('albums', [AlbumController::class,'getAllAlbums'])->name('albums');
    Route::get('edit_album/{albumId}', [AlbumController::class,'putAlbum'])->name('edit_album');
    Route::post('album/{categoryId}', [AlbumController::class,'postAlbum'])->name('add_album');
    Route::get('album/{albumId}', [AlbumController::class,'getSingleAlbum'])->name('album');
    Route::get('delete_album/{albumId}', [AlbumController::class,'deleteAlbum'])->name('delete_album');


    // SONGS ROUTES
    Route::get('songs', [SongController::class,'getAllSongs'])->name('songs');
    Route::put('edit_song/{songId}', [SongController::class,'putSong'])->name('edit_song');
    Route::post('song/{albumId}', [SongController::class,'postSong'])->name('add_song');
    Route::get('song/{songId}', [SongController::class,'getSingleSong'])->name('song');
    Route::get('delete_song/{songId}', [SongController::class,'deleteSong'])->name('delete_song');
    Route::get('song/file/{songId}', [SongController::class,'viewSongFile'])->name('song_file');

    // BOOKS ROUTES
    Route::get('books', [BookController::class,'getAllBooks'])->name('books');
    Route::post('book', [BookController::class,'postBook'])->name('add_book');
    Route::get('edit_book/{bookId}', [BookController::class,'putBook'])->name('edit_book');
    Route::get('book/{bookId}', [BookController::class,'getSingleBook'])->name('book');
    Route::get('delete_book/{bookId}', [BookController::class,'deleteBook'])->name('delete_book');
    Route::get('book/file/{bookId}', [BookController::class,'viewBookFile'])->name('book_file');
    Route::get('book/cover/{bookId}', [BookController::class,'viewBookCover'])->name('book_cover');

    // ARTICLES ROUTES
    Route::get('articles', [ArticleController::class,'getAllArticles'])->name('articles');
    Route::post('article', [ArticleController::class,'postArticle'])->name('add_article');
    Route::get('edit_article/{articleId}', [ArticleController::class,'putArticle'])->name('edit_article');
    Route::get('article/{articleId}', [ArticleController::class,'getSingleArticle'])->name('article');
    Route::get('delete_article/{articleId}', [ArticleController::class,'deleteArticle'])->name('delete_article');
    Route::get('article/article_file/{articleId}', [ArticleController::class,'viewArticleFile'])->name('article_file');

    // HISTORIES ROUTES
    Route::get('histories', [HistoryController::class,'getAllHistories'])->name('histories');
    Route::post('history', [HistoryController::class,'postHistory'])->name('add_history');
    Route::get('edit_history/{historyId}', [HistoryController::class,'putHistory'])->name('edit_history');
    Route::get('history/{historyId}', [HistoryController::class,'getSingleHistory'])->name('history');
    Route::get('delete_history/{historyId}', [HistoryController::class,'deleteHistory'])->name('delete_history');

    // SLIDES ROUTES
    Route::get('slides', [SlideController::class,'getAllSlides'])->name('slides');
    Route::post('slide', [SlideController::class,'postSlide'])->name('add_slide');
    Route::get('slide/{slideId}', [SlideController::class,'getSingleSlide'])->name('slide');
    Route::get('delete_slide/{slideId}', [SlideController::class,'deleteSlide'])->name('delete_slide');
    Route::get('slide/file/{slideId}', [SlideController::class,'viewSlideFile'])->name('slide_file');


    // ANNOUNCEMENTS ROUTES
    Route::get('announcements', [AnnouncementController::class,'getAllAnnouncements'])->name('announcements');
    Route::post('announcement', [AnnouncementController::class,'postAnnouncement'])->name('add_announcement');
    Route::get('edit_announcement/{announcementId}', [AnnouncementController::class,'putAnnouncement'])->name('edit_announcement');
    Route::get('announcement/{announcementId}', [AnnouncementController::class,'getSingleAnnouncement'])->name('announcement');
    Route::get('delete_announcement/{announcementId}', [AnnouncementController::class,'deleteAnnouncement'])->name('delete_announcement');


    // STREAMS ROUTES
    Route::get('streams', [StreamController::class,'getAllStreams'])->name('streams');
    Route::post('stream', [StreamController::class,'postStream'])->name('add_stream');
    Route::get('stream/{streamId}', [StreamController::class,'getSingleStream'])->name('stream');
    Route::get('delete_stream/{streamId}', [StreamController::class,'deleteStream'])->name('delete_stream');
    Route::get('stream/timetable/{streamId}', [StreamController::class,'viewTimetableFile'])->name('timetable');
    Route::put('stream/{stream}/status', [StreamController::class,'toggleStatus'])->name('stream.toggle_status');
    Route::put('edit_stream/{streamId}', [StreamController::class,'putStream'])->name('edit_stream');


    // LINKS ROUTES
    Route::get('links', [LinkController::class,'getAllLinks'])->name('links');
    Route::post('link', [LinkController::class,'postLink'])->name('add_link');
    Route::put('edit_link/{linkId}', [LinkController::class,'putLink'])->name('edit_link');
    Route::get('link/{linkId}', [LinkController::class,'getSingleLink'])->name('link');
    Route::get('delete_link/{linkId}', [LinkController::class,'deleteLink'])->name('delete_link');
    Route::put('link/{link}/status', [LinkController::class,'toggleStatus'])->name('link.toggle_status');
    Route::get('link/icon/{linkId}', [LinkController::class,'viewIconFile'])->name('link_icon');


    // COMMENTS ROUTES
    Route::get('comments', [CommentController::class,'getAllComments'])->name('comments');
    Route::get('comment/{commentId}', [CommentController::class,'getSingleComment'])->name('comment');
    Route::get('delete_comment/{commentId}', [CommentController::class,'deleteComment'])->name('delete_comment');

    // QUESTIONS ROUTES
    Route::get('questions', [QuestionController::class,'getAllQuestions'])->name('questions');
    Route::get('question/{questionId}', [QuestionController::class,'getSingleQuestion'])->name('question');
    Route::get('delete_question/{questionId}', [QuestionController::class,'deleteQuestion'])->name('delete_question');
    Route::get('edit_question/{questionId}', [QuestionController::class,'putQuestion'])->name('edit_question');

    // ANSWERS AND QUESTIONS ROUTES
    Route::get('allQuestions', [AnsweredQuestionController::class,'getAllQuestions'])->name('allQuestions');
    Route::get('answer/{answerId}', [AnsweredQuestionController::class,'getSingleAnswer'])->name('answer');
    Route::post('answer', [AnsweredQuestionController::class,'postAnswer'])->name('add_answer');
    Route::get('delete_answer/{answerId}', [AnsweredQuestionController::class,'deleteAnswer'])->name('delete_answer');
    Route::put('edit_answer/{answerId}', [AnsweredQuestionController::class,'putAnsweredQuestion'])->name('edit_answer');

    // USERS ROUTES
    Route::get('users', [UserController::class,'getAllUsers'])->name('users');
    Route::get('user/{userId}', [UserController::class,'getSingleUser'])->name('user');
    Route::post('user', [UserController::class,'postUser'])->name('add_user');
    Route::get('delete_user/{userId}', [UserController::class,'deleteUser'])->name('delete_user');
    Route::put('edit_user/{userId}', [UserController::class,'putUser'])->name('edit_user');

    // NOTIFICATIONS ROUTES
    Route::post('send',[PushNotificationController::class, 'bulksend'])->name('bulksend');
    Route::get('notifications', [PushNotificationController::class, 'index'])->name('notifications');
    Route::get('delete-notification/{notification}', [PushNotificationController::class, 'destroy'])->name('delete-notification');

});
