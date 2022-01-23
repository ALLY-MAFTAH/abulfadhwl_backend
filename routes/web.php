<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function () {
    // });
    // CATEGORIES ROUTES
    Route::get('categories', 'CategoryController@getAllCategories')->name('categories');
    Route::post('category', 'CategoryController@postCategory')->name('add_category');
    Route::get('delete_category/{categoryId}', 'CategoryController@deleteCategory')->name('delete_category');
    Route::get('category/{categoryId}', 'CategoryController@getSingleCategory')->name('category');
    Route::get('edit_category/{categoryId}', 'CategoryController@putCategory')->name('edit_category');

    // ALBUMS ROUTES
    Route::get('albums', ['uses' => 'AlbumController@getAllAlbums'])->name('albums');
    Route::get('edit_album/{albumId}', ['uses' => 'AlbumController@putAlbum'])->name('edit_album');
    Route::post('album/{categoryId}', ['uses' => 'AlbumController@postAlbum'])->name('add_album');
    Route::get('album/{albumId}', ['uses' => 'AlbumController@getSingleAlbum'])->name('album');
    Route::get('delete_album/{albumId}', ['uses' => 'AlbumController@deleteAlbum'])->name('delete_album');


    // SONGS ROUTES
    Route::get('songs', ['uses' => 'SongController@getAllSongs'])->name('songs');
    Route::get('edit_song/{songId}', ['uses' => 'SongController@putSong'])->name('edit_song');
    Route::post('song/{albumId}', ['uses' => 'SongController@postSong'])->name('add_song');
    Route::get('song/{songId}', ['uses' => 'SongController@getSingleSong'])->name('song');
    Route::get('delete_song/{songId}', ['uses' => 'SongController@deleteSong'])->name('delete_song');
    Route::get('song/file/{songId}', ['uses' => 'SongController@viewSongFile'])->name('song_file');

    // BOOKS ROUTES
    Route::get('books', ['uses' => 'BookController@getAllBooks'])->name('books');
    Route::post('book', ['uses' => 'BookController@postBook'])->name('add_book');
    Route::get('edit_book/{bookId}', ['uses' => 'BookController@putBook'])->name('edit_book');
    Route::get('book/{bookId}', ['uses' => 'BookController@getSingleBook'])->name('book');
    Route::get('delete_book/{bookId}', ['uses' => 'BookController@deleteBook'])->name('delete_book');
    Route::get('book/file/{bookId}', ['uses' => 'BookController@viewBookFile'])->name('book_file');
    Route::get('book/cover/{bookId}', ['uses' => 'BookController@viewBookCover'])->name('book_cover');

    // ARTICLES ROUTES
    Route::get('articles', ['uses' => 'ArticleController@getAllArticles'])->name('articles');
    Route::post('article', ['uses' => 'ArticleController@postArticle'])->name('add_article');
    Route::get('edit_article/{articleId}', ['uses' => 'ArticleController@putArticle'])->name('edit_article');
    Route::get('article/{articleId}', ['uses' => 'ArticleController@getSingleArticle'])->name('article');
    Route::get('delete_article/{articleId}', ['uses' => 'ArticleController@deleteArticle'])->name('delete_article');
    Route::get('article/article_file/{articleId}', ['uses' => 'ArticleController@viewArticleFile'])->name('article_file');
    Route::get('article/article_cover/{articleId}', ['uses' => 'ArticleController@viewArticleCover'])->name('article_cover');

    // HISTORIES ROUTES
    Route::get('histories', ['uses' => 'HistoryController@getAllHistories'])->name('histories');
    Route::post('history', ['uses' => 'HistoryController@postHistory'])->name('add_history');
    Route::get('edit_history/{historyId}', ['uses' => 'HistoryController@putHistory'])->name('edit_history');
    Route::get('history/{historyId}', ['uses' => 'HistoryController@getSingleHistory'])->name('history');
    Route::get('delete_history/{historyId}', ['uses' => 'HistoryController@deleteHistory'])->name('delete_history');

    // SLIDES ROUTES
    Route::get('slides', ['uses' => 'SlideController@getAllSlides'])->name('slides');
    Route::post('slide', ['uses' => 'SlideController@postSlide'])->name('add_slide');
    Route::get('slide/{slideId}', ['uses' => 'SlideController@getSingleSlide'])->name('slide');
    Route::get('delete_slide/{slideId}', ['uses' => 'SlideController@deleteSlide'])->name('delete_slide');
    Route::get('slide/file/{slideId}', ['uses' => 'SlideController@viewSlideFile'])->name('slide_file');


    // ANNOUNCEMENTS ROUTES
    Route::get('announcements', ['uses' => 'AnnouncementController@getAllAnnouncements'])->name('announcements');
    Route::post('announcement', ['uses' => 'AnnouncementController@postAnnouncement'])->name('add_announcement');
    Route::get('edit_announcement/{announcementId}', ['uses' => 'AnnouncementController@putAnnouncement'])->name('edit_announcement');
    Route::get('announcement/{announcementId}', ['uses' => 'AnnouncementController@getSingleAnnouncement'])->name('announcement');
    Route::get('delete_announcement/{announcementId}', ['uses' => 'AnnouncementController@deleteAnnouncement'])->name('delete_announcement');


    // STREAMS ROUTES
    Route::get('streams', ['uses' => 'StreamController@getAllStreams'])->name('streams');
    Route::post('stream', ['uses' => 'StreamController@postStream'])->name('add_stream');
    Route::get('edit_stream/{streamId}', ['uses' => 'StreamController@putStream'])->name('edit_stream');
    Route::get('stream/{streamId}', ['uses' => 'StreamController@getSingleStream'])->name('stream');
    Route::get('delete_stream/{streamId}', ['uses' => 'StreamController@deleteStream'])->name('delete_stream');
    Route::get('stream/timetable/{streamId}', ['uses' => 'StreamController@viewTimetableFile'])->name('timetable');



    // LINKS ROUTES
    Route::get('links', ['uses' => 'LinkController@getAllLinks'])->name('links');
    Route::post('link', ['uses' => 'LinkController@postLink'])->name('add_link');
    Route::get('edit_link/{linkId}', ['uses' => 'LinkController@putLink'])->name('edit_link');
    Route::get('link/{linkId}', ['uses' => 'LinkController@getSingleLink'])->name('link');
    Route::get('delete_link/{linkId}', ['uses' => 'LinkController@deleteLink'])->name('delete_link');
    Route::get('link/icon/{linkId}', ['uses' => 'LinkController@viewIconFile'])->name('link_icon');


    // COMMENTS ROUTES
    Route::get('comments', ['uses' => 'CommentController@getAllComments'])->name('comments');
    Route::get('comment/{commentId}', ['uses' => 'CommentController@getSingleComment'])->name('comment');
    Route::get('delete_comment/{commentId}', ['uses' => 'CommentController@deleteComment'])->name('delete_comment');

    // QUESTIONS ROUTES
    Route::get('questions', ['uses' => 'QuestionController@getAllQuestions'])->name('questions');
    Route::get('question/{questionId}', ['uses' => 'QuestionController@getSingleQuestion'])->name('question');
    Route::get('delete_question/{questionId}', ['uses' => 'QuestionController@deleteQuestion'])->name('delete_question');
    Route::get('edit_question/{questionId}', ['uses' => 'QuestionController@putQuestion'])->name('edit_question');

    // ANSWERS AND QUESTIONS ROUTES
    Route::get('answers', ['uses' => 'AnswerController@getAllAnswers'])->name('answers');
    Route::get('answer/{answerId}', ['uses' => 'AnswerController@getSingleAnswer'])->name('answer');
    Route::post('answer', ['uses' => 'AnswerController@postAnswer'])->name('add_answer');
    Route::get('delete_answer/{answerId}', ['uses' => 'AnswerController@deleteAnswer'])->name('delete_answer');
    Route::put('edit_answer/{answerId}', ['uses' => 'AnswerController@putAnswer'])->name('edit_answer');

    // USERS ROUTES
    Route::get('users', ['uses' => 'UserController@getAllUsers'])->name('users');
    Route::get('user/{userId}', ['uses' => 'UserController@getSingleUser'])->name('user');
    Route::post('user', ['uses' => 'UserController@postUser'])->name('add_user');
    Route::get('delete_user/{userId}', ['uses' => 'UserController@deleteUser'])->name('delete_user');
    Route::put('edit_user/{userId}', ['uses' => 'UserController@putUser'])->name('edit_user');

    // // USERS ROUTES
    // Route::post('login', ['uses' => 'UserController@login']);
    // Route::post('logout', ['uses' => 'UserController@logout']);
    // Route::get('users', ['uses' => 'UserController@getAllUsers']);
    // Route::get('user/{userId}', ['uses' => 'UserController@getUser']);
    // Route::put('user/{userId}', ['uses' => 'UserController@putUser']);
    // Route::post('register', ['uses' => 'UserController@registerUser']);
    // Route::delete('user/{userId}', ['uses' => 'UserController@deleteUser']);
    // Route::post('user/{userId}', ['uses' => 'UserController@assignRole']);



});
