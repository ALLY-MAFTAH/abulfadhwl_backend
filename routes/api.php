<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('albums', ['uses' => 'AlbumController@getAllAlbums']);
Route::put('album/{albumId}', ['uses' => 'AlbumController@putAlbum']);
Route::post('album/{categoryId}', ['uses' => 'AlbumController@postAlbum']);
Route::get('album/{albumId}', ['uses' => 'AlbumController@getSingleAlbum']);
Route::delete('album/{albumId}', ['uses' => 'AlbumController@deleteAlbum']);


//  Routes for Song
Route::get('song-names', ['uses' => 'SongController@getAllSongNames']);
Route::get('songs', ['uses' => 'SongController@getAllSongs']);
Route::put('song/{songId}', ['uses' => 'SongController@putSong']);
Route::post('song/{albumId}', ['uses' => 'SongController@postSong']);
Route::get('song/{songId}', ['uses' => 'SongController@getSingleSong']);
Route::delete('song/{songId}', ['uses' => 'SongController@deleteSong']);
Route::get('song/file/{songId}', ['uses' => 'SongController@viewSongFile']);

//  Routes for Book
Route::post('book', ['uses' => 'BookController@postBook']);
Route::get('books', ['uses' => 'BookController@getAllBooks']);
Route::put('book/{bookId}', ['uses' => 'BookController@putBook']);
Route::get('book/{bookId}', ['uses' => 'BookController@getSingleBook']);
Route::delete('book/{bookId}', ['uses' => 'BookController@deleteBook']);
Route::get('book/file/{bookId}', ['uses' => 'BookController@viewBookFile']);
Route::get('book/cover/{bookId}', ['uses' => 'BookController@viewBookCover']);



//  Routes for Category
Route::post('category', ['uses' => 'CategoryController@postCategory']);
Route::get('categories', ['uses' => 'CategoryController@getAllCategories']);
Route::put('category/{categoryId}', ['uses' => 'CategoryController@putCategory']);
Route::get('category/{categoryId}', ['uses' => 'CategoryController@getSingleCategory']);
Route::delete('category/{categoryId}', ['uses' => 'CategoryController@deleteCategory']);


//  Routes for History
Route::post('history', ['uses' => 'HistoryController@postHistory']);
Route::get('histories', ['uses' => 'HistoryController@getAllHistories']);
Route::put('history/{historyId}', ['uses' => 'HistoryController@putHistory']);
Route::get('history/{historyId}', ['uses' => 'HistoryController@getSingleHistory']);
Route::delete('history/{historyId}', ['uses' => 'HistoryController@deleteHistory']);


//  Routes for Questions and Answers
Route::get('answeredQuestions', ['uses' => 'AnsweredQuestionController@getAllAnsweredQuestions']);
Route::post('question', ['uses' => 'AnsweredQuestionController@postQuestion']);
Route::get('questions', ['uses' => 'QuestionController@getAllQuestions']);
Route::get('answer/audioAns/{questionId}', ['uses' => 'AnsweredQuestionController@viewAudioAnswer']);



//  Routes for Slides
Route::post('slide', ['uses' => 'SlideController@postSlide']);
Route::get('slides', ['uses' => 'SlideController@getAllSlides']);
Route::get('slide/{slideId}', ['uses' => 'SlideController@getSingleSlide']);
Route::delete('slide/{slideId}', ['uses' => 'SlideController@deleteSlide']);
Route::get('slide/file/{slideId}', ['uses' => 'SlideController@viewSlideFile']);



//  Routes for Articles
Route::post('article', ['uses' => 'ArticleController@postArticle']);
Route::get('articles', ['uses' => 'ArticleController@getAllArticles']);
Route::put('article/{articleId}', ['uses' => 'ArticleController@putArticle']);
Route::get('article/{articleId}', ['uses' => 'ArticleController@getSingleArticle']);
Route::delete('article/{articleId}', ['uses' => 'ArticleController@deleteArticle']);
Route::get('article/file/{articleId}', ['uses' => 'ArticleController@viewArticleFile']);
Route::get('article/cover/{articleId}', ['uses' => 'ArticleController@viewArticleCover']);


//  Routes for Announcement
Route::post('announcement', ['uses' => 'AnnouncementController@postAnnouncement']);
Route::get('announcements', ['uses' => 'AnnouncementController@getAllAnnouncements']);
Route::put('announcement/{announcementId}', ['uses' => 'AnnouncementController@putAnnouncement']);
Route::get('announcement/{announcementId}', ['uses' => 'AnnouncementController@getSingleAnnouncement']);
Route::delete('announcement/{announcementId}', ['uses' => 'AnnouncementController@deleteAnnouncement']);


//  Routes for Streams
Route::post('stream', ['uses' => 'StreamController@postStream']);
Route::get('streams', ['uses' => 'StreamController@getAllStreams']);
Route::put('stream/{streamId}', ['uses' => 'StreamController@putStream']);
Route::get('stream/{streamId}', ['uses' => 'StreamController@getSingleStream']);
Route::delete('stream/{streamId}', ['uses' => 'StreamController@deleteStream']);
Route::get('stream/timetable/{streamId}', ['uses' => 'StreamController@viewTimetableFile']);



//  Routes for Links
Route::post('link', ['uses' => 'LinkController@postLink']);
Route::get('links', ['uses' => 'LinkController@getAllLinks']);
Route::put('link/{linkId}', ['uses' => 'LinkController@putLink']);
Route::get('link/{linkId}', ['uses' => 'LinkController@getSingleLink']);
Route::delete('link/{linkId}', ['uses' => 'LinkController@deleteLink']);
Route::get('link/icon/{linkId}', ['uses' => 'LinkController@viewIconFile']);


//  Routes for Comments
Route::post('comment', ['uses' => 'CommentController@postComment']);
Route::get('comments', ['uses' => 'CommentController@getAllComments']);
Route::put('comment/{commentId}', ['uses' => 'CommentController@putComment']);
Route::get('comment/{commentId}', ['uses' => 'CommentController@getSingleComment']);
Route::delete('comment/{commentId}', ['uses' => 'CommentController@deleteComment']);

// // Routes for Users
//  Route::post('login', ['uses' => 'UserController@login']);
// Route::post('logout', ['uses' => 'UserController@logout']);
// Route::get('users', ['uses' => 'UserController@getAllUsers']);
// Route::get('user/{userId}', ['uses' => 'UserController@getUser']);
// Route::put('user/{userId}', ['uses' => 'UserController@putUser']);
// Route::post('register', ['uses' => 'UserController@registerUser']);
// Route::delete('user/{userId}', ['uses' => 'UserController@deleteUser']);
// Route::post('user/{userId}', ['uses' => 'UserController@assignRole']);
